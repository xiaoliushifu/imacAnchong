<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Usermessages;
use DB;

class PrizeController extends Controller
{
    public function index() 
    {
        $fieldlist='concact,';
        $ret=array();
        $tmp = DB::select("select um.contact ,ul.username from anchong_usermessages as um,anchong_users_login as ul where ul.users_id=um.users_id  limit 10");
        foreach($tmp as $o) {
            array_push($ret, array($o->contact,$o->username));
        }
        \Log::info($ret);
        return response()->json($ret);
    }
}
