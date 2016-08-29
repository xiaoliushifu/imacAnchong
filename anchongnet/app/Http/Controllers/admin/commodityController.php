<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Goods;
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

    private $accessKeyId;
    private $accessKeySecret ;
    private $endpoint;
    private $bucket;

    public function __construct()
    {
        $this->goods=new Goods();
        //通过Auth获取当前登录用户的id
        $this->uid=Auth::user()['users_id'];
        //通过用户获取商铺id
        $this->sid=Shop::Uid($this->uid)->sid;

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
            $datas=$this->goods->where('sid','=',$this->sid)->orderBy("goods_id","desc")->paginate(8);
        }else{
            $datas = Good::Name($keyName,$this->sid)->orderBy("goods_id","desc")->paginate(8);
        }
        $args=array("keyName"=>$keyName);
        return view('admin/good/index_commodity',array("datacol"=>compact("args","datas"),"sid"=>$this->sid));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin/good/create_commodity",array('sid'=>$this->sid));
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

        //替换，多字节字符替换
        $str = str_replace(array(',','，',';','；','.','。'),' ',$request->keyword);
        //拆分，按照空白拆分
        $keywords_arr=preg_split('#\s#', $str,-1,PREG_SPLIT_NO_EMPTY);
        $keywords="";
        foreach ($keywords_arr as $k) {
            //限制长度
            if (mb_strlen($k,'utf-8') < 15 ) {
                $keywords.=bin2hex($k)." ";
            }
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
                'param'=>'<style>img{max-width:100%;}</style>'.$request->param,
                'package'=>'<style>img{max-width:100%;}</style>'.$request->data,
            ]
        );

        //插入oem数据
        DB::table('anchong_goods_oem')->insertGetId(
            [
                 'goods_id'=>$gid,
                'value'=>$request->oem
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

        //通过循环向配套商品表中插入数据
        for($i=0;$i<count($request->supname)-1;$i++){
            if(!empty($request->title[$i]) && !empty($request->price[$i]) && !empty($request->gid[$i])){
                DB::table('anchong_goods_supporting')->insertGetId(
                    [
                        'goods_id'=>$request->supname[$i+1],
                        'gid'=>$request->gid[$i],
                        'title'=>$request->title[$i],
                        'price'=>$request->price[$i],
                        'img'=>$request->img[$i],
                        'assoc_gid'=>$gid,
                        'goods_name'=>$request->goodsname[$i+1]
                    ]
                );
            }
        }

        //提交事务
        DB::commit();
        return view("admin/good/create_commodity",array('sid'=>$this->sid,'mes'=>"添加成功！"));
    }

    /**
     * Display the specified resource.
     *这个方法有在调用吗？
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=$this->goods->find($id);

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
        $data=$this->goods->find($id);

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
            if($arr0[$j] !== ""){
                $type.=pack("H*",$arr0[$j])." ";
            }
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
        $data=$this->goods->find($id);
        $data->title=$request->title;
        $data->desc=$request->description;
        $data->remark=$request->remark;
        $data->param='<style>img{max-width:100%;}</style>'.$request->param;
        $data->package='<style>img{max-width:100%;}</style>'.$request->data;
        //将关键字转码之后再插入数据库，为将来分词索引做准备
        $str = str_replace(array(',','，',';','；','.','。'),' ',$request->keyword);
        //拆分，按照空白拆分
        $keywords_arr=preg_split('#\s#', $str,-1,PREG_SPLIT_NO_EMPTY);
        $keywords="";
        foreach ($keywords_arr as $k) {
            if (mb_strlen($k,'utf-8') < 15) {
                $keywords.=bin2hex($k)." ";
            }
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
            $urls = substr($signedUrl, 0, $pos);
            $url = str_replace('.oss-','.img-',$urls);

            //将商品详情图片替换掉
            $data=$this->goods->find($request['gid']);
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
