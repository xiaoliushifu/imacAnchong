<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;

use App\Http\Controllers\Controller;
use App\Order;
use App\Orderinfo;
use DB;
use Gate;
use Auth;
use App\Shop;
use App\Goods_logistics;

/**
*   该控制器包含了订单模块的操作
*/
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

        //通过Auth获取当前登录用户的id
        $this->uid=Auth::user()['users_id'];
        if (!is_null($this->uid)){//通过用户获取商铺id
            $this->sid=Shop::Uid($this->uid)->sid;
        }
    }

    /**
	 * 后台订单管理列表
     *
     * @param  input('KEYNUM'区分查询数据的关键字)
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kn=Requester::input('keyNum');
        if ($kn) {
            $datas = Order::num($kn,$this->sid)->orderBy("order_id","desc")->paginate(8);
        } else {
            $datas=$this->order->where("sid","=",$this->sid)->orderBy("order_id","desc")->paginate(8);
        }
        $args=array("keyNum"=>$kn);
        return view('admin/order/index',array("datacol"=>compact("args","datas")));
    }

    /**
     * 显示后台添加订单页面
     *
     * @param  $request('','','','','')
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request('','','','','')
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
     * @param  $request('status'订单状态)
     * @param  int  $id订单ID
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

    /**
     * 审核订单，ajax调用
     *
     * @param  $request('isPass'是否退货,'num'订单标号,'gid'货品ID,'oid'订单ID)
     * @return \Illuminate\Http\Response
     */
    public function checkorder(Request $request)
    {
        //获取订单ID
        $id=$request->oid;
        //得到操作订单数据的句柄
        $data=$this->order->find($id);
        //开启事务处理
        DB::beginTransaction();
        //判断是否通过退货
        if ($request->isPass==="pass") {
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
        } else {
            //改变订单状态为代发货
            $data->state=3;
        }
        $data->save();
        //假如成功就提交
        DB::commit();
        return "操作成功";
    }

    /**
     * 订单发货的方法
     * 由订单列表页，点击"发货",选择完发货方式后执行
     *
     * @param  $request('orderid'订单ID,'ship'行为参数,'lognum'物流单号,'logistics'企业)
     * @return \Illuminate\Http\Response
     */
    public function orderShip(Request $request)
    {
        //权限判定
        if (Gate::denies('order-ship')) {
            return back();
        }
        //改状态为'3待收货'
        $data=$this->order->find($request['orderid']);
        $data->state=3;
        $users_id=$data->users_id;
        $order_num=$data->order_num;
        $data->save();

        // $datainfo=$this->orderinfo->Num($request['ordernum'])->first();
        // if($datainfo){
        //     $datainfo->state=3;
        //     $datainfo->save();
        // }
        //物流发货方式
        if ($request['ship'] == "logistics") {
            $this->gl=new Goods_logistics();
            $this->gl->logisticsnum=$request['lognum'];//物流单号，需我们手动填写
            $this->gl->order_id=$request['orderid'];
            $this->gl->company=$request['logistics'];
            $this->gl->save();
        }
        $this->propleinfo($users_id,'订单发货通知','您订单编号为'.$order_num.'的订单已发货，感谢您对安虫平台的支持！');
        return "发货成功";
    }

    /**
    *    该方法提供了订单的推送服务
    *
    * @param  用户ID  $users_id
    * @param  标题    $title
    * @param  信息    $message
    * @return \Illuminate\Http\Response
    */
    private function propleinfo($users_id,$title,$Message)
    {
        //处理成功给用户和商户推送消息
        try{
            //创建ORM模型
            $users=new \App\Users();
            $this->propel=new \App\Http\Controllers\admin\Propel\PropelmesgController();
            //推送消息
            $this->propel->apppropel($users->find($users_id)->phone,$title,$Message);
            DB::table('anchong_feedback_reply')->insertGetId(
                [
                    'title' => $title,
                    'content' => $Message,
                    'users_id' => $users_id,
                ]
             );
             return true;
        }catch (\Exception $e) {
            // 返回处理完成
            return true;
        }
    }
}
