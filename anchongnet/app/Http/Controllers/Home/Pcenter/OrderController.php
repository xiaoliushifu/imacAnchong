<?php

namespace App\Http\Controllers\Home\Pcenter;

use App\Http\Controllers\Home\CommonController;
use App\Http\Requests;

class OrderController extends CommonController
{
    public function index()
    {
        return view('home.order.order');
    }

    public function show()
    {
        return view('home.order.orderdetail');
    }
}
