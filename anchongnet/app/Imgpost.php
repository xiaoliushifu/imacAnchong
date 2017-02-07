<?php

namespace App;

use Illuminate\Http\Request;
use OSS\OssClient;
use OSS\Core\OssException;
use Log;

/**
*   该控制器包含了商机图片模块的操作
*/
class Imgpost
{
    private $bimg;
    private $accessKeyId;
    private $accessKeySecret ;
    private $endpoint;
    private $bucket;
    public function __construct()
    {
        $this->accessKeyId=env('ALIOSS_ACCESSKEYId');
        $this->accessKeySecret=env('ALIOSS_ACCESSKEYSECRET');
        $this->endpoint=env('ALIOSS_ENDPOINT');
        $this->bucket=env('ALIOSS_BUCKET');
    }

    /**
     * 从OSS获得指定文件到内存
     * @param unknown $fname
     */
    public function downfile($fname)
    {
        $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
        try{
            $content = $ossClient->getObject($this->bucket,'ganhuo-dir/'.$fname);
            //header('Content-type: application/octet-stream');
            //header("Accept-Length: ".\strlen($content));
            //header("Accept-Ranges: bytes");
            return response($content)->header('Content-disposition','attachment;filename='.$fname);
        } catch (OssException $e) {
            \Log::info($e->getMessage());
            $content="非法请求";
        }
        return $content;
    }
    
    /**
     * 删除
     */
    public function delete($fname)
    {
        $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
        try{
            $ossClient->deleteObject($this->bucket, 'ganhuo-dir/'.$fname);
        } catch(OssException $e) {
            Log::info($e->getMessage(),['oss_delete']);
            return false;
        }
        return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request('file'文件对象)
     * @return \Illuminate\Http\Response
     */
    static function upload($request)
    {
        /**
         * 统一操作文件（图片）上传
         * @var unknown
         */
        $fileType=$_FILES['file']['type'];
        $dir="head/";
        $filePath = $request['file'];
        //设置上传到阿里云oss的对象的键名
        switch ($fileType){
            case "image/png":
                $object=$dir.time().rand(100000,999999).".png";
                break;
            case "image/jpeg":
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
            //域名（endpoint）
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
}
