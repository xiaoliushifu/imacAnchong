<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Information;
use Auth;
use DB;

use OSS\OssClient;
use OSS\Core\OssException;

class informationController extends Controller
{
    private $information;
    private $infor_id;
    private $accessKeyId;
    private $accessKeySecret ;
    private $endpoint;
    private $bucket;
    public function __construct()
    {
        $this->information=new Information();
        //通过Auth获取当前登录用户的id
        $this->infor_id=Auth::user()['users_id'];
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
        if($keyType==""){
            $datas=$this->information->User($this->infor_id)->paginate(8);
        }else{
            $datas=$this->information->User($this->infor_id)->Type($keyType)->paginate(8);
        }
        $args=array("user"=>$this->infor_id,"type"=>$keyType);
        return view('admin/information/index',array("datacol"=>compact("args","datas")));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/information/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\StoreInformationRequest $request)
    {
        //开启事务处理
        DB::beginTransaction();

        //向business表中插入数据,并返回新增的主键id
        $bid=DB::table('anchong_information')->insertGetId(
            [
                'users_id' => $request['infor_id'],
                'title' => $request['title'],
                'content'=>$request['content'],  
                'contact'=>$request['contact'],
                'created_at'=>date("Y-m-d H:i:s",time()),
            ]
        );

        //向business_img表中插入数据
        for($i=0;$i<count($request['pic']);$i++){
            DB::table('anchong_business_img')->insert(
                [
                    'bid' => $bid,
                    'img' => $request['pic'][$i]
                ]
            );
        }

        //提交事务
        DB::commit();

        return view("admin/information/create",array('mes'=>"添加成功！"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=$this->information->find($id);
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
        $data=$this->information->find($id);
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
        $data->contact=$request['contact'];
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

    public function addpic(Request $request)
    {
        $fileType=$_FILES['file']['type'];
        $dir="information/";
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
            $url = substr($signedUrl, 0, $pos);

            //插入数据库并返回主键id
            $id = DB::table('anchong_business_img')->insertGetId(
                ['bid' => $request['bid'], 'img' => $url]
            );

            $message="上传成功";
            $isSuccess=true;
        }catch (OssException $e) {
            $message="上传失败，请稍后再试";
            $isSuccess=false;
            $url='';
            $id='';
        }
        return response()->json(['message' => $message, 'isSuccess' => $isSuccess,'url'=>$url,'id'=>$id]);
    }
}
