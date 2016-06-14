<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Order;
use App\Orderinfo;
use DB;
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
        $id=$request->oid;
        $data=$this->order->find($id);

        if($request->isPass==="yes"){
            $data->state=5;
        }else{
            $data->state=3;
        }
        $data->save();

        return "设置成功";
    }

    /*
     * 订单发货的方法
     * */
    public function orderShip(Request $request)
    {
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
