<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Good;

class uEditorController extends Controller
{
    private $good;
    public function __construct()
    {
        $this->good=new Good();
    }

    public function getParam(Request $request)
    {
        $data=$this->good->find($request['gid']);
        return $data['param'];
    }

    public function getPackage(Request $request)
    {
        $data=$this->good->find($request['gid']);
        return $data['package'];
    }
}
