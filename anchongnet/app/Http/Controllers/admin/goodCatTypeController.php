<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\GoodCatType;

use OSS\OssClient;
use OSS\Core\OssException;

class goodCatTypeController extends Controller
{
    private $goodCatType;

    public function __construct()
    {
        $this->goodCatType = new GoodCatType();
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
            $datas=$this->goodCatType->paginate(8);
        }else{
            $datas = GoodCatType::Name($keyName)->paginate(8);
        }
        $args=array("keyName"=>$keyName);
        return view('admin/cate/catetype_index',array("datacol"=>compact("args","datas")));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin/cate/catetype_create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->goodCatType->cat_name=$request['catname'];
        $this->goodCatType->keyword=$request['keyword'];
        $this->goodCatType->cat_desc=$request['description'];
        $this->goodCatType->is_show=$request['ishow'];
        $this->goodCatType->cat_id=$request['parent'];
        $this->goodCatType->parent_id=$request['parent1'];

        //配置阿里云oss配置
        $accessKeyId = "HJjYLnySPG4TBdFp";
        $accessKeySecret = "Ifv0SNWwch5sgFcrM1bDthqyy4BmOa";
        $endpoint = "oss-cn-hangzhou.aliyuncs.com";
        $bucket="anchongres";

        //设置上传到阿里云oss的对象的键名
        switch ($_FILES["pic"]["type"]){
            case "image/png":
                $object="goods/category/".time().".png";
                break;
            case "image/jpeg":
                $object="goods/category/".time().".jpg";
                break;
            case "image/jpg":
                $object="goods/category/".time().".jpg";
                break;
            case "image/gif":
                $object="goods/category/".time().".gif";
                break;
            default:
                $object="goods/category/".time().".jpg";
        }

        $filePath = $request['pic'];

        try {
            //实例化一�?ossClient对象
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            //上传文件
            $ossClient->uploadFile($bucket, $object, $filePath);
            //获取到上传文件的路径
            $signedUrl = $ossClient->signUrl($bucket, $object);
            $pos=strpos($signedUrl,"?");
            $url=substr($signedUrl,0,$pos);
            //将上传的文件的路径保存到数据库中
            //向数据库插入内容
            $this->goodCatType->pic = $url;
        } catch (OssException $e) {
            print $e->getMessage();
        }
        $result=$this->goodCatType->save();
        if($result){
            return redirect()->back();
        }else{
            dd("修改失败，请返回重试");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=$this->goodCatType->find($id);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=$this->goodCatType->find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$this->goodCatType->find($id);
        $data->cat_name=$request['catname'];
        $data->keyword=$request['keyword'];
        $data->cat_desc=$request['description'];
        $data->is_show=$request['ishow'];
        $data->parent_id=$request['parent'];

        //配置阿里云oss配置
        $accessKeyId = "HJjYLnySPG4TBdFp";
        $accessKeySecret = "Ifv0SNWwch5sgFcrM1bDthqyy4BmOa";
        $endpoint = "oss-cn-hangzhou.aliyuncs.com";
        $bucket="anchongres";

        //设置上传到阿里云oss的对象的键名
        switch ($_FILES["pic"]["type"]){
            case "image/png":
                $object="goods/category/".time().".png";
                break;
            case "image/jpeg":
                $object="goods/category/".time().".jpg";
                break;
            case "image/jpg":
                $object="goods/category/".time().".jpg";
                break;
            case "image/gif":
                $object="goods/category/".time().".gif";
                break;
            default:
                $object="goods/category/".time().".jpg";
        }

        $filePath = $request['pic'];

        try {
            //实例化一�?ossClient对象
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            //上传文件
            $ossClient->uploadFile($bucket, $object, $filePath);
            //获取到上传文件的路径
            $signedUrl = $ossClient->signUrl($bucket, $object);
            $pos=strpos($signedUrl,"?");
            $url=substr($signedUrl,0,$pos);
            //将上传的文件的路径保存到数据库中
            //向数据库插入内容
            $data->pic = $url;
        } catch (OssException $e) {
            print $e->getMessage();
        }

        $result=$data->save();
        if($result){
            return redirect()->back();
        }else{
            dd("修改失败，请返回重试");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=$this->goodCatType->find($id);
        $result=$data->delete();
        if($result){
            return "删除成功！";
        }else{
            return "修改失败，请返回重试";
        }
    }

    /*
     * 获取指定父分类的三级分类
     * */
    public function getLevel(Request $request){
        $pid=$request['pid'];
        $datas = GoodCatType::Level($pid)->get();
        return $datas;
    }

    /*
     * 获取同一个父级的三级分类
     * */
    public function getSiblingsLevel(Request $request){
        $data=$this->goodCatType->find($request['cid']);
        $pid=$data->parent_id;
        $datas = GoodCatType::Level($pid)->get();
        return $datas;
    }
}
