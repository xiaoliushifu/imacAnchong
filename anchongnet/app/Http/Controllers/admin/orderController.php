<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Order;
use App\Orderinfo;
use DB;
use Gate;
use Auth;
use App\Shop;
use App\Goods_logistics;

class orderController extends Controller
{
    private $order;
    private $orderinfo;
    private $uid;
    private $sid;
    private $gl;
    public function __construct()
    {
        $this->order=new Order();
        $this->orderinfo=new Orderinfo();
        $this->gl=new Goods_logistics();

        //通过Auth获取当前登录用户的id
        $this->uid=Auth::user()['users_id'];
        //通过用户获取商铺id
        $this->sid=Shop::Uid($this->uid)->sid;
    }

    /**
	 * 后台订单管理列表
	 */
    public function index(){
        $keyNum=Requester::input('keyNum');
        if($keyNum==""){
            $datas=$this->order->where("sid","=",$this->sid)->orderBy("order_id","desc")->paginate(8);
        }else{
            $datas = Order::num($keyNum,$this->sid)->orderBy("order_id","desc")->paginate(8);
        }
        $args=array("keyNum"=>$keyNum);
        return view('admin/order/index',array("datacol"=>compact("args","datas")));
    }

    /**
     * 显示后台添加订单页面
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$this->order->find($id);
        if($request->iSend==true){
            $data->state=$request->status;
            $data->save();
            return "提交成功";
        }else{

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
    }

    /*
     * 审核订单的方法
     * */
    public function checkorder(Request $request)
    {
        //获取订单ID
        $id=$request->oid;
        //得到操作订单数据的句柄
        $data=$this->order->find($id);
        //开启事务处理
        DB::beginTransaction();
        //判断是否通过退货
        if($request->isPass==="yes"){
            //若通过退货则改变订单状态并将商品数量还原
            $datasarr=$this->orderinfo->where('order_num','=',$request->num)->get()->toArray();
            //遍历得到的结果
            foreach ($datasarr as $datas) {
                //更改货品列表的数量
                DB::table('anchong_goods_specifications')->where('gid','=',$datas['gid'])->increment('goods_num',$datas['goods_num']);
                //更改区域表的数量
                DB::table('anchong_goods_stock')->where('gid','=',$datas['gid'])->increment('region_num',$datas['goods_num']);
            }
            //改变订单状态为已退款
            $data->state=5;
        }else{
            //改变订单状态为代发货
            $data->state=3;
        }
        $data->save();
        //假如成功就提交
        DB::commit();
        return "操作成功";
    }

    /*
     * 订单发货的方法
     * */
    public function orderShip(Request $request)
    {
        //权限判定
        if (Gate::denies('order-ship')) {
            return back();
        }
        $data=$this->order->find($request['orderid']);
        $data->state=3;
        $data->save();

        $datainfo=$this->orderinfo->Num($request['ordernum'])->first();
        if($datainfo){
            $datainfo->state=3;
            $datainfo->save();
        }

        if($request['ship']=="logistics"){
            $this->gl->logisticsnum=$request['lognum'];
            $this->gl->order_id=$request['orderid'];
            $this->gl->company=$request['logistics'];
            $this->gl->save();
        }
        return "发货成功";
    }
}
