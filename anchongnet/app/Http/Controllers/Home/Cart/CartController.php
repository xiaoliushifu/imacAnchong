<?php

namespace App\Http\Controllers\Home\Cart;

use App\Cart;
use App\Http\Controllers\Home\CommonController;

class CartController extends CommonController
{
    /*
     * 购物车
     */
    public function show()
    {
        return view('home/cart/cart');
    }
    /*
     *提交购物车数据
     */
    public function store()
    {

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
