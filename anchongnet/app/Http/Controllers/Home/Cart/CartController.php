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

}
