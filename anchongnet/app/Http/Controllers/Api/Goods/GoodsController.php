<?php

namespace App\Http\Controllers\Api\Goods;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use Validator;
use DB;
use Cache;
use Illuminate\Support\Collection;

/*
*   该控制器包含了商品模块的操作
*/
class GoodsController extends Controller
{
    /*
    *   商品发布
    */
    public function goodsrelease(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //验证用户传过来的数据是否合法
            $validator = Validator::make($param,
                [
                    'sid' => 'required',
                    'title' => 'required|max:66',
                    'sname' => 'required',
                    'desc' => 'required',
                    'cat_id' => 'required',
                    'spec' => 'array',
                ]
            );
            if ($validator->fails())
            {
                return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'请填写完整的商品内容！']]);
            }else{
                $goods_data=[
                    'title' => $param['title'],
                    'desc' =>$param['desc']
                ];

                //开启事务处理
                DB::beginTransaction();
                $goods=new \App\Goods();
                //插入商品表数据
                $goods_id=$goods->add($goods_data);
                //假如插入成功
                if(!empty($goods_id)){
                    foreach ($param['spec'] as $spec) {
                        //图片替换处理
                        $urls = str_replace('.oss-','.img-',$spec);
                        $goods_specifications_data=[
                            "goods_name" => $spec['goods_name'],
                            "market_price" => $spec['market_price'],
                            "goods_price" => $spec['goods_price'],
                            "vip_price" => $spec['vip_price'],
                            "goods_num" => $spec['goods_num'],
                            "sid" => $param['sid'],
                            'goods_id' => $goods_id,
                            'cat_id' => $param['cat_id'],
                            'pic' => $urls,
                            'parameter' => $spec['parameter'],
                            'data' => $spec['data'],
                            'goods_img' => $spec['img'][0],
                        ];
                        //创建货品表的ORM模型
                        $goods_specifications=new \App\Goods_specifications();
                        //对货品表进行数据的插入
                        $goods_specifications_id=$goods_specifications->add($goods_specifications_data);
                        //判断插入的货品ID是否为空
                        if(!empty($goods_specifications_id)){
                            $goods_type_data=[
                                'gid' => $goods_specifications_id,
                                'title' => $param['titless'].' '.$spec['goods_name'],
                                'price' => $spec['market_price'],
                                'sname' => $param['sname'],
                                'vip_price'=>$spec['vip_price'],
                                'cid' => $param['cat_id'],
                                'created_at' => date('Y-m-d H:i:s',$data['time']),
                                'pic' => $spec['img'][0],
                            ];
                            //创建商品分类表
                            $goods_type=new \App\Goods_type();
                            $goods_type_result=$goods_type->add($goods_type_data);
                            if($goods_type_result){
                                foreach ($spec['img'] as $pic) {
                                    $pic_data=[
                                        'gid'=> $goods_specifications_id,
                                        'img_url'=> $pic,
                                    ];
                                    $goods_thumb=new \App\Goods_thumb();
                                    $result=$goods_thumb->add($pic_data);
                                }
                            }else{
                                //加入失败就回滚
                                DB::rollback();
                                return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'添加商品失败，请重新添加']]);
                            }
                        }else{
                            //加入失败就回滚
                            DB::rollback();
                            return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'添加商品失败，请重新添加']]);
                        }
                    }
                    if($result){
                        //假如成功就提交
                        DB::commit();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'添加商品成功']]);
                    }else{
                        //加入失败就回滚
                        DB::rollback();
                        return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'添加商品失败，请重新添加']]);
                    }
                }else{
                    //加入失败就回滚
                    DB::rollback();
                    return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'添加商品失败，请重新添加']]);
                }
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   商品列表查看
    */
    public function goodslist(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量
            $limit=20;
            //只为第一页添加缓存
            if($param['page'] == 1){
                //定义所有货品的关联缓存
                $cachename='goods_goodslist_results'.$param['cid'];
                //判断缓存
                $results_cache=Cache::get($cachename);
            }else{
                $results_cache=null;
            }
            if($results_cache){
                //将缓存取出来赋值给变量
                $result=$results_cache;
            }else{
                //创建ORM模型
                $goods_type=new \App\Goods_type();
                //需要查的字段
                $goods_data=['gid','title','price','sname','pic','vip_price','goods_id'];
                //查询商品列表的信息
                $result=$goods_type->quer($goods_data,"MATCH(cid) AGAINST('".bin2hex($param['cid'])."') and added = 1",(($param['page']-1)*$limit),$limit);
                //只为第一页添加缓存
                if($param['page'] == 1){
                    //将查询结果加入缓存
                    Cache::add($cachename, $result, 5);
                }
            }
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
                return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'暂无商品，敬请期待']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   商品列表该分类下所有商品查看
    */
    public function goodsall(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量
            $limit=20;
            //只为第一页添加缓存
            if($param['page'] == 1){
                //定义所有货品的关联缓存
                $cachename='goods_goodsall_results'.$param['other_id'];
                //判断缓存
                $results_cache=Cache::get($cachename);
            }else{
                $results_cache=null;
            }
            if($results_cache){
                //将缓存取出来赋值给变量
                $result=$results_cache;
            }else{
                //创建ORM模型
                $goods_type=new \App\Goods_type();
                //需要查的字段
                $goods_data=['gid','title','price','sname','pic','vip_price','goods_id'];
                //查询商品列表的信息
                $result=$goods_type->quer($goods_data,"other_id =".$param['other_id']." and added = 1",(($param['page']-1)*$limit),$limit);
                //只为第一页添加缓存
                if($param['page'] == 1){
                    //将查询结果加入缓存
                    Cache::add($cachename, $result, 10);
                }
            }
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
                return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'请求失败，请刷新']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   商品筛选标签显示
    */
    public function goodstag(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $goods_tag=new \App\Goods_tag();
            $result=$goods_tag->quer('tag','cat_id='.$param['cat_id'])->toArray();
            if(!empty($result)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'该分类没有检索标签']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   根据商品关键字，进行搜索
    */
    public function goodssearch(Request $request)
    {
        try{
                $data=$request::all();
                $param=json_decode($data['param'],true);
                //分析三个搜索参数
                /*查询字符串是空格分开的字符串时，目前的处理，拆分留一个*/
                $param['search'] = preg_split('#\s#',$param['search'],-1,PREG_SPLIT_NO_EMPTY)[0];
                
                $kl = mb_strlen($param['search'],'utf-8');
                //需要在录入商品中，添加关键字的时候，注意，空格分开的每个独立的关键字不能超过14个utf-8汉字。
                if ($kl<1 || $kl>14) {
                    return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>"没有找到相关的商品"]]);
                }
                $where=array();
                //封装where
                foreach ($param as $key=>$val) {
                    if (!$val) {
                        continue;
                    }
                    if (in_array($key,['tags','search'])) {
                        //字母字符转大写,使得有关英文字符的搜索不区分大小写
                        $where[]="match(`$key`) against('".bin2hex(strtoupper($val))."')";
                    }
                    if ($key=='cid') {
                        $where[]="$key='$val'";
                    }
                }
                $where=implode(' and ',$where);
                $where = str_replace('`search`', '`keyword`',$where);
                //缓存判定
                if (!$result = Cache::get($where)) {
                    //索引表查询
                    $tmp=DB::select("select `cat_id` from `anchong_goods_keyword` where ".$where);
                    if (!$tmp) {
                        return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>"没有找到相关商品"]]);
                    }
                    $tmparr=array();
                    foreach($tmp as $o) {
                        $tmparr[]= $o->cat_id;
                    }
                    //要查询的字段
                    $goods_data=['gid','title','price','sname','pic','vip_price','goods_id'];
                    $res = DB::table('anchong_goods_type')->whereIn('cat_id',$tmparr)->get($goods_data);
    
                    foreach($res as $val)
                    {
                        $result['list'][]=$val;
                    }
                    $result['total']=count($res);
                    //统计一次该关键字的查询次数
                    DB::table('anchong_goods_suggestion')->where('str',$param['search'])->increment('qnums');
                    Cache::add($where,$result,'60');
                }
                $showprice=0;
//                 if ($data['guid'] != 0) {
//                     $tmp = DB::table('anchong_users')->where('users_id',$data['guid'])->get(array('certification'));
//                     if ($tmp[0]->certification == 3) {
//                         $showprice=1;
//                     }
//                 }
                //将用户权限传过去
                $result['showprice']=$showprice;
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
            } catch (\Exception $e) {
                return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
            }
    }

    /*
    *   商品详细信息
    */
    public function goodsinfo(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $goods_specifications=new \App\Goods_specifications();
            $goods=new \App\Goods();
            $goods_thumb=new \App\Goods_thumb();
            //需要查的字段
            $goods_data=['goods_id','market_price','vip_price','goods_name','sid','title'];
            //查询商品列表的信息
            $goodsresult=$goods->quer('images','goods_id ='.$param['goods_id'])->toArray();
            $picresult=$goods_thumb->quer('img_url','gid = '.$param['gid'])->toArray();
            $results=$goods_specifications->quer($goods_data,'gid = '.$param['gid'])->toArray();
            //轮播图数组
            $picarr=null;
            //遍历轮播图
            foreach ($picresult as $pic) {
                $picarr[]= $pic['img_url'];
            }
            $result=null;
            if(!empty($results) && !empty($picresult)){
                //提取商铺ID
                $shopid=$results[0]['sid'];
                $shop=new \App\Shop();
                //查询商铺图片和名字
                $shopresult=$shop->quer(['name','img','customer'],'sid = '.$shopid)->toArray();
                foreach ($results as $goods1) {
                    foreach ($goods1 as $key=>$goods2) {
                        $result[$key]=$goods2;
                    }
                }
                foreach ($shopresult as $shop1) {
                    foreach ($shop1 as $key=>$shop2) {
                        $result[$key]=$shop2;
                    }
                }
                //创建收藏ORM模型
                $collection=new \App\Collection();
                $collresult=$collection->quer('users_id='.$data['guid'].' and coll_id ='.$param['gid'].' and coll_type = 1');
                //进行数据拼接
                $result['goodspic']=$picarr;
                $result['detailpic']=$goodsresult[0]['images'];
                $result['parameterpic']="http://www.anchong.net/getparam?gid=".$param['goods_id'];
                $result['datapic']="http://www.anchong.net/getpackage?gid=".$param['goods_id'];
                $result['collection']=$collresult;
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'该商品暂不出售']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   相关商品信息
    */
    public function correlation(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量
            $limit=24;
            //创建ORM模型
            $goods_type=new \App\Goods_type();
            //查询货品关键字
            $goodskeyword=$goods_type->searchquer('cid','gid ='.$param['gid'])->toArray();
            //判断货品是否有关键字
            if(empty($goodskeyword['0']['cid'])){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>[]]);
            }else{
                //将关键字拆分
                $keyarr=explode(' ',$goodskeyword['0']['cid']);
                //定义查询内容
                $goods_data=['gid','title','price','pic','goods_id'];
                //设置随机偏移量
                $num=rand(0,15);
                $result=$goods_type->corrquer($goods_data,"MATCH(cid) AGAINST('".$keyarr[0]."') and added =1",$num,$limit,'goods_id');
                if(!empty($result['list']->toArray())){
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
                }else{
                    $result=$goods_type->corrquer($goods_data,"added =1",(($param['page']-1)*$limit),$limit,'sales','DESC');
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
                }
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   配套商品信息
    */
    public function supporting(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $goodssupporting=new \App\GoodSupporting();
            $goods_data=['gid','title','price','img','goods_id'];
            $result=$goodssupporting->quer($goods_data,'assoc_gid = '.$param['goods_id'])->toArray();
            if($result){
    			return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
    		}else{
    			return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>0,'list'=>[]]]);
    		}
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   商品规格信息
    */
    public function goodsformat(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $Goods_attribute=new \App\Goods_attribute();
            $oem_result=DB::table('anchong_goods_oem')->select('value')->where('goods_id','=',$param['goods_id'])->get();
            $results=$Goods_attribute->quer(['name','value'],'goods_id ='.$param['goods_id'])->toArray();
            //定义一个商品属性的空数组
            $goodsvalue=null;
            $typearr=null;
            $goods_list=null;
            foreach ($results as $attribute) {
                $type_arr=explode(' ',trim($attribute['value']));
                foreach($type_arr as $type_arrs){
                    if($type_arrs){
                        $typearr[]=$type_arrs;
                    }
                }
                $goodsvalue[]=['name'=>$attribute['name'],'value'=>$typearr];
                $typearr=null;
            }
            if($oem_result){
                //组合oem
                $oem_arr=explode(' ',trim($oem_result[0]->value));
                foreach($oem_arr as $oem_arrs){
                    if($oem_arrs){
                        $oemarr[]=$oem_arrs;
                    }
                }
                $goods_list['list']=$goodsvalue;
                $goods_list['oem']=$oemarr;
            }

            if(!empty($goodsvalue)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$goodsvalue]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'规格信息获取失败，请刷新']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   货品的信息
    */
    public function goodsshow(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $goods_specifications=new \App\Goods_specifications();
            //定义查询的字段
            $goods_specifications_data=['gid','goods_img','goods_name','market_price','vip_price','title'];
            //查询数据
            $results=$goods_specifications->quer($goods_specifications_data,'goods_id = '.$param['goods_id'])->toArray();
            //对查出来的数据进行遍历
            foreach ($results as $value) {
                //将与发过来的规格相同的货品信息发送到客户端
                if(strstr($value['goods_name'],trim($param['value']))){
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$value]);
                }
            }
            return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'商品无库存，联系客服']]);
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }
}
