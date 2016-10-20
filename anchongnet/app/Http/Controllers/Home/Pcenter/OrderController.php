<?php

namespace App\Http\Controllers\Home\Pcenter;

use App\Http\Controllers\Home\CommonController;
use App\Http\Requests;
use App\Order;
use App\Orderinfo;
use App\Users;

class OrderController extends CommonController
{
    public function index()
    {
        $user =Users::where('phone',[session('user')])->first();
        $orderlist = Order::where('users_id',$user->users_id)->get();
          foreach($orderlist as $k){
            $mm = $k['order_num'];
             $orderinfo[$mm] = Orderinfo::where('order_num',$mm)->get();
          }

        return view('home.order.order',compact('orderlist','orderinfo'));
    }

    public function show()
    {
        return view('home.order.orderdetail');
    }
}
