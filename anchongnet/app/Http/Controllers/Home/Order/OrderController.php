<?php

namespace App\Http\Controllers\Home\Order;

use App\Http\Controllers\Home\CommonController;

class OrderController extends CommonController
{
    public function index()
    {
        return view('home.order.order');
    }
}
