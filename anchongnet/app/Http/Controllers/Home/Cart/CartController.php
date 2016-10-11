<?php

namespace App\Http\Controllers\Home\Cart;

use App\Http\Controllers\Home\CommonController;

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
     * 订单确认
     */
    public function confirm()
    {

        return view('home/cart/confirmation',compact('address'));
    }
}
