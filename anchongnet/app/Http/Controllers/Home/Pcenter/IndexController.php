<?php

namespace App\Http\Controllers\Home\Pcenter;
use App\Brand;
use App\Category;
use App\Collection;
use App\Feedback_reply;
use App\Goods_type;
use App\Http\Controllers\Home\CommonController;
use App\Mainbrand;
use App\Shop;
use App\ShopCat;
use App\Users;
use App\Business;
use Cache;
use Illuminate\Support\Facades\Input;

class IndexController extends CommonController
{
    private $business;
    public function getIndex()
  {
      $pcenter = Cache::remember('pcenter',10,function(){
      $user =Users::where('phone',[session('user')])->first();
      $col = Collection::where(['users_id'=>$user->users_id,'coll_type'=>1])->get(['coll_id'])->toArray();
       return  Goods_type::wherein('gid',$col)->paginate(12);
      });
        return view('home.pcenter.index',compact('pcenter'));
    }
    
    public function getFbgc()
    {
        $this->business = new Business();
        $datas=$this->business->orderBy("created_at","desc")->paginate(8);
        return $datas;
    }
    /*
     * 服务消息
     */
    public function servermsg()
    {
        $serverm = Cache::remember('serverm',10,function(){
        $user =Users::where('phone',[session('user')])->first();
        return  Feedback_reply::where('users_id',$user->users_id)->get();
        });
        return view('home.pcenter.servermsg',compact('serverm'));
    }

    /*
     * 申请商铺
     */
    public function applysp()
    {
        $brand = Brand::get();
       $category = Category::where('parent_id',0)->orderBy('cat_id','asc')->get();

        return view('home.pcenter.applyshop',compact('brand','category'));
    }
     /*
     * 申请商铺
     */
    public function apstore()
    {

        $input = Input::except('_token');
        $brand =$input['brand'];
        $cate = $input['cate'];

        $user =Users::where('phone',[session('user')])->first();
        $input['users_id']= $user->users_id;
         Shop::create($input);
            $sp = Shop::where('users_id',$user->users_id)->first();
             foreach($cate as $c){
                 ShopCat::insert(
                     array(
                         array(
                             'sid'=>$sp->sid,
                             'cat_id'=>$c
                         )
                     )
                 );
             }
        foreach($brand as $d){
            Mainbrand::insert(
                array(
                    array(
                        'sid'=>$sp->sid,
                        'brand_id'=>$d
                    )
                )
            );
        }

      return back();


  }
    /*
     * 基本资料
    */
    public function basics()
    {
        return view('home.pcenter.basics');
    }
    /*
     * 商铺认证
    */
    public function honor()
    {
        return view('home.pcenter.honor');
    }

    /*
     * 上传头像
     */
    public function uphead()
    {
        return view('home.pcenter.head');
    }





}

