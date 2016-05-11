<?php

namespace App\Http\Controllers\Api\Cart;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use Validator;
use DB;

/*
*   操作购物车的控制器
*/
class CartController extends Controller
{
    /*
    *   购物车添加
    */
    public function cartadd(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建购物车的ORM模型
        $cart=new \App\Cart();
        //用户传过来的数据
        $cart_data=[
            'users_id' => $data['guid'],
            'goods_name' => $param['goods_name'],
            'goods_num' => $param['goods_num'],
            'goods_price' => $param['goods_price'],
            'goods_type' => $param['goods_type'],
            'gid' => $param['gid'],
            'created_at' => date('Y-m-d H:i:s',$data['time']),
            'sid' => $param['sid'],
            'sname' => $param['sname'],
        ];
        $result=$cart->add($cart_data);
        //看是否插入成功
        if($result){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'购物车添加成功！']]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>11,'ResultData'=>['Message'=>'购物车添加失败！']]);
        }
    }

    /*
    *   购物车查看
    */
    public function cartinfo(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建购物车的ORM模型
        $cart=new \App\Cart();
        //定义查询的数组
        $cart_data=['cart_id','goods_name','goods_num','goods_price','goods_type','gid','sid','sname'];
        //得到结果
        $results=$cart->quer($cart_data,'users_id = '.$data['guid'])->toArray();
        //下面装商铺的数组
        $shoparr=null;
        //下面装商品的数组
        $goodsarr=null;
        //下面装购物车详情的数组
        $cartarr=null;
        //通过下列一系列的方法将数据格式转换成特定的格式，详见接口文档
        foreach ($results as $result) {
            $shoparr[$result['sname']]=$result['sid'];
        }
        foreach ($shoparr as $sname => $sid) {
            foreach ($results as $goods) {
                if($goods['sid'] == $sid){
                    $goodsarr[]=$goods;
                }
            }
            //将数据拼装到一个数组中
            $cartarr[]=['sid'=>$sid,'sname' => $sname,'goods'=>$goodsarr];
            $goodsarr=null;
        }
        if(!empty($cartarr)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$cartarr]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>11,'ResultData'=>['Message'=>'购物车查询失败']]);
        }
    }

    /*
    *   购物车数量加减
    */
    public function cartnum(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $cart=new \App\Cart();
        //传过来的现在的数量
        $cart_data=[
            'goods_num'=>$param['goods_num'],
        ];
        //更新数据
        $result=$cart->cartupdate($param['cart_id'],$cart_data);
        if($result){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'商品数量加减成功']]);
        }else {
            return response()->json(['serverTime'=>time(),'ServerNo'=>11,'ResultData'=>['Message'=>'商品数量加减失败']]);
        }
    }

    /*
    *   对购物车物品做
    */
    public function cartdel(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $cart=new \App\Cart();
        //进行购物车删除
        $result=$cart->cartdel($param['cart_id']);
        //判断是否删除成功
        if($result){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'商品删除成功']]);
        }else {
            return response()->json(['serverTime'=>time(),'ServerNo'=>11,'ResultData'=>['Message'=>'商品删除失败']]);
        }
    }
}
