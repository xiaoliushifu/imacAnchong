<?php

namespace App\Http\Controllers;

use App\Usermessages;
use App\Users;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


//    public function __construct()
//    {
//        $user =Users::where('phone',[session('user')])->get();
//        $msg = Usermessages::where('users_id',$user[0]->users_id)->get();
//        View::share('msg',$msg);
//    }



}
