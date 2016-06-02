<?php

namespace App\Http\Controllers\Api\Shop;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;

/*
*   该控制器包含了商铺模块的操作
*/
class ShopsController extends Controller
{
    /*
    *   商铺货品查看
    */
    public function goodsshow(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //默认每页数量(目前把分页取消了)
        $limit=10;
        //创建ORM模型
        $goods_specifications=new \App\Goods_specifications();
        //定义查询的字段
        $goods_specifications_data=['gid','goods_img','title','market_price','vip_price','sales','goods_num','goods_id'];
        $result=$goods_specifications->limitquer($goods_specifications_data,'sid ='.$param['sid'].' and added ='.$param['added']);
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
    }

    /*
    *   货品筛选分类显示
    */
    public function goodstype()
    {
        //创建ORM模型
        $category=new \App\Category();
        //将一级分类信息查询出来
        $resultone=$category->quer(['cat_id','cat_name','parent_id'],'is_show = 1')->toArray();
        //定义装结果的数组
        $result=null;
        $catone=null;
        $cattwo=null;
        $catthree=null;
        $catfour=null;
        $catfive=null;
        $catsix=null;
        $catseven=null;
        $cateight=null;
        foreach ($resultone as $onearr) {
            //判断用户行为
            switch ($onearr['parent_id']) {
                //0为全部订单
                case 1:
                    $catone[]=$onearr;
                    break;
                case 2:
                    $cattwo[]=$onearr;
                    break;
                case 3:
                    $catthree[]=$onearr;
                    break;
                case 4:
                    $catfour[]=$onearr;
                    break;
                case 5:
                    $catfive[]=$onearr;
                    break;
                case 6:
                    $catsix[]=$onearr;
                    break;
                case 7:
                    $catseven[]=$onearr;
                    break;
                case 8:
                    $cateight[]=$onearr;
                    break;

            }
        }
        $result[]=['parent_name'=>'智能门禁','list'=>$catone];
        $result[]=['parent_name'=>'视频监控','list'=>$cattwo];
        $result[]=['parent_name'=>'探测报警','list'=>$catthree];
        $result[]=['parent_name'=>'巡更巡检','list'=>$catfour];
        $result[]=['parent_name'=>'停车管理','list'=>$catfive];
        $result[]=['parent_name'=>'楼宇对讲','list'=>$catsix];
        $result[]=['parent_name'=>'智能消费','list'=>$catseven];
        $result[]=['parent_name'=>'安防配套','list'=>$cateight];
        if(!empty($result)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'该分类没有检索标签']]);
        }
    }

    /*
    *   商铺货品筛选
    */
    public function goodsfilter(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //默认每页数量(目前把分页取消了)
        $limit=10;
        //创建ORM模型
        $goods_specifications=new \App\Goods_specifications();
        if(empty($param['cat_id']) && empty($param['search'])){
            return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>"无商品"]]);
        }elseif(!empty($param['cat_id']) && empty($param['search'])){
            $sql="sid=".$param['sid']." and added = 1 and MATCH(cid) AGAINST('".bin2hex($param['cat_id'])."')";
        }elseif(empty($param['tags']) && !empty($param['search'])) {
            $sql="sid=".$param['sid']." and added = 1 and MATCH(keyword) AGAINST('".bin2hex($param['search'])."')";
        }elseif(!empty($param['tags']) && !empty($param['search'])) {
            $sql="sid=".$param['sid']." and added = 1 and MATCH(keyword) AGAINST('".bin2hex($param['search'])."') and MATCH(cid) AGAINST('".bin2hex($param['cat_id'])."')";
        }
        //定义查询的字段
        $goods_specifications_data=['gid','goods_img','title','market_price','vip_price','sales','goods_num','goods_id'];
        //不分页查询
        $result=$goods_specifications->limitquer($goods_specifications_data,$sql);
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
    }

    /*
    *   商铺货品操作
    */
    public function goodsaction(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //判断用户操作
        if($param['action'] == 1){
            //创建ORM模型
            $goods_specifications=new \App\Goods_specifications();
            $result=$goods_specifications->specupdate($param['gid'],['added' => $param['added']]);
            if($result){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'商品操作成功']]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'商品操作失败']]);
            }
        }elseif($param['action'] == 2){
            //创建ORM模型
            $goods_specifications=new \App\Goods_specifications();
            $goods_type=new \App\Goods_type();
            $goods_thumb=new \App\Goods_thumb();
            //开启事务处理
            DB::beginTransaction();
            //删除货品表的数据
            $specresult=$goods_specifications->del($param['gid']);
            if($specresult){
                //删除goods_type表的数据
                $typeresult=$goods_type->del($param['gid']);
                if($typeresult){
                    //删除该货品的主图
                    $thumbresult=$goods_thumb->del($param['gid']);
                    if($thumbresult){
                        //假如成功就提交
                        DB::commit();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'删除成功']]);
                    }else{
                        //假如失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'商品删除失败']]);
                    }
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'商品删除失败']]);
                }
            }else{
                //假如失败就回滚
                DB::rollback();
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'商品删除失败']]);
            }
        }
    }

    /*
    *   该方法提供订单查看
    */
    public function shopsorder(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=10;
        //创建ORM模型
        $order=new \App\Order();
        $orderinfo=new \App\Orderinfo();
        //判断用户行为
        switch ($param['state']) {
            //0为全部订单
            case 0:
                $sql='sid ='.$param['sid'];
                break;
            //1为待付款
            case 1:
                $sql='sid ='.$param['sid'].' and state ='.$param['state'];
                break;
            //2为待发货
            case 2:
                $sql='sid ='.$param['sid'].' and state ='.$param['state'];
                break;
            //3为退款
            case 3:
                $sql='sid ='.$param['sid'].' and state in(4,5)';
                break;
            default:
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'用户行为异常']]);;
                break;
        }
        //定于查询数据
        $order_data=['order_id','order_num','state','created_at','total_price','name','phone','address','invoice','customer','tname'];
        $orderinfo_data=['goods_name','goods_num','goods_price','goods_type','img'];
        //查询该用户的订单数据
        $order_result=$order->quernopage($order_data,$sql);
        if($order_result['total'] == 0){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$order_result]);
        }
        //最终结果
        $result=null;
        //查看该用户订单的详细数据精确到商品
        foreach ($order_result['list'] as $order_results) {
            //根据订单号查到该订单的详细数据
            $orderinfo_result=$orderinfo->quer($orderinfo_data,'order_num ='.$order_results['order_num'])->toArray();
            //将查询结果组成数组
            $order_results['goods']=$orderinfo_result;
            $result[]=$order_results;
            $order_results=null;
        }
        if(!empty($result)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$order_result['total'],'list'=>$result]]);
        }else{
            response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'订单查询失败']]);
        }
    }

    /*
    *   该方法提供订单操作
    */
    public function shopsoperation(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $order=new \App\Order();
        //开启事务处理
        DB::beginTransaction();
        if($param['action'] == 2){
            //创建ORM模型
            $goods_logistics=new \App\Goods_logistics();
            $goods_logistics_data=[
                'order_id' => $param['order_id'],
                'logisticsnum' => $param['logistcsnum'],
                'company' => $param['company'],
            ];
            $logisrestult=$goods_logistics->add($goods_logistics_data);
            //假如物流添加成功
            if($logisrestult){
                //进行订单操作
                $result=$order->orderupdate($param['order_id'],['state' => 3]);
            }else{
                //假如失败就回滚
                DB::rollback();
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'发货失败']]);
            }
        }elseif($param['action'] == 3){
            //进行订单操作
            $result=$order->orderupdate($param['order_id'],['state' => $param['action']]);
        }elseif($param['action'] == 6){
            //进行订单操作
            $result=$order->orderupdate($param['order_id'],['state' => $param['action']]);
        }
        if($result){
            //假如成功就提交
            DB::commit();
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'操作成功']]);
        }else{
            //假如失败就回滚
            DB::rollback();
            return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'操作失败']]);
        }
    }

    /*
    *   该方法商家地址添加
    */
    public function addressadd(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //验证用户传过来的数据是否合法
        $validator = Validator::make($param,
            [
                'sid' => 'required',
                'contact' => 'required|max:10',
                'phone' => 'required',
                'code' => 'required',
                'region' => 'required',
            ]
        );
        if ($validator->fails())
        {
            return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'请填写完整的地址，并且名字不能超过10个字符！']]);
        }else{
            //创建订单的ORM模型
            $shops_address=new \App\Shops_address();
            //要插入的数据
            $shops_address_data=[
                'sid' => $param['sid'],
                'contact' => $param['contact'],
                'phone' => $param['phone'],
                'code' => $param['code'],
                'region' => $param['region'],
                'street' => $param['street'],
                'detail' => $param['detail'],
            ];
            //插入数据
            $result=$shops_address->add($shops_address_data);
            if($result){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'添加地址成功']]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'添加地址失败']]);
            }
        }
    }


    /*
    *   我的店铺
    */
    public function myshops(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
       $data=$request::all();
       $param=json_decode($data['param'],true);
       //结果数组
       $results=null;
       //创建订单的ORM模型
       $shop=new \App\Shop();
       $collection=new \App\Collection();
       //商铺内容
       $result=$shop->quer(['name','img','banner','introduction','customer','collect'],'sid ='.$param['sid'])->toArray();
       foreach ($result as $value) {
           $results['shops']=$value;
       }
       //是否关注
       $collresult=$collection->quer('users_id='.$data['guid'].' and coll_id ='.$param['sid'].' and coll_type = 2');
       $results['collect']=$results['shops']['collect'];
       $results['collresult']=$collresult;
       //判断是否为空
       if(!empty($result)){
           return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$results]);
       }else{
           return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'获取商铺信息失败，请检查网络并刷新']]);
       }
   }


        /*
        *   我的店铺信息修改
        */
        public function shopsedit(Request $request)
        {
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            $validator = Validator::make($param,
                [
                    'name' => 'max:126',
                ]
            );
            //如果出错返回出错信息，如果正确执行下面的操作
            if ($validator->fails())
            {
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'商铺名字过长']]);
            }
            //创建订单的ORM模型
            $shop=new \App\Shop();
            $true=false;
            //判断用户要修改的内容
            if($param['name']){
                //修改商铺名称
                $true=$shop->shopsupdate($param['sid'],['name'=>$param['name']]);
            }
            if($param['img']){
                //修改商铺图片
                $true=$shop->shopsupdate($param['sid'],['img'=>$param['img']]);
            }
            if($param['introduction']){
                //修改商铺描述
                $true=$shop->shopsupdate($param['sid'],['introduction'=>$param['introduction']]);
            }
            if($param['banner']){
                //修改商铺背景图片
                $true=$shop->shopsupdate($param['sid'],['banner'=>$param['banner']]);
            }
            if($true){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'修改成功']]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'修改失败']]);
            }
        }

        /*
        *   店铺全部商品
        */
        public function shopsgoods(Request $request)
        {
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量
            $limit=20;
            //创建ORM模型
            $goods_type=new \App\Goods_type();
            //需要查的字段
            $goods_data=['gid','title','price','sname','pic','vip_price','goods_id'];
            if(empty($param['cid'])){
                switch ($param['action']) {
                    //全部
                    case 0:
                        $sql='sid = '.$param['sid'].' and added = 1';
                        $condition='created_at';
                        $sort='DESC';
                        break;
                    //销量排序
                    case 1:
                        $sql='sid = '.$param['sid'].' and added = 1';
                        $condition='sales';
                        $sort='DESC';
                        break;
                    //新品排序
                    case 2:
                        $sql='sid = '.$param['sid'].' and added = 1';
                        $condition='created_at';
                        $sort='DESC';
                        break;
                    //价格排序升序
                    case 3:
                        $sql='sid = '.$param['sid'].' and added = 1';
                        $condition='price';
                        $sort='DESC';
                        break;
                    //价格排序降序
                    case 4:
                        $sql='sid = '.$param['sid'].' and added = 1';
                        $condition='price';
                        $sort='ASC';
                            break;
                    default:
                        break;
                }
            }else{
                switch ($param['action']) {
                    //全部
                    case 0:
                        $sql='sid = '.$param['sid'].' and added = 1';
                        $condition='created_at';
                        $sort='DESC';
                        break;
                    //销量排序
                    case 1:
                        $sql="sid = ".$param['sid']." and MATCH(cid) AGAINST('".bin2hex($param['cid'])."') and added = 1";
                        $condition='sales';
                        $sort='DESC';
                        break;
                    //新品排序
                    case 2:
                        $sql="sid = ".$param['sid']." and MATCH(cid) AGAINST('".bin2hex($param['cid'])."') and added = 1";
                        $condition='created_at';
                        $sort='DESC';
                        break;
                    //价格排序升序
                    case 3:
                        $sql="sid = ".$param['sid']." and MATCH(cid) AGAINST('".bin2hex($param['cid'])."') and added = 1";
                        $condition='price';
                        $sort='DESC';
                        break;
                    //价格排序降序
                    case 4:
                        $sql="sid = ".$param['sid']." and MATCH(cid) AGAINST('".bin2hex($param['cid'])."') and added = 1";
                        $condition='price';
                        $sort='ASC';
                            break;
                    default:
                        break;
                }
            }
            //查询商品列表的信息
            $result=$goods_type->condquer($goods_data,$sql,(($param['page']-1)*$limit),$limit,$condition,$sort);
            //将结果转成数组
            $results=$result['list']->toArray();
            //判断是否取出结果
            if(!empty($results)){
                //判断是否有权限查看会员价，也就是判断是否审核通过
                $showprice=0;
                if($data['guid'] == 0){
                    $showprice=0;
                }else{
                    $users=new \App\Users();
                    //查询用户是否认证
                    $users_auth=$users->quer('certification',['users_id'=>$data['guid']])->toArray();
                    if($users_auth[0]['certification'] == 3){
                        $showprice=1;
                    }
                }
                $result['showprice']=$showprice;
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>[]]);
            }
        }

        /*
        *   店铺新品
        */
        public function newgoods(Request $request)
        {
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量
            $limit=20;
            //创建ORM模型
            $goods_type=new \App\Goods_type();
            //需要查的字段
            $goods_data=['gid','title','price','sname','pic','vip_price','goods_id'];
            //查询条件
            $sql='sid = '.$param['sid'].' and added = 1';
            $condition='created_at';
            $sort='DESC';
            //查询商品列表的信息
            $result=$goods_type->condquer($goods_data,$sql,(($param['page']-1)*$limit),$limit,$condition,$sort);
            //将结果转成数组
            $results=$result['list']->toArray();
            //判断是否取出结果
            if(!empty($results)){
                //判断是否有权限查看会员价，也就是判断是否审核通过
                $showprice=0;
                if($data['guid'] == 0){
                    $showprice=0;
                }else{
                    $users=new \App\Users();
                    //查询用户是否认证
                    $users_auth=$users->quer('certification',['users_id'=>$data['guid']])->toArray();
                    if($users_auth[0]['certification'] == 3){
                        $showprice=1;
                    }
                }
                $result['showprice']=$showprice;
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>[]]);
            }

        }

        /*
        *   店铺全部商品
        */
        public function logistcompany(Request $request)
        {
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $shops_logistics=new \App\Shops_logistics();
            $result=$shops_logistics->quer('name')->toArray();
            //定义结果数组为空
            $results=null;
            foreach ($result as $resultarr) {
                $results[]=$resultarr['name'];
            }
            if(!empty($result)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$results]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'获取快递公司数据失败']]);
            }
        }
}
