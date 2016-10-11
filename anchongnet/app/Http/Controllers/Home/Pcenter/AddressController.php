<?php

namespace App\Http\Controllers\Home\Pcenter;
use App\Http\Controllers\Home\CommonController;
use App\Http\Requests;
use App\Users;
use App\Address;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AddressController extends CommonController
{
    /*
     * 地址管理
    */
    public function index()
    {
         Cache::remember('addrs',10,function(){
        $user =Users::where('phone',[session('user')])->first();
        $addrs =Address::where('users_id',$user->users_id)->get();
        });
        return view('home.pcenter.adress',compact('addrs'));
    }
    public function store()
    {

        $input = Input::except('_token');
        $user =Users::where('phone',[session('user')])->first();
        $input['users_id']= $user->users_id;

        $rules = [
               'add_name'=> 'required',
                'phone'=> 'required|min:11',
                'region'=> 'required',
                'address'=> 'required',
        ];
        $messages = [
             'add_name.required'=>'收货人不能为空！',
             'phone.required'=>'联系人电话不能为空！',
            'phone.min'=>'联系人电话为11位！',
            'region.required'=>'地址不能为空！',
             'address.required'=>'详细地址不能为空！'
        ];
            $vali = Validator::make($input,$rules,$messages);
        if($vali->passes()){
            if(isset($input['isdefault'])){
                $mo = Address::where(['users_id'=>$user->users_id,'isdefault'=>1])->first();
                if(isset($mo)){
                    $mo-> update(['isdefault'=>0]);
                }
               $re=  Address::create($input);
            }else{
                $re =Address::create($input);
            }
           if($re){
               return redirect('adress');
           }else{
               return back()->with('errors','更改地址失败');
           }


        }else{
            return back()->withErrors($vali);
        }

    }

    public function destroy($id)
    {
        $re = Address::where('id',$id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'info' => '地址删除成功！'
            ];
        }else{
            $data = [
              'status'=> 1,
                'info'=> '地址删除失败'
            ];
        }
        return $data;

    }

    public function edit($id)
    {
        $user =Users::where('phone',[session('user')])->first();
        $addrs =Address::where('users_id',$user->users_id)->get();
        $field = Address::find($id);
        return view('home.pcenter.adress',compact('field','addrs'));
    }

    public function update($id)
    {


        
    }
    
    
}
