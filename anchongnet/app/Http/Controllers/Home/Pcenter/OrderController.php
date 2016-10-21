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
        $ordernum1 = $orderlist->where('state',1);
        foreach($ordernum1 as $k){
            $mm = $k['order_num'];
            $order1[$mm] = Orderinfo::where('order_num',$mm)->get();
        }
        $ordernum2 = $orderlist->where('state',2);
        foreach($ordernum2 as $k){
            $mm = $k['order_num'];
            $order2[$mm] = Orderinfo::where('order_num',$mm)->get();
        }
        $ordernum3 = $orderlist->where('state',3);
        foreach($ordernum3 as $k){
            $mm = $k['order_num'];
            $order3[$mm] = Orderinfo::where('order_num',$mm)->get();
        }

        return view('home.order.order',compact('orderlist','orderinfo','ordernum1','order1','ordernum2','order2','ordernum3','order3'));
    }

    public function show($order_num)
    {
        $orderdetail = Order::where('order_num',$order_num)->first();
        $orderlist = Orderinfo::where('order_num',$order_num)->get();
        return view('home.order.orderdetail',compact('orderdetail','orderlist'));
    }
}
