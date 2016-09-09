<?php

namespace App\Http\Controllers\Home;

use App\Business;
use App\Information;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class indexController extends Controller
{
    public function index(){
        $hot = Business::where('type', 1)->orderBy('created_at', 'desc')->take(5)->get();
        $info = Information::orderBy('created_at','desc')->take(2)->get();
        return view('home.index',compact('hot','info'));
    }
}

