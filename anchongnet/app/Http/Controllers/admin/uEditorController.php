<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Goods;

class uEditorController extends Controller
{
    private $goods;
    public function __construct()
    {
        $this->goods=new Goods();
    }

    public function getParam(Request $request)
    {
        $data=$this->goods->find($request['gid']);
        return $data['param'];
    }

    public function getPackage(Request $request)
    {
        $data=$this->goods->find($request['gid']);
        return $data['package'];
    }
}
