<?php

namespace App\Http\Controllers\Home\Cart;

use App\Cart;
use App\Goods_specifications;
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
        $user = Auth::user();
        if (!$user) {
            return Redirect::to('/user/login');
        }
        $users_id = $user->users_id;
        $cartarr=[];
        $share_cache=Cache::get('cart_'.$users_id);
        if($share_cache){
            $cartarr=$share_cache;
            return view('home/cartshare/index',compact('cartarr'));
        }else{
            //创建购物车的ORM模型
            $cart=new \App\Cart();
            $data = ['cart_id','goods_name','goods_price','img','goods_type','gid','sid','sname','goods_id','oem','goods_num','promotion'];
            $cartdata=$cart->select($data)->where('users_id',$users_id)->get()->toArray();
            $shop=new \App\Shop();
            $shoparr=[];
            $goodsarr=null;
            //数据格式转换
            foreach ($cartdata as $result) {
                $shoparr[$result['sname']]=$result['sid'];
            }
            foreach ($shoparr as $sname => $sid) {
                foreach ($cartdata as $goods) {
                    if ($goods['sid'] == $sid) {
                        $goods['goodsinfo'] = json_encode($goods);
                        $goodsarr[]=$goods;
                    }
                }
                //查出运费和起运价
                $freight=$shop->quer(['free_price','freight'],'sid ='.$sid)->first();
                $cartarr[]=['sid'=>$sid,'free_price'=>$freight['free_price'],'freight'=>$freight['freight'],'sname' => $sname,'goods'=>$goodsarr];
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
//         if(!Input::ajax()) {
//            return ['status' => 0,'msg' => '请登录后再添加购物车'];
//         }
        //未登录
        if(!$user) {
            return ['status' => 0,'msg' => '请登录后再添加购物车'];
        }
        $input['users_id'] = $user->users_id;
        //type表看看
        $info = Goods_type::where('goods_id', $input['goods_id'])->where('gid', $input['gid'])->where('sid', $input['sid'])->where('added',1)->first();
        if (!$info) {
            \Log::info('goods_type无',['into_cart']);
            return ['status' => 0,'msg'=>'您查找的商品不存在，或者下架或者被转移'];
        }
        //spe表看看
        $speinfo = Goods_specifications::where('goods_id', $input['goods_id'])->where('gid', $input['gid'])->where('sid', $input['sid'])->where('added',1)->first();
        if (!$speinfo) {
            \Log::info('Goods_specifications无',['into_cart']);
            return ['status' => 0,'msg'=>'您查找的商品不存在，或者下架或者被转移'];
        }
        //规格(属性)判定
        if(!strstr($speinfo['goods_name'],trim($input['goods_type']))){
            \Log::info('mismatch'.$speinfo['goods_name'].'--'.$input['goods_type'],['into_cart']);
            return ['status' => 0,'msg'=>'您查找的商品不存在，或者下架或者被转移'];
        }
        //价格因是否认证而不同
        //又因是否参与促销而不同
        if ($user->user_rank == '2') {
            if ($speinfo->promotion_price > 0 && $speinfo->vip_price > $speinfo->promotion_price ) {
                $input['goods_price'] = $speinfo->promotion_price;
                $input['promotion'] = 1;
            } else {
                $input['goods_price'] = $speinfo->vip_price;
                $input['promotion'] = 0;
            }
        } else {
            if ($speinfo->promotion_price > 0) {
                $input['goods_price'] = $speinfo->promotion_price;
                $input['promotion'] = 1;
            } else {
                $input['goods_price'] = $speinfo->market_price;
                $input['promotion'] = 0;
            }
        }
        $cart = Cart::where('gid', $input['gid'])->where('users_id', $user->users_id)->where('sid', $input['sid'])->where('oem', $input['oem'])->first();
        //有则更新数量，无则添加一条购物车的记录
        $res ='';
        if (!$cart) {
            $res = Cart::create($input);
        //更新数量
        } else {
            $cart->goods_num += $input['goods_num'];
            //促销活动开始前已经加入购物车的，而促销活动期间恰巧该商品又参与促销，统一下述几项
            $cart->goods_type = $input['goods_type'];//商品规格
            $cart->goods_price = $input['goods_price'];//商品价格
            $cart->promotion = $input['promotion'];//促销标识
            $res = $cart->update();
        }
        if ($res) {
            return $data = ['status' => 0,'msg' => '购物车添加成功'];
        } else {
            return $data = ['status' => 1,'msg' => '购物车添加失败，请稍后再试'];
        }
    }

    /*
     * 修改购物车中商品数量
     */
    public function edit($id)
    {
        $user = Auth::user();
        if (!$user) {
            return back();
        }
        $num=Input::get('goods_num');
        $cart=Cart::where('cart_id', $id)->where('users_id',$user->users_id)->update(['goods_num' => $num]);
        if ($cart) {
            return $num;
        } else {
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
     * 删除购物车中一种商品
     */
    public function destroy($cart_id)
    {
        $user = Auth::user();
        if (!$user) {
            return back();
        }
        $re = Cart::where('cart_id',$cart_id)->where('users_id',$user->users_id)->delete();
        return ['status' => 0,'msg'  => '商品删除成功'];
    }
}
