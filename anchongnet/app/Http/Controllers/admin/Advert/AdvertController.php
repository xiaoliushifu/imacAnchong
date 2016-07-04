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

    /*
    *   发布资讯页面
    */
    public function newsshow()
    {
        return view("admin/advert/create_news");
    }

    /*
    *   查看资讯页面
    */
    public function newsindex()
    {
        //创建订单的ORM模型
        $information=new \App\Information();
        $datas=$information->allquer(['infor_id','title','img'])->paginate(8);
        return view("admin/advert/index",array('datacol'=>$datas));
    }

    /*
    *   商机广告
    */
    public function busiadvert()
    {
        return view("admin/advert/business");
    }

    /*
    *   发布资讯
    */
    public function releasenews(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        //创建订单的ORM模型
        $information=new \App\Information();
        //定义传过来的内容
        $information_data=[
            'title' => $data['title'],
            'img' => $data['pic'][0]['url'],
            'content' => '<style>img{max-width:100%;}</style>'.$data['param'],
            'created_at' => date('Y-m-d H:i:s',time())
        ];
        //进行插入
        $result=$information->add($information_data);
        if($result){
            return view("admin/advert/create_news",array('mes'=>"添加成功！"));
        }else{
            return view("admin/advert/create_news",array('mes'=>"添加失败！"));
        }
    }

    /*
    *   资讯查看
    */
    public function information($infor_id)
    {
        //创建ORM模型
        $information=new \App\Information();
        $data=$information->firstquer('content','infor_id ='.$infor_id);
        return $data['content'];
    }

    /*
    *   资讯查看
    */
    public function inforupdate(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        //创建ORM模型
        $information=new \App\Information();
        $information_data=[
            'title' => $data['title'],
            'img' => $data['newsimg'],
            'content' => $data['content'],
        ];
        $data=$information->newsupdate($data['infor_id'],$information_data);
        if($data){
            return response()->json(['message' => '修改成功']);
        }else{
            return response()->json(['message' => '修改失败']);
        }
    }

    /*
    *   单个资讯查看
    */
    public function firstinfor($infor_id)
    {
        //创建订单的ORM模型
        $information=new \App\Information();
        $datas=$information->onequer(['infor_id','title','img','content'],'infor_id ='.$infor_id)->get();
        return $datas;
    }

    /*
    *   删除单个资讯
    */
    public function infordel($infor_id)
    {
        //创建订单的ORM模型
        $information=new \App\Information();
        $result=$information->infordel($infor_id);
        if($result){
            return
            response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'删除成功']]);
        }else {
            return
            response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'删除失败']]);
        }
    }
}
