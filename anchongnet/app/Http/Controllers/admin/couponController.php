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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        try{
            $pa = $req->all();
            //只更新状态
            if (isset($pa['act'])) {
                $arr=array('check-success'=>1,'check-failed'=>0);
                 return  DB::update("update `anchong_coupon_pool` set `open`={$arr[$pa['act']]} where `acpid`={$pa['xid']} ");
                 //$res = DB::table("anchong_coupon_pool")->where('acpid',$pa['xid'])->update(['open'=>'00']);
            }
            
//             \Log::info($req->all());
            //更新其他详情
            } catch(\Exception $e) {
                return 0;
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
