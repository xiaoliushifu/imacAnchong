<?php

namespace App\Http\Controllers\admin\Advert;

use Request;
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
        $request=$request::all();
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
            $result=$ad->adupdate($request['adid'],['ad_name'=>$request['goods_id'],'ad_link'=>$request['gid'],'ad_code'=>$url]);
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

    /*
    *   该方法是商机热门推广
    */
    public function businessadvert(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $param=$request::all();
        //创建ORM模型
        $business=new \App\Business();
        $result=$business->businessupdate($param['bid'],['recommend'=>$param['recommend']]);
        if($result){
            return
            response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'推广成功']]);
        }else {
            return
            response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'推广失败']]);
        }
    }
}
