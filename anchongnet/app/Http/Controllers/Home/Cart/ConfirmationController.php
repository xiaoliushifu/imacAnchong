<?php

namespace App\Http\Controllers\Home\Cart;

use App\Address;
use App\Http\Controllers\Home\CommonController;
use App\Users;
use Auth;
use Illuminate\Http\Request;

class ConfirmationController extends CommonController
{
    /*
     * 订单确认
     */
    public function index()
    {
        $user=Auth::user();
        //$user =Users::where('phone',[session('user')])->first();
        $deaddr =Address::where('users_id',$user->users_id)->where('isdefault','1')->get();
        $addr = Address::where('users_id',$user->users_id)->where('isdefault','0')->orderBy('id','desc')->take(2)->get();
        return view('home/cart/confirmation',compact('deaddr','addr'));
    }

    /*
     * 订单确认
     */
    public function store(Request $request)
    {
        $data=$request->all();
        //定义json解码后的数组
        $cartdata=[];
        //遍历数组
        foreach ($data['goodsinfo'] as $goodsinfo) {
            $goodsinfo=json_decode($goodsinfo,true);
            $cartdata[]=$goodsinfo;
        }
        //创建购物车和商铺的ORM模型
        $shop=new \App\Shop();
        //下面装商铺的数组
        $shoparr=null;
        //下面装商品的数组
        $goodsarr=null;
        //下面装购物车详情的数组
        $cartarr=null;
        //商铺总价
        $shop_price=0;
        //通过下列一系列的方法将数据格式转换成特定的格式
        foreach ($cartdata as $result) {
            $shoparr[$result['sname']]=$result['sid'];
        }
        foreach ($shoparr as $sname => $sid) {
            foreach ($cartdata as $goods) {
                if($goods['sid'] == $sid){
                    //$goods['goodsinfo']=json_encode($goods);
                    $goodsarr[]=$goods;
                    $shop_price +=($goods['goods_price']*$goods['goods_num']);
                }
            }
            //定义运费价格
            $shop_freight=0;
            //查出运费和需要运费的价格
            $freight=$shop->quer(['free_price','freight'],'sid ='.$sid)->toArray();
            //判断是否免运费
            if($shop_price < $freight[0]['free_price']){
                $shop_freight=$freight[0]['freight'];
            }
            //将数据拼装到一个数组中
            $cartarr[]=['sid'=>$sid,'total_price'=>$shop_price,'freight'=>$shop_freight,'sname' => $sname,'goods'=>$goodsarr];
            $goodsarr=null;
        }
        $cartjson=json_encode($cartarr);
        $user=Auth::user();
        //$user =Users::where('phone',[session('user')])->first();
        $deaddr =Address::where('users_id',$user->users_id)->where('isdefault','1')->take(1)->get();
        $addr = Address::where('users_id',$user->users_id)->where('isdefault','0')->orderBy('id','desc')->get();
        return view('home/cart/confirmation',compact('deaddr','addr','cartjson','cartarr'));
    }
}
