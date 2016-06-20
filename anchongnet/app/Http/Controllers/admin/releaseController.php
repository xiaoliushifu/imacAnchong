<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Community_release;
use App\Community_img;
use Auth;
use DB;

use OSS\OssClient;
use OSS\Core\OssException;

class releaseController extends Controller
{
    private $release;
    private $reimg;
    private $uid;
    private $accessKeyId;
    private $accessKeySecret ;
    private $endpoint;
    private $bucket;

    public function __construct()
    {
        $this->release=new Community_release();
        $this->reimg=new Community_img();
        //通过Auth获取当前登录用户的id
        $this->uid=Auth::user()['users_id'];

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
        $keyTag=Requester::input("tag");
        if($keyTag==""){
            $datas=$this->release->User($this->uid)->paginate(8);
        }else{
            $datas = $this->release->Tag($this->uid,$keyTag)->paginate(8);
        }
        $args=array("user"=>$this->uid,"tag"=>$keyTag);
        return view('admin/release/index',array("datacol"=>compact("args","datas")));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin/release/create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\StoreReleaseRequest $request)
    {
        DB::beginTransaction();

        $id = DB::table('anchong_community_release')->insertGetId(
            [
                'users_id' => $request['uid'],
                'title' => $request['title'],
                'name'=>$request['name'],
                'content'=>$request['content'],
                'auth'=>1,
                'headpic'=>$request['headpic'],
                'tags'=>$request['tag'],
                'tags_match'=>bin2hex($request['tag']),
                'created_at'=>date("Y-m-d H:i:s",time()),
                'comnum'=>0
            ]
        );

        for($i=0;$i<count($request['pic']);$i++){
            DB::table('anchong_community_img')->insert(
                [
                    'img' => $request['pic'][$i],
                    'chat_id'=>$id
                ]
            );
        }

        DB::commit();
        return "添加成功";
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
        $data=$this->release->find($id);
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
        $data=$this->release->find($id);
        $data->title=$request->title;
        $data->content=$request['content'];
        $data->save();
        return "更新成功";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=$this->release->find($id);
        $data->delete();
        return "删除成功";
    }

    public function addpic(Request $request)
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
            $url = substr($signedUrl, 0, $pos);

            //插入数据库并返回主键id
            $id = DB::table('anchong_community_img')->insertGetId(
                ['chat_id' => $request['cid'], 'img' => $url]
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
