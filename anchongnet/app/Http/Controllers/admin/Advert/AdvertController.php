<?php

namespace App\Http\Controllers\admin\Advert;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use OSS\OssClient;
use OSS\Core\OssException;
use DB;
use Auth;

use App\GoodSpecification;
use App\GoodThumb;
use App\Stock;
use App\Goods_type;
use App\Shop;

/*
*   该控制器包含了广告模块的操作
*/
class AdvertController extends Controller
{
    //构造函数
    public function __construct()
    {
        $this->accessKeyId=env('ALIOSS_ACCESSKEYId');
        $this->accessKeySecret=env('ALIOSS_ACCESSKEYSECRET');
        $this->endpoint=env('ALIOSS_ENDPOINT');
        $this->bucket=env('ALIOSS_BUCKET');
    }
    /*
     * 编辑广告时添加图片
     */
    public function addpic(Request $request)
    {
        $fileType=$_FILES['file']['type'];
        $dir="advert/img/";
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

            //创建ORM模型
            $ad=new \App\Ad();
            $result=$ad->adupdate($request->adid,['ad_name'=>$request->goods_id,'ad_link'=>$request->gid,'ad_code'=>$url]);
            $message="上传成功";
            $isSuccess=true;
            if($result){
                return response()->json(['message' => $message, 'isSuccess' => $isSuccess,'url'=>$url,'tid'=>'']);
            }else{
                return response()->json(['message' => '数据库插入出错，请重新上传', 'isSuccess' => $isSuccess,'url'=>$url,'tid'=>'']);
            }

         }catch (OssException $e) {
             $message="上传失败，请稍后再试";
             $isSuccess=false;
             $url='';
             $tid='';
             return response()->json(['message' => $message, 'isSuccess' => $isSuccess,'url'=>$url,'tid'=>$tid]);
        }

    }
}
