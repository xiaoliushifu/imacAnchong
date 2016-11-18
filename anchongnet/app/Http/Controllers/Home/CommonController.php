<?php

namespace App\Http\Controllers\Home;

use App\Usermessages;
use App\Users;
use App\Http\Controllers\Controller;
use Auth;
use Cache;
use View;
class CommonController extends Controller
{
    public function __construct()
    {
        if (Auth::check()) {
            $users=Auth::user();
            $user = Cache::remember('user',10,function() use($users){
                return Users::where('users_id', $users->users_id)->first();
            });
            $msg = Cache::remember('all', 10, function () use($users){
                return Usermessages::where('users_id', $users->users_id)->first();
            });
            View::share(['msg'=> $msg,'user'=> $user]);
        }
    }
}
