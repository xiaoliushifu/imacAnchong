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

        //将所有属性通过一个for循环拼合起来
        $spetag="";
        for($i=0;$i<count($request->attr);$i++){
            $spetag.=$request->attr[$i]." ";
        }

        $gid = DB::table('anchong_goods_specifications')->insertGetId(
            [
                'cat_id' => $request->midselect,
                'goods_id'=>$request->name,
                'goods_name'=>trim($spetag),
                'market_price'=>$request->marketprice,
                'goods_price'=>$request->costpirce,
                'vip_price'=>$request->viprice,
                'added'=>$request->status,
                'goods_numbering'=>$request->numbering,
                'title'=>$request->commodityname." ".trim($spetag),
                'sid'=>$this->sid,
            ]
        );

        //将关键字转码之后再插入数据库，为将来分词索引做准备
        $keywords_arr=explode(' ',$request->keyword);
        $keywords="";
        foreach ($keywords_arr as $keyword_arr) {
            $keywords.=bin2hex($keyword_arr)." ";
        }

        //将标签转码之后插入数据库，为将来分词索引做准备
        $tags="";
        for($j=0;$j<count($request->tag);$j++){
            $tags.=bin2hex($request->tag[$j])." ";
        }

        //将二级分类转码之后插入数据库，为将来分词索引做准备
        $cid=bin2hex($request->midselect);

        $gtid = DB::table('anchong_goods_type')->insertGetId(
            [
                'gid' => $gid,
                'goods_id'=>$request->name,
                'title'=>trim($request->goodname." ".$spetag),
                'price'=>$request->marketprice,
                'sname'=>'安虫',
                'vip_price'=>$request->viprice,
                'cid'=>$cid,
                'keyword'=>$keywords,
                'tags'=>$tags,
            ]
        );

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
            $gdata=$this->goodSpecification->find($gid);
            $gdata->goods_num=$total;
            $gdata->save();
        }

        /*
         * 通过一个for循环向缩略图表中插入数据
         * */
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
        $data=$this->goodSpecification->find($id);
        $data->goods_id=$request->name;
        $data->cat_id=$request->midselect;
        $data->goods_name=$request->spetag;
        $data->market_price=$request->marketprice;
        $data->goods_price=$request->costpirce;
        $data->vip_price=$request->viprice;
        $data->goods_desc=$request->description;
        $data->keyword=$request->keyword;
        if($request->status==1){
            $goods_create_time=date("Y:m:d H:i:s");
        }else{
            $goods_create_time=date("0000:00:00 00:00:00");
        }
        $data->goods_create_time=$goods_create_time;
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

    /*
     * 获取属于同一商品的所有货品
     * */
    public function getSiblings(Request $request)
    {
        $datas=$this->goodSpecification->Good($request->good)->get();
        return $datas;
    }
}
