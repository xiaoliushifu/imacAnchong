<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use OSS\OssClient;
use OSS\Core\OssException;

/**
*   该控制器包含了社区聊聊图片模块的操作
*/
class releaseImgController extends Controller
{
    private $coimg;
    private $accessKeyId;
    private $accessKeySecret ;
    private $endpoint;
    private $bucket;

    //构造方法
    public function __construct()
    {
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
     * @param  $request('file'文件对象)
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            $message="上传成功";
            $isSuccess=true;
        }catch (OssException $e) {
            $message="上传失败，请稍后再试";
            $isSuccess=false;
            $url='';
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
     * @param  $request('file'文件对象,'','','','')
     * @param  int  $id聊聊ID
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fileType=$_FILES['file']['type'];
        //$fileType="image/png";
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
                $img_arr[$id]=$url;
                foreach ($img_arr as $pic) {
                    $imgs.=$pic.'#@#';
                }
                //创建图片查询的orm模型
                $community_release=new \App\Community_release();
                $result=$community_release->communityupdate($request['chat_id'],['img'=>$imgs]);
                if($result){
                    $message="更新成功";
                    $isSuccess=true;
                }else{
                    $message="更新失败，请稍后再试";
                    $isSuccess=false;
                }
            }else{
                $message="更新失败，请稍后再试";
                $isSuccess=false;
            }
        }catch (OssException $e) {
            $message="更新失败，请稍后再试";
            $isSuccess=false;
        }
        return response()->json(['message' => $message, 'isSuccess' => $isSuccess, 'url'=>$url,'imgs'=>$imgs]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id聊聊ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=$this->coimg->find($id);
        $data->delete();
        return "删除成功";
    }

    /**
     *   获取指定发布的图片方法
     *
     * @param  $request('cid'图片id)
     * @return \Illuminate\Http\Response
     */
    public function getImg(Request $request)
    {
        $chat=$request['cid'];
        $datas=$this->coimg->Chat($chat)->get();
        return $datas;
    }
}
