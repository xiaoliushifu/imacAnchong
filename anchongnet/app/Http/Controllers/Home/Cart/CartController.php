<?php

namespace App\Http\Controllers\Home\Cart;

use App\Cart;
use App\Goods_type;
use App\Http\Controllers\Home\CommonController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Auth;
use Redirect;

class CartController extends CommonController
{
    /*
     * 购物车
     */
    public function index()
    {
        return view('home/cart/cart');
    }
    /*
     * 购物车展示
     */
    public function show($users_id)
    {
        try{
            if(Auth::user()->users_id != $users_id){
                abort(404);
            }
        }catch (\Exception $e) {
            return Redirect::to('/user/login');
        }
        // $date = date('H:i:s');
        // $cart = Cache::tags('cart')->remember('cart'.$users_id.$date,600,function ()use($users_id){
        //     return Cart::where('users_id',$users_id)->orderBy('cart_id','desc')->get();
        // });
        // return view('home/cart/cart',compact('cart'));
        $share_cache=Cache::get('cart_'.$users_id);
        if($share_cache){
            $cartarr=$share_cache;
            return view('home/cartshare/index',compact('cartarr'));
        }else{
            //创建购物车的ORM模型
            $cart=new \App\Cart();
            $cartdata=$cart->Cart()->select('cart_id','goods_name','goods_price','img','goods_type','gid','sid','sname','goods_id','oem','goods_num')->where('users_id',$users_id)->get()->toArray();
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
            foreach ($cartdata as $result) {
                $shoparr[$result['sname']]=$result['sid'];
            }
            foreach ($shoparr as $sname => $sid) {
                foreach ($cartdata as $goods) {
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
            Cache::tags('cart_users_'.$users_id)->add('cart_'.$users_id,$cartarr,60);
        }
        return view('home/cart/cart',compact('cartarr'));
    }
    /*
     *添加商品到购物车
     */
    public function store()
    {
        $input = Input::all();
        $user = Auth::user();
        //未登录
        if(!$user) {
            return ['status' => 0,'msg' => '请登录后再添加购物车'];
        }
        $input['users_id'] = $user->users_id;
        //找到该货品
        $info = Goods_type::where('goods_id', $input['goods_id'])->where('gid', $input['gid'])->where('sid', $input['sid'])->first();
        if (!$info) {
            return ['status' => 0,'msg'=>'您查找的商品不存在，或者下架或者被转移'];
        }
        //价格因是否认证而不同
        if ($user->user_rank == '2') {
            $input['goods_price'] = $info->vip_price;
        } else {
            $input['goods_price'] = $info->price;
        }
        $cart = Cart::where('gid', $input['gid'])->where('users_id', $user->users_id)->where('sid', $input['sid'])->where('oem', $input['oem'])->first();
        //有则更新数量，无则添加一条购物车的记录
        $res ='';
        if (!$cart) {
            $res = Cart::create($input);
        //更新数量
        } else {
            $cart->goods_num += $input['goods_num'];
            $res = $cart->update();
        }
        if ($res) {
            return $data = ['status' => 0,'msg' => '购物车添加成功'];
        } else {
            return $data = ['status' => 1,'msg' => '购物车添加失败，请稍后再试'];
        }
    }

    /*
     * 修改购物车
     */
    public function edit($id)
    {
        $num=Input::get('goods_num');
        $cart=Cart::where('cart_id', $id)->update(['goods_num' => $num]);
        if($cart){
            return $num;
        }else{
            return '';
        }
    }
    /*
     * 更改购物车数据
     */
    public function updata()
    {

    }
    /*
     * 删除购物车
     */
    public function destroy($cart_id)
    {
        $re = Cart::where('cart_id',$cart_id)->delete();
        if($re){
            $data =['status' => 0,'msg'  => '商品删除成功'];
        }else{
            $data =['status' => 1,'msg'  => '商品删除失败'];
        }
        return $data;
    }
}
