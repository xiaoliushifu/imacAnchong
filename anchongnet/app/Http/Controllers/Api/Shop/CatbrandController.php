<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use App\Brand;
use App\Category;

class CatbrandController extends Controller
{
    private $brand;
    private $cat;

    public function __construct()
    {
        $this->brand=new Brand();
        $this->cat=new Category();
    }

    public function index()
    {
        $cat=[];
        $datas=$this->cat->Pids(0)->get();
        for($i=0;$i<count($datas);$i++){
            $cat=array_add($cat,$i,$datas[$i]);
        }

        $brand=[];
        $datas1=$this->brand->get();
        for($i=0;$i<count($datas1);$i++){
            $brand=array_add($brand,$i,$datas1[$i]);
        }
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['cat'=>$cat,'brand'=>$brand]]);
    }
}
