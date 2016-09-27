<?php

namespace App\Http\Controllers\Home\Order;

use App\Http\Controllers\Home\CommonController;
use Illuminate\Http\Request;

use App\Http\Requests;

class OrderController extends CommonController
{
    public function index()
    {
        return view('home.order.order');
    }
}
