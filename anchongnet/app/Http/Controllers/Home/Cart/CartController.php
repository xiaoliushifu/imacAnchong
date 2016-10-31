<?php

namespace App\Http\Controllers\Home\Cart;

use App\Cart;
use App\Goods_type;
use App\Http\Controllers\Home\CommonController;
use App\Usermessages;
use App\Users;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

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
        $date = date('H:i:s');
        $cart = Cache::tags('cart')->remember('cart'.$users_id.$date,600,function ()use($users_id){
            return Cart::where('users_id',$users_id)->orderBy('cart_id','desc')->get();
        });
        return view('home/cart/cart',compact('cart'));
    }
    /*
     *提交购物车数据
     */
    public function store()
    {
        $input = Input::except('_token');
        $date = date('Y-m-d H:i:s');
        $input['created_at']= $date;
        if(session('user')) {
            //如果用户登录，数据直接写进数据库
            $user = Users::where('phone', [session('user')])->first();
            $msg = Usermessages::where('users_id', $user->users_id)->first();
            $userid = $msg->users_id;
            $input['users_id'] = $userid;
            $info = Goods_type::where('goods_id', $input['goods_id'])->where('gid', $input['gid'])->first();
            if ($user->certification == '3') {
                $price = $info->vip_price;
            } else {
                $price = $info->price;
            }
            $cart = Cart::where('goods_id', $input['goods_id'])->where('gid', $input['gid'])->where('users_id', $userid)->where('oem', $input['oem'])->count();
            //判断价格是否相符
            if ($price == $input['goods_price']) {
                if ($cart == 0) {
                    //购物车没有相同商品则添加
                    $re = Cart::create($input);
                    if ($re) {
                        $data = [
                            'status' => 0,
                            'msg' => '购物车添加成功'
                        ];
                    } else {
                        $data = [
                            'status' => 1,
                            'msg' => '购物车添加失败,，请稍后再试'
                        ];
                    }
                } else {
                    //购物车存在相同商品，只更新数量
                    $num = Cart::where('goods_id', $input['goods_id'])->where('gid', $input['gid'])->where('users_id', $userid)->first();
                    $num->goods_num = $num->goods_num + $input['goods_num'];
                    $re = $num->update();
                    if ($re) {
                        $data = [
                            'status' => 0,
                            'msg' => '购物车添加成功'
                        ];
                    } else {
                        $data = [
                            'status' => 1,
                            'msg' => '购物车添加失败，请稍后再试'
                        ];
                    }
                }
            } else {
                $data = [
                    'status' => 1,
                    'msg' => '购物车添加失败，请稍后再试'
                ];
            }
            return $data;
        }else{
            //用户未登录，请求用户登陆
            $data =[
                'status' => 0,
                'msg'    => '请登录后再添加购物车'
            ];
        }
        return $data;
    }

    /*
     * 修改购物车
     */
    public function edit()
    {

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
            $data =[
                'status' => 0,
                'msg'  => '商品删除成功'
            ];
        }else{
            $data =[
                'status' => 1,
                'msg'  => '商品删除失败'
            ];
        }
        return $data;
    }
}
