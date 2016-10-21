<?php

namespace App\Http\Controllers\Home\Cart;

use App\Cart;
use App\Http\Controllers\Home\CommonController;
use App\Usermessages;
use App\Users;
use Illuminate\Support\Facades\Input;

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
    public function show($cart_id)
    {

    }
    /*
     *提交购物车数据
     */
    public function store()
    {
        $input = Input::except('_token');
        $date = date('Y-m-d H:i:s');
        $input['created_at']= $date;
        if(session('user')){
            //如果用户登录，数据直接写进数据库
            $user = Users::where('phone', [session('user')])->first();
            $msg = Usermessages::where('users_id', $user->users_id)->first();
            $userid= $msg->users_id;
            $input['users_id'] = $userid;
            $cart = Cart::where('goods_id',$input['goods_id'])->where('gid',$input['gid'])->where('users_id',$userid)->count();
            if($cart == 0){
                //购物车没有相同商品，添加新的数据
                $re = Cart::create($input);
                if($re){
                    $data =[
                        'status' => 0,
                        'msg' => '购物车添加成功'
                    ];
                }else{
                    $data =[
                        'status' => 1,
                        'msg' => '购物车添加失败'
                    ];
                }
                return $data;
            }else{
                //购物车存在相同商品，只更新数量
                $num = Cart::where('goods_id',$input['goods_id'])->where('gid',$input['gid'])->where('users_id',$userid)->first();
                $num -> goods_num =$num -> goods_num + $input['goods_num'];
                $re = $num -> update();
                if($re){
                    $data =[
                        'status' => 0,
                        'msg' => '购物车添加成功'
                    ];
                }else{
                    $data =[
                        'status' => 1,
                        'msg' => '购物车添加失败'
                    ];
                }
                return $data;
            }
        }

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
    public function destory()
    {

    }
}
