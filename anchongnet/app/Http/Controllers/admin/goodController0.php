<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use OSS\OssClient;
use OSS\Core\OssException;
use DB;
use Auth;
use Gate;
use Cache;

use App\GoodSpecification;
use App\GoodThumb;
use App\Stock;
use App\Goods_type;
use App\Shop;
use Input;

class goodController extends Controller
{
    private $goodSpecification;
    private $goodThumb;
    private $stock;
    private $goods_type;

    private $accessKeyId;
    private $accessKeySecret ;
    private $endpoint;
    private $bucket;

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

        $this->accessKeyId=env('ALIOSS_ACCESSKEYId');
        $this->accessKeySecret=env('ALIOSS_ACCESSKEYSECRET');
        $this->endpoint=env('ALIOSS_ENDPOINT');
        $this->bucket=env('ALIOSS_BUCKET');

        //通过Auth获取当前登录用户的id
        $this->uid=Auth::user()['users_id'];
        //通过用户获取商铺id
        $this->sid=Shop::Uid($this->uid)->sid;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Input::has('sid')) {
            //只允许有 “添加货品”权限的家伙
            if (Requester::user()['user_rank'] !=3 || Gate::denies('create-goods')) {
                return back();
            }
            $sid=Input::get('sid');
        } else {
            $sid=$this->sid;
        }
        $keyName=Requester::input('keyName');
        if ($keyName=="") {
            $datas=$this->goodSpecification->where('sid','=',$sid)->orderBy("gid","desc")->paginate(8);
        } else {
            $datas = GoodSpecification::Name($keyName)->where('sid','=',$sid)->orderBy("gid","desc")->paginate(8);
        }
        $args=array("keyName"=>$keyName);
        return view('admin/good/index',array("datacol"=>compact("args","datas"),"sid"=>$sid));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		//添加货品权限
		if (Gate::denies('create-goods')) {
            return back();
		}
        return view('admin/good/create',array('sid'=>$this->sid));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\GoodCreateRequest $request)
    {
        DB::beginTransaction();

        //智能提示。存储所有关键字，来自keyword,attribute,commodityname
        $arr_key=array();

        //将所有属性拼合起来
        $spetag=$attr_k = $comname_k="";
        for($i=0;$i<count($request->attr);$i++){
            //智能提示
            $arr_key[]=trim($request->attr[$i]);
            //title展示
            $spetag.=$request->attr[$i]." ";
        }

        //替换所有的括号
        $comname_k=str_replace(['(','（','）',')'],' ',$request->commodityname);
        //智能提示
        $arr_key=array_merge($arr_key,preg_split('#\s#', $comname_k,-1,PREG_SPLIT_NO_EMPTY));
        //将商品分类转码之后插入数据库，为将来分词索引做准备
        $cids=explode(' ',rtrim($request->type));
        $cid="";
        $catid="";
        for($j=0;$j<count($cids);$j++){
            $cid.=bin2hex($cids[$j])." ";
            $catid.=$cids[$j]." ";
        }

        $shop=new \App\Shop();
        $sname=$shop->quer('name','sid ='.$this->sid)->toArray();
        $gid = DB::table('anchong_goods_specifications')->insertGetId(
            [
                'cat_id'=>$catid,
                'goods_id'=>$request->name,
                'goods_name'=>trim($spetag),
                'market_price'=>$request->marketprice,
                'goods_price'=>$request->costpirce,
                'vip_price'=>$request->viprice,
                'sname' => $sname[0]['name'],
                'added'=>$request->status,
                'goods_numbering'=>$request->numbering,
                'title'=>trim($request->commodityname),
                'sid'=>$this->sid,
            ]
        );

        //取得keyword中的关键字
        $arr_key = array_merge($arr_key,preg_split('#\s#', $request->keyword,-1,PREG_SPLIT_NO_EMPTY));
        //由于来源三处，难免重复，须过滤并编码
        $arr_key=array_unique($arr_key);
        $keywords=str_replace('20', ' ', bin2hex(implode(' ', $arr_key)));

        $gtid = DB::table('anchong_goods_type')->insertGetId(
            [
                'gid' => $gid,
                'cid'=>$cid,
                //'keyword'=>$keywords,
                'goods_id'=>$request->name,
                'title'=>trim($spetag."-".$request->commodityname),
                'price'=>$request->marketprice,
                'sname'=>$sname[0]['name'],
                'vip_price'=>$request->viprice,
                'sid'=>$this->sid,
                'added'=>$request->status,
                'other_id'=>$request->mainselect,
            ]
        );

        //将标签转码之后插入数据库，为将来分词索引做准备
        $tags="";
        for($j=0;$j<count($request->tag);$j++){
            $tags.=bin2hex($request->tag[$j])." ";
        }
        //索引表,用于后续搜索
       DB::table('anchong_goods_keyword')->insert(
            [
                'cat_id' => $gtid,
                'cid' => trim($catid),
                'tags' => $tags,
                'keyword'=>$keywords,
            ]
        );
        //深度搜索的中文分词字符串
        $search_match="";
        //对商品描述进行中文分词
        $seg=new \App\Segment\lib\Segment();
        $res = $seg->get_keyword($request->desc);
        $res_arr=explode(' ',$res);
        foreach ($res_arr as $res_arrs) {
            //为索引表准备数据
            $search_match.=bin2hex($res_arrs)." ";
        }
        //深度搜索表
       DB::table('anchong_goods_search')->insert(
            [
                'cat_id' => $gtid,
                'goods_id'=>$request->name,
                'search_match'=>$keywords.$search_match,
            ]
        );

       //智能提示suggestion表
       foreach($arr_key as $k) {
           DB::insert("insert into anchong_goods_suggestion (`str`) values ('$k') on duplicate key update snums=snums+1");
       }
       /*清除关键字缓存操作*/

       /*清除关键字缓存操作*/

        /*
         * 向仓库表中插入
         * 因为采购无仓储权限，只插入一条记录，留待后续仓储更改
         */
//         for($m=0;$m<count($request['stock']['location']);$m++){
            DB::table('anchong_goods_stock')->insert(
                [
                    'gid' => $gid,
                    'location' => '',
//                     'location' => $request['stock']['location'][$m],
                    'region_num'=>0
//                     'region_num'=>$request['stock']['num'][$m]
                ]
            );
            //$total=$total+$request['stock']['num'][$m];
//         }
//         $gdata=$this->goodSpecification->find($gid);
//         $gdata->goods_num=$total;
//         $gdata->save();

        /*
         * 通过一个for循环向缩略图表中插入数据
         */
        for($i=0;$i<count($request['pic']);$i++){
            if($i==0){
                //如果是第一张，就像货品表和商品类型表中插入图片地址
                $data=$this->goodSpecification->find($gid);
                $data->goods_img=$request['pic'][$i]['url'];
                $data->save();

                $tdata=$this->goods_type->find($gtid);
                $tdata->pic=$request['pic'][$i]['url'];
                $tdata->save();
            }
            DB::table('anchong_goods_thumb')->insert(
                [
                    'gid' => $gid,
                    'img_url' => $request['pic'][$i]['url'],
                    'thumb_url'=>$request['pic'][$i]['url']
                ]
            );
        }

        //提交事务
        DB::commit();

        return view('admin/good/create',array('sid'=>$this->sid,'mes'=>'添加成功'));
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
        DB::beginTransaction();
        $data=$this->goodSpecification->find($id);
        $data->goods_id=$request->name;
        //$data->cat_id=$request->midselect;
        $data->goods_name=$request->spetag;
        $data->market_price=$request->marketprice;
        $data->goods_price=$request->costpirce;
        $data->vip_price=$request->viprice;
        $data->goods_desc=$request->description;
        $data->title=trim($request->goodsname);
        //是否上架
        $data->added=$request->status;
        if($request->status==1){
            $goods_create_time=date("Y:m:d H:i:s");
        }else{
            $goods_create_time=date("0000:00:00 00:00:00");
        }
        $data->goods_create_time=$goods_create_time;
        $data->goods_numbering=$request->numbering;
        $result=$data->save();
        if($result){
            //创建orm模型
            $goods_type=new \App\Goods_type();
            //修改数据
            $goods_type_data=[
                'title' => trim($request->goodsname),
                'price' => $request->marketprice,
                'vip_price'=> $request->viprice,
                'added'=>$request->status,
            ];
            $results=$goods_type->goodsupdate($id,$goods_type_data);
            if($results){
                //假如成功就提交
                DB::commit();
                return redirect()->back();
            }else{
                DB::rollback();
                return redirect()->back();
            }
        }else{
            DB::rollback();
            return redirect()->back();
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
     * 获取属于同一商品的所有货品
     * */
    public function getSiblings(Request $request)
    {
        $datas=$this->goodSpecification->Good($request->good)->get();
        return $datas;
    }

    /*
     * 编辑货品时候添加图片
     * */
    public function addpic(Request $request)
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

            $tid=DB::table('anchong_goods_thumb')->insertGetId(
                [
                    'gid' => $request['gid'],
                    'img_url' => $url,
                    'thumb_url'=>$url
                ]
            );

            $message="上传成功";
            $isSuccess=true;
        }catch (OssException $e) {
            $message="上传失败，请稍后再试";
            $isSuccess=false;
            $url='';
            $tid='';
        }
        return response()->json(['message' => $message, 'isSuccess' => $isSuccess,'url'=>$url,'tid'=>$tid]);
    }
}