<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Goods_thumb;
use App\Goods_type;
use App\Goods_specifications;

use OSS\OssClient;
use OSS\Core\OssException;
use DB;

class thumbController extends Controller
{
    private $thumb;
    private $good;
    private $goodType;
    private $accessKeyId;
    private $accessKeySecret ;
    private $endpoint;
    private $bucket;

    /*
     * 在构造函数中初始化model
     * */
    public function __construct()
    {
        $this->thumb=new Goods_thumb();
        $this->goodType=new Goods_type();
        $this->good=new Goods_specifications();
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
        $fileType=$_FILES['file']['type'];
        $dir="goods/img/goods/";
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
            $message="上传成功";
            $isSuccess=true;
        }catch (OssException $e) {
            $message="上传失败，请稍后再试";
            $isSuccess=false;
        }
        return response()->json(['message' => $message, 'isSuccess' => $isSuccess,'url'=>$url]);
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
        $fileType=$_FILES['file']['type'];
        $dir="goods/img/goods/";
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
            $data=$this->thumb->find($id);
            $data->thumb_url=$url;
            $data->img_url=$url;
            $data->save();
            if($request->isfirst=="first"){
                DB::beginTransaction();
                $gdata=$this->good->find($request->gid);
                $gdata->goods_img=$url;
                $gdata->save();

                $gtdata=$this->goodType->Gid($request->gid);
                $gtdata->pic=$url;
                $gtdata->save();
                DB::commit();
            }
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
        $data=Goods_thumb::Gid($gid)->get();
        return $data;
    }
}
