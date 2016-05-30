<?php

namespace App\Http\Controllers\Api\Goods;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use Validator;
use DB;
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
                    $goods_specifications_data=[
                        "goods_name"=> $spec['goods_name'],
                        "market_price"=> $spec['market_price'],
                        "goods_price"=> $spec['goods_price'],
                        "vip_price"=> $spec['vip_price'],
                        "goods_num"=> $spec['goods_num'],
                        "sid" => $param['sid'],
                        'goods_id' => $goods_id,
                        'cat_id' => $param['cat_id'],
                        'pic' => $spec['pic'],
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
    }

    /*
    *   商品列表查看
    */
    public function goodslist(Request $request)
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
        //查询商品列表的信息
        $result=$goods_type->quer($goods_data,"MATCH(cid) AGAINST('".bin2hex($param['cid'])."') and added = 1",(($param['page']-1)*$limit),$limit);
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
            return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'商品信息获取失败，请刷新']]);
        }
    }

    /*
    *   商品筛选标签显示
    */
    public function goodstag(Request $request)
    {
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
    }

    /*
    *   商品筛选
    */
    public function goodssearch(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=20;
        //创建ORM模型
        $goods_type=new \App\Goods_type();
        //判断要查询的列表
        if(empty($param['tags']) && empty($param['search'])){
            return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>"无商品"]]);
        }elseif(!empty($param['tags']) && empty($param['search'])){
            //根据标签检索
<<<<<<< HEAD
<<<<<<< HEAD
            $sql="MATCH(cid) AGAINST('".bin2hex($param['cid'])."') and added = 1 and MATCH(tags) AGAINST('".bin2hex($param['tags'])."')";
        }elseif(empty($param['tags']) && !empty($param['search'])){
            //自定义检索
            $sql="MATCH(cid) AGAINST('".bin2hex($param['cid'])."') and added = 1 and MATCH(keyword) AGAINST('".bin2hex($param['search'])."')";
        }elseif(!empty($param['tags']) && !empty($param['search'])){
            $sql="MATCH(cid) AGAINST('".bin2hex($param['cid'])."') and added = 1 and MATCH(tags) AGAINST('".bin2hex($param['tags'])."') and MATCH(keyword) AGAINST('".bin2hex($param['search'])."')";
=======
            $sql="cid =".$param['cid']." and MATCH(tags) AGAINST('".bin2hex($param['tags'])."')";
=======
            $sql="MATCH(cid) AGAINST('".bin2hex($param['cid'])."') and added = 1 and MATCH(tags) AGAINST('".bin2hex($param['tags'])."')";
>>>>>>> origin/renqingbin
        }elseif(empty($param['tags']) && !empty($param['search'])){
            //自定义检索
            $sql="MATCH(cid) AGAINST('".bin2hex($param['cid'])."') and added = 1 and MATCH(keyword) AGAINST('".bin2hex($param['search'])."')";
        }elseif(!empty($param['tags']) && !empty($param['search'])){
<<<<<<< HEAD
            $sql="cid =".$param['cid']." and MATCH(tags) AGAINST('".bin2hex($param['tags'])."') and MATCH(keyword) AGAINST('".bin2hex($param['search'])."')";
>>>>>>> renqingbin
=======
            $sql="MATCH(cid) AGAINST('".bin2hex($param['cid'])."') and added = 1 and MATCH(tags) AGAINST('".bin2hex($param['tags'])."') and MATCH(keyword) AGAINST('".bin2hex($param['search'])."')";
>>>>>>> origin/renqingbin
        }
        //要查询的字段
        $goods_data=['gid','title','price','sname','pic','vip_price','goods_id'];
        $result=$goods_type->quer($goods_data,$sql,(($param['page']-1)*$limit),$limit);
        $results=$result['list']->toArray();
        //判断是否需要查询会员价
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
        }else{
            //如果结果为空则返回0
            $showprice=0;
        }
        //将用户权限传过去
        $result['showprice']=$showprice;
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
    }

    /*
    *   商品详细信息
    */
    public function goodsinfo(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $goods_specifications=new \App\Goods_specifications();
        $goods=new \App\Goods();
        $goods_thumb=new \App\Goods_thumb();
        //需要查的字段
        $goods_data=['goods_id','market_price','vip_price','goods_name','sid'];
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
<<<<<<< HEAD
<<<<<<< HEAD
            $collresult=$collection->quer('users_id='.$data['guid'].' and coll_id ='.$param['gid'].' and coll_type = 1');
            //进行数据拼接
            $result['goodspic']=$picarr;
            $result['detailpic']=$goodsresult[0]['images'];
            $result['parameterpic']="http://admin.anchong.net/getparam?gid=".$param['goods_id'];
            $result['datapic']="http://admin.anchong.net/getpackage?gid=".$param['goods_id'];
=======
            $collresult=$collection->quer('users_id='.$data['guid'].' and coll_id ='.$param['gid']);
            //进行数据拼接
            $result['goodspic']=$picarr;
            $result['detailpic']=$detailpic;
            $result['parameterpic']=$parameterpic;
            $result['datapic']=$datapic;
>>>>>>> renqingbin
=======
            $collresult=$collection->quer('users_id='.$data['guid'].' and coll_id ='.$param['gid'].' and coll_type = 1');
            //进行数据拼接
            $result['goodspic']=$picarr;
            $result['detailpic']=$goodsresult[0]['images'];
            $result['parameterpic']="http://admin.anchong.net/getparam?gid=".$param['goods_id'];
            $result['datapic']="http://admin.anchong.net/getpackage?gid=".$param['goods_id'];
>>>>>>> origin/renqingbin
            $result['collection']=$collresult;
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'商品信息获取失败，请刷新']]);
        }
    }

    /*
    *   相关商品信息
    */
    public function correlation(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=24;
        //创建ORM模型
        $goods_type=new \App\Goods_type();
        //查询货品关键字
        $goodskeyword=$goods_type->searchquer('keyword','gid ='.$param['gid'])->toArray();
        //判断货品是否有关键字
        if(empty($goodskeyword['0']['keyword'])){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>[]]);
        }else{
            //将关键字拆分
            $keyarr=explode(' ',$goodskeyword['0']['keyword']);
            //定义查询内容
            $goods_data=['gid','title','price','pic','goods_id'];
            $result=$goods_type->condquer($goods_data,"MATCH(keyword) AGAINST('".$keyarr[0]."') and added =1",(($param['page']-1)*$limit),$limit,'sales','DESC');
            if(!empty($result['list']->toArray())){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
            }else{
                $result=$goods_type->condquer($goods_data,"added =1",(($param['page']-1)*$limit),$limit,'sales','DESC');
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);
            }
        }
    }

    /*
    *   配套商品信息
    */
    public function supporting(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $goodssupporting=new \App\GoodSupporting();
        $goods_data=['gid','title','price','img','goods_id'];
        $result=$goodssupporting->quer($goods_data,'assoc_gid = '.$param['goods_id'])->toArray();
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result]);


    }

    /*
    *   商品规格信息
    */
    public function goodsformat(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $Goods_attribute=new \App\Goods_attribute();
        $results=$Goods_attribute->quer(['name','value'],'goods_id ='.$param['goods_id'])->toArray();
        //定义一个商品属性的空数组
        $goodsvalue=null;
        foreach ($results as $attribute) {
            $type_arr=explode(' ',$attribute['value']);
            $goodsvalue[]=['name'=>$attribute['name'],'value'=>$type_arr];
        }
        if(!empty($goodsvalue)){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$goodsvalue]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'规格信息获取失败，请刷新']]);
        }
    }

    /*
    *   货品的信息
    */
    public function goodsshow(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //创建ORM模型
        $goods=new \App\Goods();
        //查询商品名称
        $title=$goods->quer('title','goods_id ='.$param['goods_id'])->toArray();
        $goods_specifications=new \App\Goods_specifications();
        //定义查询的字段
        $goods_specifications_data=['gid','goods_img','goods_name','market_price','vip_price'];
        //查询数据
        $results=$goods_specifications->quer($goods_specifications_data,'goods_id = '.$param['goods_id'])->toArray();
        //对查出来的数据进行遍历
        foreach ($results as $value) {
            //将与发过来的规格相同的货品信息发送到客户端
            // if(trim($value['goods_name']) == trim($param['value'])){
            if(strstr($value['goods_name'],trim($param['value']))){
                $value['title']=$title[0]['title'].' '.$value['goods_name'];
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$value]);
            }
        }
        return response()->json(['serverTime'=>time(),'ServerNo'=>10,'ResultData'=>['Message'=>'该商品已售罄']]);
    }
}
