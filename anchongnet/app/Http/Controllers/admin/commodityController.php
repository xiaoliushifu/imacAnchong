<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Goods;
use App\Shop;
use Auth;
use DB;
use Gate;
use Cache;

use OSS\OssClient;
use OSS\Core\OssException;

/**
*   该控制器包含了商品模块的操作
*/
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
        //通过Auth获取当前登录用户的id
        $this->accessKeyId=env('ALIOSS_ACCESSKEYId');
        $this->accessKeySecret=env('ALIOSS_ACCESSKEYSECRET');
        $this->endpoint=env('ALIOSS_ENDPOINT');
        $this->bucket="anchongres";
        $user = Auth::user();
        $this->uid = $user->users_id;
        //管理员身份，仅仅操作安虫自营商铺
        if ($user->user_rank == 3) {
            $this->sid = 1;
        } else {
            //是否开通商铺
            $shop = Shop::where('users_id',$this->uid)->first();
            if ($shop) {
                $this->sid=$shop->sid;
            } else {
                return null;
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $this->goods=new Goods();
        $keyName=$req->get('keyName');
        $keyName2=$req->get('keyName2');
        if ($keyName2) {
            $datas=$this->goods->where('sid','=',$this->sid)->where('goods_id',$keyName2)->paginate(1);
        } elseif ($keyName) {
            $datas=$this->goods->where('sid','=',$this->sid)->Name($keyName)->orderBy("goods_id","desc")->paginate(8);
        } else {
            $datas=$this->goods->where('sid','=',$this->sid)->orderBy("goods_id","desc")->paginate(8);
        }
        $args=array("keyName"=>$keyName,"keyName2"=>$keyName2);
        return view('admin/good/index_commodity',array("datacol"=>compact("args","datas"),"sid"=>$this->sid));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('create-comm')) {
            return back();
        }
        return view("admin/good/create_commodity",array('sid'=>$this->sid));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request('keyword'关键字,'name'商品名,'sid'商铺ID,'description'描述,'midselect'分类ID,'remark'备注,'pic'图片数组,'param'描述参数,'data'附件,'oem'商品OEM,'attrname'商品属性,'gid'商品ID,'supgoodsid'配套商品ID数组,'title'配套标题数组,'price'配套价格数组,'img'配套图片数组,'goodsname'配套商品名)
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\CommodityRequest $request)
    {
        var_dump($request->all());
        exit;
        if (Gate::denies('create-comm')) {
            return back();
        }
        /**
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
            if (mb_strlen($k,'utf-8') < 20 ) {
                $keywords.=$k." ";
            }
        };

        //存储商品的分类信息，转码
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
        if ($request->oem) {
            DB::table('anchong_goods_oem')->insert(['goods_id'=>$gid,'value'=>$request->oem]);
        }

        //属性（规格）入库(必填项)
        $arrdata = [];
        for($i=0;$i<count($request->attrname);$i++){
            $arrdata[]=['goods_id' => $gid, 'name' => $request->attrname[$i], 'value' => $request->attrvalue[$i]];
        }
        DB::table('anchong_goods_attribute')->insert($arrdata);

        //通过循环向配套商品表中插入数据
        $supdata=[];
        for($i=0; $i<count($request->supgoodsid); $i++) {
            //配套商品的货品信息(title,price)
            if(isset($request->title[$i]) && !empty($request->title[$i])){
                $supdata[] =   [
                    'goods_id'=>$request->supgoodsid[$i],
                    'gid'=>$request->gid[$i],
                    'title'=>$request->title[$i],
                    'price'=>$request->price[$i],
                    'img'=>$request->img[$i],
                    'assoc_gid'=>$gid,//和本次录入的商品关联
                    'goods_name'=>$request->goodsname[$i]
                ];
            }
        }
        DB::table('anchong_goods_supporting')->insert($supdata);

        //提交事务
        DB::commit();
        return view("admin/good/create_commodity",array('sid'=>$this->sid,'mes'=>"添加成功！"));
    }

    /**
     * Display the specified resource.
     *添加货品页，选择商品时触发
     * @param  int  $id商品
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->goods=new Goods();
        $data=$this->goods->where('goods_id',$id)->get(array('keyword','type','desc','sid'));
        if (!$data || Gate::denies('shopres',$data[0])) {
            return null;
        }
        //商品类型转码
        $arr=preg_split('#\s#', $data[0]['type'],-1,PREG_SPLIT_NO_EMPTY);
        $str="";
        for($i=0;$i<count($arr);$i++){
            $str.=hex2bin($arr[$i])." ";
        }
        $data[0]['type']=$str;
        return $data[0];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id商品
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->goods=new Goods();
        $data=$this->goods->find($id);
        /*
        *   该条商品资源属主是否是当前用户
        */
        if (Gate::denies('shopres',$data)) {
            return null;
        }
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request('keyword'关键字,'description'描述,'midselect'分类ID,'title'商品名,'param'描述参数,'data'附件,'oem'商品OEM)
     * @param  int  $id商品
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->goods=new Goods();
        $data=$this->goods->find($id);
        if (Gate::denies('shopres',$data)) {
            return null;
        }
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
            if (mb_strlen($k,'utf-8') < 20) {
                $keywords.=$k." ";
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

        /**oem修改 START*/
        if ($request['oem']) {
            //因该功能是后期添加，故照顾以前的数据，有则更新，无则插入
            $oem = $request['oem'];
            DB::insert("insert into anchong_goods_oem(`goods_id`,`value`) values('$id','$oem') on duplicate key update value='$oem'");
        }
        /**oem的修改 END*/
        //属性信息不在此处更新，在编辑页单独修改
        if ($result) {
            return redirect()->back();
        } else {
            return "更新失败，请返回重试";
        }
    }

    /**
     * 商品与货品的级联删除
     *
     * @param  $request('npx'标识)
     * @param  int  $id商品ID
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req, $id)
    {
        $this->goods=new Goods();
        $id = $req->get('npx');
        try{
            DB::beginTransaction();
            
            $data = DB::table('anchong_goods')->where('goods_id',$id)->get();
            if (!$data || Gate::denies('shopres',$data)) {
                return null;
            }
            //货品相关
            $gid = DB::table('anchong_goods_specifications')->where('goods_id',$id)->pluck('gid');
            $res['stock'] = DB::table('anchong_goods_stock')->whereIn('gid',$gid)->delete();
            $res['thumb'] = DB::table('anchong_goods_thumb')->whereIn('gid',$gid)->delete();
            $cid = DB::table('anchong_goods_type')->whereIn('gid',$gid)->pluck('cat_id');
            $tid = DB::table('anchong_goods_type')->whereIn('gid',$gid)->delete();
            $res['keyword'] = DB::table('anchong_goods_keyword')->whereIn('cat_id',$cid)->delete();
            $res['specifi'] = DB::table('anchong_goods_specifications')->where('goods_id',$id)->delete();

            //再删商品相关的
            $res['goods'] = DB::table('anchong_goods')->where('goods_id',$id)->delete();
            $res['oem'] = DB::table('anchong_goods_oem')->where('goods_id',$id)->delete();
            $res['attr'] = DB::table('anchong_goods_attribute')->where('goods_id',$id)->delete();
            $res['supp'] = DB::table('anchong_goods_supporting')->where('assoc_gid',$id)->delete();
            DB::commit();

            //搜索缓存删除
            Cache::tags('s')->flush();
            return '删除商品成功';
        } catch (\Exception $e) {
            return '商品删除有误';
        }
    }

    /**
     * 根据分类信息获取商品
     *
     * @param  $request('pid'类型ID,'sid'商铺ID)
     * @return \Illuminate\Http\Response
     */
    public function getBycat(Request $request)
    {
        $type=$request['pid'];
        $data=Goods::Type($type,$request['sid'])->get();
        return $data;
    }

    /**
     * 获取商品关键词
     *
     * @param  $request('goods_id'商品ID,'keyword'关键字)
     * @return \Illuminate\Http\Response
     */
    public function getKeywords(Request $request)
    {
        $goods_id=$request['goods_id'];
        $keywords=DB::table('anchong_goods')->where('goods_id',$goods_id)->pluck('keyword');
        return $keywords;
    }

    /**
     * 更新图片方法
     *
     * @param  $request('file'文件对象,'gid'商品ID)
     * @return \Illuminate\Http\Response
     */
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
            $this->goods=new Goods();
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

    /**
     * 根据商品id获得oem
     *
     * @param  $req('gid'商品ID)
     * @return \Illuminate\Http\Response
     */
    public function oem(Request $req)
    {
       return DB::table('anchong_goods_oem')->whereGoods_id($req->gid)->get();
    }
}
