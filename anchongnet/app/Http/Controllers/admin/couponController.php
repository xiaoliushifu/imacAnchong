<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Coupon_pool;
use DB;

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
        $data = $this->cp->backfilter($req);
        $args=$data['where'];
        $datas = $data['data'];
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
        if (DB::table('anchong_coupon_pool')->insert($field)) {
            return  view('admin/coupon/create',array('mes'=>'添加成功'));
        } else {
            return view('admin/coupon/create',array('mes'=>'添加失败'));
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
            //只更新状态
            if (isset($req['act'])) {
                $arr=array('check-success'=>1,'check-failed'=>0);
                 return DB::table("anchong_coupon_pool")->where('acpid',$req['xid'])->update(['open'=>$arr[$req['act']]]);
            }
            //其他信息更新
            //先验证
            $messages = [
                'title.max' => '标题也太长了吧',
                'cvalue.integer' => '面额值得输入整数吧',
                'cvalue.min' => '面额值不能小于 :min吧',
                'beans.integer' => '虫豆数至少得是整数吧',
                'beans.min' => '虫豆数不能小于 :min吧',
            ];
            $this->validate($req, [
                'title' => 'max:255',
                'cvalue' => 'integer|min:0',
                'beans' =>'integer|min:0',
            ],$messages);
            $field=array('title'=>$req['title'],'cvalue'=>$req['cvalue'],'beans'=>$req['beans']);
            if (DB::table("anchong_coupon_pool")->where('acpid',$req['acpid'])->update($field)) {
                return back();
            } else {
                $mes = '更新失败';
            }
            return  $mes;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req, $id)
    {
        if (isset($req['xid'])) {
            return DB::table("anchong_coupon_pool")->where('acpid',$req['xid'])->delete();
        }
        return 0;
    }
}
