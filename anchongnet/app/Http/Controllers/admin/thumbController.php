<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\GoodThumb;

use OSS\OssClient;
use OSS\Core\OssException;
use DB;

class thumbController extends Controller
{
    private $thumb;
    private $accessKeyId;
    private $accessKeySecret ;
    private $endpoint;
    private $bucket;

    /*
     * 在构造函数中初始化model
     * */
    public function __construct()
    {
        $this->thumb=new GoodThumb();
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        switch($request->imgtype){
            case 1:
                $fileType=$_FILES['pic']['type'];
                $dir="goods/img/goods/";
                $filePath = $request['pic'][0];
                break;
            case 2:
                $fileType=$_FILES['detailpic']['type'];
                $dir="goods/img/detail/";
                $filePath = $request['detailpic'][0];
                break;
            case 3:
                $fileType=$_FILES['parampic']['type'];
                $dir="goods/img/param/";
                $filePath = $request['parampic'][0];
                break;
            case 4:
                $fileType=$_FILES['datapic']['type'];
                $dir="goods/img/data/";
                $filePath = $request['datapic'][0];
                break;
        }
        //设置上传到阿里云oss的对象的键名
        switch ($fileType[0]){
            case "image/png":
                $object=$dir.time().".png";
                break;
            case "image/jpeg":
                $object=$dir.time().".jpg";
                break;
            case "image/jpg":
                $object=$dir.time().".jpg";
                break;
            case "image/gif":
                $object=$dir.time().".gif";
                break;
            default:
                $object=$dir.time().".jpg";
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
            $tid = DB::table('anchong_goods_thumb')->insertGetId(
                [
                    'gid'=>$request->gid,
                    'img_url'=>$url,
                    'thumb_url'=>$url,
                    'img_type'=>$request->imgtype
                ]
            );
            $message="上传成功";
            $isSuccess=true;
        }catch (OssException $e) {
            $tid=null;
            $message="上传失败，请稍后再试";
            $isSuccess=false;
        }
        return response()->json(['message' => $message, 'isSuccess' => $isSuccess,'id'=>$tid]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        switch($request->imgtype){
            case 1:
                $fileType=$_FILES['pic']['type'];
                $dir="goods/img/goods/";
                $filePath = $request['pic'][0];
                break;
            case 2:
                $fileType=$_FILES['detailpic']['type'];
                $dir="goods/img/detail/";
                $filePath = $request['detailpic'][0];
                break;
            case 3:
                $fileType=$_FILES['parampic']['type'];
                $dir="goods/img/param/";
                $filePath = $request['parampic'][0];
                break;
            case 4:
                $fileType=$_FILES['datapic']['type'];
                $dir="goods/img/data/";
                $filePath = $request['datapic'][0];
                break;
        }
        //设置上传到阿里云oss的对象的键名
        switch ($fileType[0]){
            case "image/png":
                $object=$dir.time().".png";
                break;
            case "image/jpeg":
                $object=$dir.time().".jpg";
                break;
            case "image/jpg":
                $object=$dir.time().".jpg";
                break;
            case "image/gif":
                $object=$dir.time().".gif";
                break;
            default:
                $object=$dir.time().".jpg";
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
            $data=$this->thumb->find($id);
            $data->thumb_url=$url;
            $data->img_url=$url;
            $data->save();
            $message="更新成功";
            $isSuccess=true;
        }catch (OssException $e) {
            $message="更新失败，请稍后再试";
            $isSuccess=false;
        }
        return response()->json(['message' => $message, 'isSuccess' => $isSuccess]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=$this->thumb->find($id);
        $data->delete();
        return "删除成功";
    }

    /*
     * 获取指定商品的缩略图
     * */
    public function getGoodThumb(Request $request){
        $gid=$request['gid'];
        $data=GoodThumb::Gid($gid)->get();
        return $data;
    }
}
