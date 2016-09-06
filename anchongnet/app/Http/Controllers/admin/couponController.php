<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Coupon_pool;
use DB;
use Illuminate\Contracts\Validation\ValidationException;

class couponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $this->cp = new Coupon_pool();
        $datas = $this->cp->orderBy("acpid","desc")->paginate(8);
        $args=array("acpid"=>1,"open"=>1);
        return view('admin/coupon/index',array("datacol"=>compact("args","datas")));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/coupon/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        try{
        $messages = [
            'title.between' => '标题应该在:min--:max之间',
            'cvalue.integer' => '面额值得输入整数吧',
            'cvalue.min' => '面额值得大于 :min吧',
            'beans.integer' => '至少得是整数吧',
        ];
        $this->validate($req, [
            'title' => 'between:5,255',
            'cvalue' => 'integer|min:0',
            'beans' =>'integer|min:0',
        ],$messages);
        $field=array('title'=>$req['title'], 'cvalue'=>$req['cvalue'], 'beans'=>$req['beans'], 'type'=>$req['type'], 'type2'=>$req['type2']);
        if (DB::table('anchong_coupon_pool')->insert($field) ){
            return  view('admin/coupon/create',array('mes'=>'添加成功'));
        } else {
            return view('admin/coupon/create',array('mes'=>'添加失败'));
        }
        }catch(\Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
            $pa = $req->all();
            //只更新状态
            if (isset($pa['act'])) {
                $arr=array('check-success'=>1,'check-failed'=>0);
                 return  DB::update("update `anchong_coupon_pool` set `open`={$arr[$pa['act']]} where `acpid`={$pa['xid']} ");
                 //$res = DB::table("anchong_coupon_pool")->where('acpid',$pa['xid'])->update(['open'=>'00']);
            }
            //其他信息更新
            //先验证
            $messages = [
                'title.max' => '标题也太长了吧',
                'cvalue.integer' => '面额值得输入整数吧',
                'cvalue.min' => '面额值得大于 :min吧',
                'beans.integer' => '至少得是整数吧',
            ];
            $this->validate($req, [
                'title' => 'max:255',
                'cvalue' => 'integer|min:0',
                'beans' =>'integer|min:0',
            ],$messages);
            $field=array('title'=>$req['title'],'cvalue'=>$req['cvalue'],'beans'=>$req['beans']);
            if (DB::table("anchong_coupon_pool")->where('acpid',$pa['acpid'])->update($field)) {
                return back();
            } else {
                return '修改有误';
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
