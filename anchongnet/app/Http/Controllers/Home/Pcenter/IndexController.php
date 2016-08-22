<?php

namespace App\Http\Controllers\Home\Pcenter;

use Illuminate\Http\Request;
use App\Business;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    private $business;
    public function getIndex()
    {
        return view('home.pcenter.index');
    }
    
    public function getFbgc()
    {
        $this->business = new Business();
        $datas=$this->business->orderBy("created_at","desc")->paginate(8);
        return $datas;
    }
}

