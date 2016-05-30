<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Good;
use App\Shop;
use Auth;
use DB;

use OSS\OssClient;
use OSS\Core\OssException;

class commodityController extends Controller
{
    private $good;
    private $uid;
    private $sid;
    private $gid;

    private $accessKeyId;
    private $accessKeySecret ;
    private $endpoint;
    private $bucket;

    public function __construct()
    {
        $this->good=new Good();
        //通过Auth获取当前登录用户的id
        $this->uid=Auth::user()['users_id'];
        //通过用户获取商铺id
        $this->sid=Shop::Uid($this->uid)->sid;
        //初始化gid属性为空
        $this->gid="";

        $this->accessKeyId="HJjYLnySPG4TBdFp";
        $this->accessKeySecret="Ifv0SNWwch5sgFcrM1bDthqyy4BmOa";
        $this->endpoint="oss-cn-hangzhou.aliyuncs.com";
        $this->bucket="anchongres";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyName=Requester::input('keyName');
        if($keyName==""){
            $datas=$this->good->paginate(8);
        }else{
            $datas = Good::Name($keyName)->paginate(8);
        }
        $args=array("keyName"=>$keyName);
        return view('admin/good/index_commodity',array("datacol"=>compact("args","datas")));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin/good/create_commodity",array('sid'=>$this->sid,'gid'=>$this->gid));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\CommodityRequest $request)
    {
        /*
         * 因为要向多个表中插入数据，
         * 所以需要开启事务处理
         * */
        DB::beginTransaction();

        //将关键字转码之后再插入数据库，为将来分词索引做准备
        $keywords_arr=explode(' ',$request->keyword);
        $keywords="";
        foreach ($keywords_arr as $keyword_arr) {
            $keywords.=bin2hex($keyword_arr)." ";
        };

        //遍历商品分类的数组，挨个进行转码，为将来分词索引做准备
        $type="";
        for($i=0;$i<count($request['midselect']);$i++){
            $type.=bin2hex($request['midselect'][$i])." ";
        };

        //向goods表中插入数据并获取刚插入数据的主键
        $gid = DB::table('anchong_goods')->insertGetId(
            [
                'title'=>$request->name,
                'sid'=>$this->sid,
                'desc'=>$request->description,
                'type'=>trim($type),
                'remark'=>$request->remark,
                'keyword'=>$keywords,
                'images'=>$request->pic[0]['url'],
<<<<<<< HEAD
                'param'=>$request->param,
                'package'=>$request->data,
=======
                'param'=>'<style>img{max-width:100%;}</style>'.$request->param,
                'package'=>'<style>img{max-width:100%;}</style>'.$request->data,
>>>>>>> origin/renqingbin
            ]
        );

        //通过一个for循环向属性表中插入数据
        for($i=0;$i<count($request->attrname);$i++){
            DB::table('anchong_goods_attribute')->insertGetId(
                [
                    'goods_id'=>$gid,
                    'name'=>$request->attrname[$i],
                    'value'=>$request->attrvalue[$i]
                ]
            );
        };

        //将对象的gid属性设置为刚插入的那条数据的主键并返回给页面
        $this->gid=$gid;
        //提交事务
        DB::commit();
        return view("admin/good/create_commodity",array('sid'=>$this->sid,'gid'=>$this->gid,'mes'=>"添加成功！"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=$this->good->find($id);

        $keywords=rtrim($data['keyword']);
        $arr=explode(" ",$keywords);
        $str="";
        for($i=0;$i<count($arr);$i++){
            $str.=pack("H*",$arr[$i])." ";
        }
        $data['keyword']=$str;

        $arr0=explode(" ",$data['type']);
        $type="";
        for($j=0;$j<count($arr0);$j++){
            $type.=pack("H*",$arr0[$j])." ";
        };
        $data['type']=$type;

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
        $data=$this->good->find($id);

        $keywords=rtrim($data['keyword']);
        $arr=explode(" ",$keywords);
        $str="";
        for($i=0;$i<count($arr);$i++){
            $str.=pack("H*",$arr[$i])." ";
        }
        $data['keyword']=$str;

        $arr0=explode(" ",$data['type']);
        $type="";
        for($j=0;$j<count($arr0);$j++){
            $type.=pack("H*",$arr0[$j])." ";
        };
        $data['type']=$type;
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
        $data=$this->good->find($id);
        $data->title=$request->title;
        $data->desc=$request->description;
        $data->remark=$request->remark;
<<<<<<< HEAD
        $data->param=$request->param;
        $data->package=$request->data;
=======
        $data->param='<style>img{max-width:100%;}</style>'.$request->param;
        $data->package='<style>img{max-width:100%;}</style>'.$request->data;
>>>>>>> origin/renqingbin
        //将关键字转码之后再插入数据库，为将来分词索引做准备
        $keywords_arr=explode(' ',$request->keyword);
        $keywords="";
        foreach ($keywords_arr as $keyword_arr) {
            $keywords.=bin2hex($keyword_arr)." ";
        };

        //遍历商品分类的数组，挨个进行转码，为将来分词索引做准备
        $type="";
        for($i=0;$i<count($request['midselect']);$i++){
            $type.=bin2hex($request['midselect'][$i])." ";
        };

        $data->keyword=ltrim($keywords);
        $data->type=trim($type);
        $result=$data->save();
        if($result){
            return redirect()->back();
        }else{
            return "更新失败，请返回重试";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /*
     * 获取同一个分类下的商品的方法
     * */
    public function getSiblings(Request $request){
        $type=bin2hex($request['pid']);
        $data=Good::Type($type,$request['sid'])->get();
        return $data;
    }

    /*
     * 更新图片方法
     * */
    public function updateImg(Request $request)
    {
        $fileType=$_FILES['file']['type'];
        $filePath = $request['file'];
        $dir="goods/img/detail/";
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

            //将商品详情图片替换掉
            $data=$this->good->find($request['gid']);
            $data->images=$url;
            $data->save();

            $message="上传成功";
            $isSuccess=true;
        }catch (OssException $e) {
            $message="上传失败，请稍后再试";
            $isSuccess=false;
            $url="";
        }
        return response()->json(['message' => $message, 'isSuccess' => $isSuccess,'url'=>$url]);
    }
}
