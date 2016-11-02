<?php

namespace App\Http\Controllers\Home\Cart;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cache;
use Auth;
use Redirect;
use DB;

/*
*   前台购物车分享页面
*/
class CartShareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //判断是否登录
        if(!Auth::check()){
            return "请先登录，并刷新!";
        }
        $data=$request->all();
        //查看购物车是否有改货品
        DB::table('anchong_goods_cart')->where('users_id',Auth::user()['users_id'])->whereIn('gid',$data['gid'])->delete();
        //定义要插入的数组
        $cart_goods=[];
        foreach ($data['goodsinfo'] as $goodsjson) {
            //json格式转成数组
            $goodsinfo=json_decode($goodsjson,true);
            $cart_goods[]=[
                'users_id' => Auth::user()['users_id'],
                'goods_name' => $goodsinfo['goods_name'],
                'goods_num' => $goodsinfo['goods_num'],
                'goods_price' => $goodsinfo['goods_price'],
                'goods_type' => $goodsinfo['goods_type'],
                'img' => $goodsinfo['img'],
                'gid' => $goodsinfo['gid'],
                'created_at' => date('Y-m-d H:i:s',time()),
                'sid' => $goodsinfo['sid'],
                'sname' => $goodsinfo['sname'],
                'goods_id' => $goodsinfo['goods_id'],
                'oem' => $goodsinfo['oem']
            ];
        }
        //插入表内
        $result=DB::table('anchong_goods_cart')->insert($cart_goods);
        if(!$result){
            return "加入购物车失败!";
        }
        return "加入购物车成功!";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($shareId)
    {
        $share_cache=Cache::get('cartshare:'.$shareId);
        if(!$share_cache){
            $cartarr=[];
            return view('home/cartshare/index',compact('cartarr','shareId'));
        }
        //创建购物车和商铺的ORM模型
        $shop=new \App\Shop();
        //var_dump($share_cache);
        //下面装商铺的数组
        $shoparr=null;
        //下面装商品的数组
        $goodsarr=null;
        //下面装购物车详情的数组
        $cartarr=null;
        //通过下列一系列的方法将数据格式转换成特定的格式
        foreach ($share_cache as $result) {
            $shoparr[$result['sname']]=$result['sid'];
        }
        foreach ($shoparr as $sname => $sid) {
            foreach ($share_cache as $goods) {
                if($goods['sid'] == $sid){
                    $goods['goodsinfo']=json_encode($goods);
                    $goodsarr[]=$goods;
                }
            }
            //查出运费和需要运费的价格
            $freight=$shop->quer(['free_price','freight'],'sid ='.$sid)->toArray();
            //将数据拼装到一个数组中
            $cartarr[]=['sid'=>$sid,'free_price'=>$freight[0]['free_price'],'freight'=>$freight[0]['freight'],'sname' => $sname,'goods'=>$goodsarr];
            $goodsarr=null;
        }
        return view('home/cartshare/index',compact('cartarr','shareId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
