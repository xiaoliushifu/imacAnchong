<?php

namespace App\Http\Controllers\Home\Cart;

use App\Address;
use App\Http\Controllers\Home\CommonController;
use App\Users;

class ConfirmationController extends CommonController
{
    /*
     * 订单确认
     */
    public function index()
    {
        $user =Users::where('phone',[session('user')])->first();
        $deaddr =Address::where('users_id',$user->users_id)->where('isdefault','1')->get();
        $addr = Address::where('users_id',$user->users_id)->where('isdefault','0')->orderBy('id','desc')->take(2)->get();
        return view('home/cart/confirmation',compact('deaddr','addr'));
    }
}
