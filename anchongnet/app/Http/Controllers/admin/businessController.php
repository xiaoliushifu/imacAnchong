<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Business;
use Auth;
use DB;

use OSS\OssClient;
use OSS\Core\OssException;

class businessController extends Controller
{
    private $business;
    private $uid;
    private $accessKeyId;
    private $accessKeySecret ;
    private $endpoint;
    private $bucket;
    public function __construct()
    {
        $this->business=new Business();
        //通过Auth获取当前登录用户的id
        $this->uid=Auth::user()['users_id'];
        $this->accessKeyId=env('ALIOSS_ACCESSKEYId');
        $this->accessKeySecret=env('ALIOSS_ACCESSKEYSECRET');
        $this->endpoint=env('ALIOSS_ENDPOINT');
        $this->bucket=env('ALIOSS_BUCKET');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyType=Requester::input("type");
        //判断有无筛选标签
        if($keyType==""){
            //查出该用户所有商机
            $datas=$this->business->User($this->uid)->orderBy("created_at","desc")->paginate(8);
        }else{
            //根据标签查出该用户所有商机
            $datas=$this->business->User($this->uid)->Type($keyType)->orderBy("created_at","desc")->paginate(8);
        }
        $args=array("user"=>$this->uid,"type"=>$keyType);
        //返回数据,all代表是否是查询所有商机
        return view('admin/business/index',array("datacol"=>compact("args","datas"),'all'=>"0"));
    }

    /**
     * 所有商机查看
     *
     * @return \Illuminate\Http\Response
     */
    public function businesss()
    {
        $keyType=Requester::input("type");
        //判断有无筛选标签
        if($keyType==""){
            //查出所有商机
            $datas=$this->business->orderBy("created_at","desc")->paginate(8);
        }else{
            //根据标签查出所有商机
            $datas=$this->business->Type($keyType)->orderBy("created_at","desc")->paginate(8);
        }
        $args=array("user"=>$this->uid,"type"=>$keyType);
        //返回数据,all代表是否是查询所有商机
        return view('admin/business/index',array("datacol"=>compact("args","datas"),'all'=>"1"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/business/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\StoreBusinessRequest $request)
    {
        //定义图片变量
        $imgs="";
        //判断是否有图片
        if($request['pic']){
            foreach ($request['pic'] as $pic) {
                $imgs.=$pic.'#@#';
            }
        }
        //向business表中插入数据
        $result=DB::table('anchong_business')->insertGetId(
            [
                'users_id' => $request['uid'],
                'title' => $request['title'],
                'content'=>$request['content'],
                'tag'=>$request['tag'],
                'phone'=>$request['phone'],
                'contact'=>$request['contact'],
                'type'=>$request['type'],
                'business_status'=>1,
                'tags'=>$request['area'],
                'tags_match'=>bin2hex($request['area']),
                'endtime' => strtotime($request['endtime']),
                'created_at' => date('Y-m-d H:i:s',time()),
                'img' => $imgs,
            ]
        );
        //判断是否成功
        if($result){
            return view("admin/business/create",array('mes'=>"添加成功！"));
        }else{
            return view("admin/business/create",array('mes'=>"添加失败！"));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=$this->business->find($id);
        $data->img=trim($data->img,"#@#");
        $data->endtime=date('Y-m-d',$data->endtime);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=$this->business->find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$this->business->find($id);
        $data->title=$request['title'];
        $data->content=$request['content'];
        $data->tag=$request['tag'];
        $data->contact=$request['contact'];
        $data->phone=$request['phone'];
        $data->type=$request['type'];
        $data->tags=$request['area'];
        $data->tags_match=bin2hex($request['area']);
        $data->endtime=strtotime($request['endtime']);
        $data->created_at = date('Y-m-d H:i:s',time());
        $data->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=$this->business->find($id);
        $data->delete();
        return "删除成功";
    }

    public function editpic(Request $request,$id)
    {
        $fileType=$_FILES['file']['type'];
        $dir="business/";
        $filePath = $request['file'];
        //设置上传到阿里云oss的对象的键名
        switch ($fileType){
            case "image/png":
                $object=$dir.time().rand(100000,999999).".png";
                break;
            case "image/jpeg":
                $object=$dir.time().rand(100000,999999).".jpg";
                break;
            case "image/jpg":
                $object=$dir.time().rand(100000,999999).".jpg";
                break;
            case "image/gif":
                $object=$dir.time().rand(100000,999999).".gif";
                break;
            default:
                $object=$dir.time().rand(100000,999999).".jpg";
        }

        try {
            //实例化一个ossClient对象
            $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
            //上传文件
            $ossClient->uploadFile($this->bucket, $object, $filePath);
            //获取到上传文件的路径
            $signedUrl = $ossClient->signUrl($this->bucket, $object);
            $pos = strpos($signedUrl, "?");
            $urls = substr($signedUrl, 0, $pos);
            $url = str_replace('.oss-','.img-',$urls);
            $imgs="";
            //进行图片分隔操作
            $img=trim($request['img'],"#@#");
            if(!empty($img)){
                $img_arr=explode('#@#',$img);
                $img_arr[$request['pic']]=$url;
                foreach ($img_arr as $pic) {
                    $imgs.=$pic.'#@#';
                }
            }else{
                $imgs.=$url.'#@#';
            }
            //创建图片查询的orm模型
            $community_release=new \App\Business();
            $result=$community_release->businessupdate($id,['img'=>$imgs]);
            if($result){
                $message="上传成功";
                $isSuccess=true;
            }else{
                $message="上传失败，请稍后再试";
                $isSuccess=false;
            }
        }catch (OssException $e) {
            $message="上传失败，请稍后再试";
            $isSuccess=false;
            $url='';
            $id='';
        }
        return response()->json(['message' => $message, 'isSuccess' => $isSuccess,'url'=>$url,'imgs'=>$imgs]);
    }

    /*
    *   商机图片查看
    */
    public function imgshow($id)
    {
        //创建图片查询的orm模型
        $business=new \App\Business();
        $data=$business->quertime('img','bid='.$id)->toArray();
        //进行图片分隔操作
        $img=trim($data[0]['img'],"#@#");
        $img_arr=[];
        //判断是否有图片
        if(!empty($img)){
            $img_arr=explode('#@#',$img);
        }
        return [$img_arr,$data[0]['img'],$id];
    }

    /*
     *  删除制定商机的图片
     */
    public function delpic(Request $request,$id)
    {
        //定义图片
        $imgs="";
        //进行图片分隔操作
        $img=trim($request['img'],"#@#");
        if(!empty($img)){
            $img_arr=explode('#@#',$img);
            $img_arr[$request['pic']]="";
            foreach ($img_arr as $pic) {
                //假如pic不为空
                if($pic){
                    //拼接图片字符串
                    $imgs.=$pic.'#@#';
                }
            }
        }
        //创建图片查询的orm模型
        $community_release=new \App\Business();
        $result=$community_release->businessupdate($id,['img'=>$imgs]);
        if($result){
            return $message="删除成功";
        }else{
            return $message="删除失败";
        }
    }
}
