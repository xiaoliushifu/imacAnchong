<?php

namespace App\Http\Controllers\Home;

use App\Usermessages;
use App\Users;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cache;
use View;
class CommonController extends Controller
{
    public function __construct()
    {
        $pus = session('user');
        if(isset($pus)){
            $msg =Cache::remember('all',10,function(){
                $user =Users::where('phone',[session('user')])->first();
                return Usermessages::where('users_id',$user->users_id)->first();
            });

            View::share('msg',$msg);

        }

    }
}
