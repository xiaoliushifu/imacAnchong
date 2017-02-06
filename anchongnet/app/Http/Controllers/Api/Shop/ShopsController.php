<?php

namespace App\Http\Controllers\Api\Shop;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use Cache;

/*
*   该控制器包含了商铺模块的操作
*/
class ShopsController extends Controller
{
    //定义一些变量
    private $propel;

    /*
    *   商铺货品查看
    */
    public function goodsshow(Request $request)
    {
        try{
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
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该商铺修整中，请稍后查看']]);
        }
    }

    /*
    *   货品筛选分类显示
    */
    public function goodstype()
    {
        try{
            //判断缓存
            $result_cache=Cache::get('shops_goodstype_result');
            if($result_cache){
                //将缓存取出来赋值给变量
                $result=$result_cache;
            }else{
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
                //将查询结果加入缓存
                Cache::add('shops_goodstype_result', $result, 600);
            }
            if(!empty($result)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'该分类没有检索标签']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   商铺货品筛选
    */
    public function goodsfilter(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量(目前把分页取消了)
            $limit=10;
            //创建ORM模型
            $goods_specifications=new \App\Goods_specifications();
            if(empty($param['cat_id'])){
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>"无商品"]]);
            }elseif(!empty($param['cat_id'])){
                $sql="sid=".$param['sid']." and added = 1 and MATCH(cid) AGAINST('".bin2hex($param['cat_id'])."')";
            }
            //定义查询的字段
            $goods_specifications_data=['gid','goods_img','title','market_price','vip_price','sales','goods_num','goods_id'];
            //不分页查询
            $result=$goods_specifications->limitquer($goods_specifications_data,$sql);
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'商铺筛选暂不可用']]);
        }
    }

    /*
    *   商铺货品操作
    */
    public function goodsaction(Request $request)
    {
        try{
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
                $stock=new \App\Stock();
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
                            $stockresult=$stock->del($param['gid']);
                            if($stockresult){
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
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'商品删除失败']]);
                }
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该商品暂不可操作']]);
        }
    }

    /*
    *   该方法提供订单查看
    */
    public function shopsorder(Request $request)
    {
        try{
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
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'订单查询失败']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该商铺订单暂不可查看']]);
        }
    }

    /*
    *   该方法提供订单操作
    */
    public function shopsoperation(Request $request)
    {
        try{
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
                //如果是发货的话就推送信息
                if($param['action'] != 6){
                    $this->propleinfo($param['order_id'],$param['order_num']);
                }
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'操作成功']]);
            }else{
                //假如失败就回滚
                DB::rollback();
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'操作失败']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该订单暂不可操作']]);
        }
    }

    /*
    *   该方法商家地址添加
    */
    public function addressadd(Request $request)
    {
        try{
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
                $messages = $validator->errors();
                if ($messages->has('contact')) {
                    //如果验证失败,返回验证失败的信息
                    return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'联系人不能为空，且不能超过10个字符']]);
                }else if($messages->has('phone')){
                    return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'电话不能为空']]);
                }else if($messages->has('code')){
                    return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'邮政编码不能为空']]);
                }else if($messages->has('region')){
                    return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'所在地区不能为空']]);
                }
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
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   我的店铺
    */
    public function myshops(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
           $data=$request::all();
           $param=json_decode($data['param'],true);
           //结果数组
           $results=null;
           //创建订单的ORM模型
           $shop=new \App\Shop();
           $collection=new \App\Collection();
           //商铺内容
           $result=$shop->quer(['name','img','banner','introduction','freight','free_price','first','additional','customer','collect'],'sid ='.$param['sid'])->toArray();
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
       }catch (\Exception $e) {
           return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该商铺修整中，暂不可查看']]);
       }
    }


    /*
    *   我的店铺信息修改
    */
    public function shopsedit(Request $request)
    {
        try{
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
            if($param['free_price']){
                //修改多少需要运费
                $true=$shop->shopsupdate($param['sid'],['free_price'=>$param['free_price']]);
            }
            if($param['freight']){
                //修改运费价格
                $true=$shop->shopsupdate($param['sid'],['freight'=>$param['freight']]);
            }
            if($param['first']){
                //修改运费价格
                $true=$shop->shopsupdate($param['sid'],['first'=>$param['first']]);
            }
            if($param['additional']){
                //修改运费价格
                $true=$shop->shopsupdate($param['sid'],['additional'=>$param['additional']]);
            }
            if($param['customer']){
                //修改客服电话
                $true=$shop->shopsupdate($param['sid'],['customer'=>$param['customer']]);
            }
            if($true){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'修改成功']]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'修改失败']]);
            }
        }catch (\Exception $e) {
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
            if($param['free_price']){
                //修改多少需要运费
                $true=$shop->shopsupdate($param['sid'],['free_price'=>$param['free_price']]);
            }
            if($param['freight']){
                //修改运费价格
                $true=$shop->shopsupdate($param['sid'],['freight'=>$param['freight']]);
            }
            if($param['customer']){
                //修改客服电话
                $true=$shop->shopsupdate($param['sid'],['customer'=>$param['customer']]);
            }
            if($true){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'修改成功']]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>14,'ResultData'=>['Message'=>'修改失败']]);
            }
            // return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'暂不可修改商铺信息']]);
        }
    }

    /*
    *   店铺全部商品
    */
    public function shopsgoods(Request $request)
    {
        try{
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
                        $sql="sid = ".$param['sid']." and MATCH(cid) AGAINST('".bin2hex($param['cid'])."') and added = 1";
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
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>0,'list'=>[],'showprice'=>0]]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该商铺修整中，暂不可查看']]);
        }
    }


    /*
    *   店铺首页
    */
    public function shopsindex(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            $limit=20;
            //创建ORM模型
            $goods_type=new \App\Goods_type();
            //需要查的字段
            $goods_data=['gid','title','price','sname','pic','vip_price','goods_id'];
            //sql语句
            $sql='sid = '.$param['sid'].' and added = 1';
            $condition='sales';
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
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>0,'list'=>[],'showprice'=>0]]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该商铺修整中，暂不可查看']]);
        }
    }

    /*
    *   店铺新品
    */
    public function newgoods(Request $request)
    {
        try{
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
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>0,'list'=>[],'showprice'=>0]]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该商铺修整中，暂不可查看']]);
        }
    }

    /*
    *   店铺全部商品
    */
    public function logistcompany(Request $request)
    {
        try{
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
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该商铺修整中，暂不可查看']]);
        }
    }

    /*
    *    该方法提供了联系客服
    */
    public function Cservice(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            $phone=DB::table('anchong_users')->where('sid',$param['sid'])->pluck('phone');
            if($phone && $phone[0]){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['phone' => $phone[0]]]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData'=>['Message'=>'该商铺暂未设定客服']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该商铺暂未设定客服']]);
        }
    }

    /*
    *    该方法提供了订单的推送服务
    */
    private function propleinfo($order_id,$order_num)
    {
        //处理成功给用户和商户推送消息
        try{
            //创建ORM模型
            $order=new \App\Order();
            $users=new \App\Users();
            $this->propel=new \App\Http\Controllers\admin\Propel\PropelmesgController();
            //查出该用户的ID
            $users_id=$order->find($order_id)->users_id;
            //推送消息
            $this->propel->apppropel($users->find($users_id)->phone,'订单发货通知','您的订单'.$order_num.'已发货，请及保持手机畅通！');
            DB::table('anchong_feedback_reply')->insertGetId(
                [
                    'title' => '发货通知',
                    'content' => '您订单编号为'.$order_num.'的订单已发货，感谢您对安虫平台的支持！',
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
