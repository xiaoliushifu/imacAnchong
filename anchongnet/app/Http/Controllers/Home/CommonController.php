<?php

namespace App\Http\Controllers\Home;

use App\Usermessages;
use App\Users;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        $pus = session('user');
        if(isset($pus)){
            $user =Users::where('phone',[session('user')])->first();
            $msg = Usermessages::where('users_id',$user->users_id)->first();
            View::share('msg',$msg);
        }

    }
}
