<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;

use App\GoodSpecification;
use App\GoodThumb;
use App\Stock;
use App\Goods_type;
use App\Shop;

use OSS\OssClient;
use OSS\Core\OssException;

class goodController extends Controller
{
    private $goodSpecification;
    private $goodThumb;
    private $stock;
    private $goods_type;
    private $uid;
    private $sid;

    /*
     * 构造方法
     * */
    public function __construct()
    {
        $this->goodSpecification=new GoodSpecification();
        $this->goodThumb=new GoodThumb();
        $this->stock=new Stock();
        $this->goods_type=new Goods_type();
        //通过Auth获取当前登录用户的id
        $this->uid=Auth::user()['users_id'];
        //通过用户获取商铺id
        $this->sid=Shop::Uid($this->uid)->sid;
       // $this->middleware("ThumbImage");
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
            $datas=$this->goodSpecification->paginate(8);
        }else{
            $datas = GoodSpecification::Name($keyName)->paginate(8);
        }
        $args=array("keyName"=>$keyName);
        $sid=$this->sid;
        return view('admin/good/index',array("datacol"=>compact("args","datas"),"sid"=>$sid));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/good/create')->with('sid', $this->sid);;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\GoodCreateRequest $request)
    {
        //配置阿里云oss配置
        $accessKeyId = "HJjYLnySPG4TBdFp";
        $accessKeySecret = "Ifv0SNWwch5sgFcrM1bDthqyy4BmOa";
        $endpoint = "oss-cn-hangzhou.aliyuncs.com";
        $bucket="anchongres";

        /*
         * 开启事务处理，
         * 向多个表中插入数据
         * */
        DB::beginTransaction();

        /*向货品表中插入数据*/
        //如果商品立即上架，就将上架时间设置为当前时间戳
        if($request->status==1){
            $goods_create_time=date("Y:m:d H:i:s");
        }else{
            $goods_create_time=date("0000:00:00 00:00:00");
        }
		
		//将关键字转码之后再插入数据库，为将来分词索引做准备
		$keywords_arr=explode(' ',$request->keyword);
        $keywords="";
        if(!empty($keywords_arr)){
            foreach ($keywords_arr as $keyword_arr) {
                $keywords.=bin2hex($keyword_arr)." ";
            }
        }

		
        $gid = DB::table('anchong_goods_specifications')->insertGetId(
            [
                'cat_id' => $request->backselect,
                'goods_id'=>$request->name,
                'goods_name'=>$request->spetag,
                'market_price'=>$request->marketprice,
                'goods_price'=>$request->costpirce,
                'vip_price'=>$request->viprice,
                'goods_desc'=>$request->description,
                'keyword'=>$keywords,
                'goods_create_time'=>$goods_create_time,
                'goods_numbering'=>$request->numbering,
                'sid'=>$this->sid,
            ]
        );

        //通过oss上传商品图片，并将url地址保存
        for($i=1;$i<count($request['pic']);$i++){
            //设置上传到阿里云oss的对象的键名
            switch ($_FILES["pic"]["type"][$i]){
                case "image/png":
                    $object="goods/img/goods/".time().".png";
                    break;
                case "image/jpeg":
                    $object="goods/img/goods/".time().".jpg";
  
                    break;
                case "image/jpg":
                    $object="goods/img/goods/".time().".jpg";
                    break;
                case "image/gif":
                    $object="goods/img/goods/".time().".gif";
                    break;
                default:
                    $object="goods/img/goods/".time().".jpg";
            }

            $filePath = $request['pic'][$i];

            try {
                //实例化一个ossClient对象
                $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                //上传文件
                $ossClient->uploadFile($bucket, $object, $filePath);
                //获取到上传文件的路径
                $signedUrl = $ossClient->signUrl($bucket, $object);
                $pos=strpos($signedUrl,"?");
                $url=substr($signedUrl,0,$pos);

                //将上传的文件的路径保存到数据库中
                //将第一张商品图片的地址保存到货品表中
                if($i==1){
                    $good=$this->goodSpecification->find($gid);
                    $good->goods_img = $url;
                    $good->save();

                    /*向goods_type表中插入数据*/
                    $this->goods_type->gid=$gid;
                    $this->goods_type->title=$request->goodname." ".$request->spetag;
                    $this->goods_type->price=$request->marketprice;
                    $this->goods_type->sname="安虫";
                    $this->goods_type->pic=$url;
                    $this->goods_type->vip_price=$request->viprice;
                    $this->goods_type->cid= $request->backselect;
                    $result=$this->goods_type->save();
                }
                DB::table('anchong_goods_thumb')->insert(
                    [
                        'gid' => $gid,
                        'img_url' => $url,
                        'thumb_url'=>$url,
                        'img_type'=>1
                    ]
                );
            } catch (OssException $e) {
                print $e->getMessage();
            }
        }

        //通过oss上传详情图片，并将图片地址保存
        for($j=1;$j<count($request['detailpic']);$j++){
            //设置上传到阿里云oss的对象的键名
            switch ($_FILES["detailpic"]["type"][$j]){
                case "image/png":
                    $object="goods/img/detail/".time().".png";
                    break;
                case "image/jpeg":
                    $object="goods/img/detail/".time().".jpg";
                    break;
                case "image/jpg":
                    $object="goods/img/detail/".time().".jpg";
                    break;
                case "image/gif":
                    $object="goods/img/detail/".time().".gif";
                    break;
                default:
                    $object="goods/img/detail/".time().".jpg";
            }

            $filePath = $request['detailpic'][$j];

            try {
                //实例化一个ossClient对象
                $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                //上传文件
                $ossClient->uploadFile($bucket, $object, $filePath);
                //获取到上传文件的路径
                $signedUrl = $ossClient->signUrl($bucket, $object);
                $pos=strpos($signedUrl,"?");
                $url=substr($signedUrl,0,$pos);
                //将上传的文件的路径保存到数据库中
                DB::table('anchong_goods_thumb')->insert(
                    [
                        'gid' => $gid,
                        'img_url' => $url,
                        'thumb_url'=>$url,
                        'img_type'=>2
                    ]
                );
            } catch (OssException $e) {
                print $e->getMessage();
            }
        }

        //通过oss上传相关参数图片，并将图片地址保存
        for($k=1;$k<count($request['parampic']);$k++){
            //设置上传到阿里云oss的对象的键名
            switch ($_FILES["parampic"]["type"][$k]){
                case "image/png":
                    $object="goods/img/param/".time().".png";
                    break;
                case "image/jpeg":
                    $object="goods/img/param/".time().".jpg";
                    break;
                case "image/jpg":
                    $object="goods/img/param/".time().".jpg";
                    break;
                case "image/gif":
                    $object="goods/img/param/".time().".gif";
                    break;
                default:
                    $object="goods/img/param/".time().".jpg";
            }

            $filePath = $request['parampic'][$k];

            try {
                //实例化一个ossClient对象
                $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                //上传文件
                $ossClient->uploadFile($bucket, $object, $filePath);
                //获取到上传文件的路径
                $signedUrl = $ossClient->signUrl($bucket, $object);
                $pos=strpos($signedUrl,"?");
                $url=substr($signedUrl,0,$pos);
                //将上传的文件的路径保存到数据库中
                DB::table('anchong_goods_thumb')->insert(
                    [
                        'gid' => $gid,
                        'img_url' => $url,
                        'thumb_url'=>$url,
                        'img_type'=>3
                    ]
                );
            } catch (OssException $e) {
                print $e->getMessage();
            }
        }

        //通过oss上传相关资料图片，并将图片地址保存
        for($n=1;$n<count($request['datapic']);$n++){
            //设置上传到阿里云oss的对象的键名
            switch ($_FILES["datapic"]["type"][$n]){
                case "image/png":
                    $object="goods/img/data/".time().".png";
                    break;
                case "image/jpeg":
                    $object="goods/img/data/".time().".jpg";
                    break;
                case "image/jpg":
                    $object="goods/img/data/".time().".jpg";
                    break;
                case "image/gif":
                    $object="goods/img/data/".time().".gif";
                    break;
                default:
                    $object="goods/img/data/".time().".jpg";
            }

            $filePath = $request['datapic'][$n];

            try {
                //实例化一个ossClient对象
                $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                //上传文件
                $ossClient->uploadFile($bucket, $object, $filePath);
                //获取到上传文件的路径
                $signedUrl = $ossClient->signUrl($bucket, $object);
                $pos=strpos($signedUrl,"?");
                $url=substr($signedUrl,0,$pos);
                //将上传的文件的路径保存到数据库中
                //将第一张相关资料图片的地址保存到货品表中
                DB::table('anchong_goods_thumb')->insert(
                    [
                        'gid' => $gid,
                        'img_url' => $url,
                        'thumb_url'=>$url,
                        'img_type'=>4
                    ]
                );
            } catch (OssException $e) {
                print $e->getMessage();
            }
        }

        /*
         * 向仓库表中插入
         * */
		$total=0;
        for($m=0;$m<count($request['stock']['region']);$m++){
            DB::table('anchong_goods_stock')->insert(
                [
                    'gid' => $gid,
                    'region' => $request['stock']['region'][$m],
                    'region_num'=>$request['stock']['num'][$m]
                ]
            );
			$total=$total+$request['stock']['num'][$m];
        }
		
		$gdata=$this->goodSpecification->find($gid);
		$gdata->goods_num=$total;
		$gdata->save();

        //提交事务
        DB::commit();

        if($result){
            return redirect()->back();
        }else{
            return "插入失败，请稍后重试";
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=$this->goodSpecification->find($id);
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
        $data=$this->goodSpecification->find($id);
		
		$keywords_arr=explode(' ',$data->keyword);
        if(!empty($keywords_arr)){
			$data->keyword="";
            foreach ($keywords_arr as $keyword_arr) {
                $data->keyword.=pack("H*",$keyword_arr)." ";
            }
        }
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
		//将关键字转码之后再插入数据库，为将来分词索引做准备
		$keywords_arr=explode(' ',$request->keyword);
        $keywords="";
        if(!empty($keywords_arr)){
            foreach ($keywords_arr as $keyword_arr) {
                $keywords.=bin2hex($keyword_arr)." ";
            }
        }
		
        $data=$this->goodSpecification->find($id);
        $data->goods_id=$request->name;
        $data->cat_id=$request->backselect;
        $data->goods_name=$request->spetag;
        $data->market_price=$request->marketprice;
        $data->goods_price=$request->costpirce;
        $data->vip_price=$request->viprice;
        $data->goods_desc=$request->description;
        $data->keyword=$keywords;
        $data->goods_numbering=$request->numbering;
        $result=$data->save();
        if($result){
            return redirect()->back();
        }else{
            return "更新失败，请稍后重试";
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
}
