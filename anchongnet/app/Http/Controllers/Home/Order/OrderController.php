<?php

namespace App\Http\Controllers\Home\Order;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        return view('home.order.order');
    }
}
