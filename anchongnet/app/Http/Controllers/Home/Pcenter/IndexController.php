<?php

namespace App\Http\Controllers\Home\Pcenter;
use App\Auth;
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
use App\imgpost;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Usermessages;

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
        $user =Users::where('phone',[session('user')])->first();
        $input['users_id']= $user->users_id;
        $rul = [
          'name' =>  'required',
          'introduction' => 'required',
            'brand' => 'required',
            'cate'=> 'required',
            'premises'=> 'required'
        ];
        $mm = [
          'name.required'=> '店铺名称不能为空！',
            'introduction.required'=> '店铺介绍不能为空！',
            'brand.required'=> '主营品牌不能为空！',
            'cate.required' => '主营类别不能为空！',
            'premises.required'=> '经营地址不能为空！'
        ];
        $vali = Validator::make($input,$rul,$mm);
        if($vali->passes()){
            $brand =$input['brand'];
            $cate = $input['cate'];
            $obl = Shop::create($input);
            $sp = Shop::where('users_id',$user->users_id)->first();
            foreach($cate as $c){
               $bra =  ShopCat::insert(
                    array(
                        array(
                            'sid'=>$sp->sid,
                            'cat_id'=>$c
                        )
                    )
                );
            }
            foreach($brand as $d){
               $cam =  Mainbrand::insert(
                    array(
                        array(
                            'sid'=>$sp->sid,
                            'brand_id'=>$d
                        )
                    )
                );
            }
            if($obl and $bra and $cam){
                return back()->with('sucsses','商铺申请成功，请等待审核！！');
            }else{
                return back()->with('er','商铺申请失败，请重新申请！！');
            }
        }else{
            return back()->withErrors($vali);
        }
  }
    /*
     * 基本资料
    */
    public function getBasics()
    {
        return view('home.pcenter.basics');
    }
    
    /**
     * 上传图片
     * @param unknown $img
     */
    public function postUpload($img)
    {
        return imgpost::upload($img);
    }
    
    //基本资料修改
    public function postUpbasic()
    {
        //排除某个字段
        $input = Input::except('_token');
        $input['headpic'] = 'http://anchongres.img-cn-hangzhou.aliyuncs.com/headpic/1470791001.jpg';
        $user = Usermessages::Message(\Auth::user()['users_id']);
        $user->update($input);
        return redirect('/pcenter/index');
    }
    /*
     * 会员认证
    */
    public function honor()
    {
        return view('home.pcenter.honor');
    }
    /*
     * 会员认证提交
     */
    public function quas()
    {
        $input = Input::except('_token');
        $user =Users::where('phone',[session('user')])->first();
        $input['users_id']= $user->users_id;

        $rule = [
               'auth_name'=>'required',
              'qua_name'=> 'required',
            'explanation'=> 'required'
        ];
        $msg = [
          'auth_name.required'=> '公司名称不能为空 ！',
           'qua_name.required'=> '公司名称不能为空 ！',
          'explanation.required'=> '公司名称不能为空 ！'
        ];
        $valid = Validator::make($input,$rule,$msg);
        if($valid->passes()){
           $up = Auth::create($input);
        if($up){
            $mm = '会员认证成功，请等待审核!!';
            return redirect('honor')->with('message',$mm);
        }else{
            return redirect('honor')->with('error','会员申请失败');
        }
        }else{
            return back()->withErrors($valid)->withInput();
        }


        
    }
    /*
     * 上传头像
     */
    public function uphead()
    {
        return view('home.pcenter.head');
    }





}

