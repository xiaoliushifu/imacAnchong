<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use App\Brand;
use App\Category;

/*
*   该控制器包含了商铺品牌模块的操作
*/
class CatbrandController extends Controller
{
    private $brand;
    private $cat;
    
    /*
	 *  创建ORM
	 */
    public function __construct()
    {
        $this->brand=new Brand();
        $this->cat=new Category();
    }

    /*
	 *	 查询商铺品牌模块
	 */
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
