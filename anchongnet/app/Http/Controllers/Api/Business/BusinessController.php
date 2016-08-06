<?php

namespace App\Http\Controllers\Api\Business;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use Validator;
use DB;
use Cache;

/*
*   该控制器包含了商机模块的操作
*/
class BusinessController extends Controller
{
    /*
    *   该方法提供了商机发布的功能
    */
    public function release(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //验证用户传过来的数据是否合法
            $validator = Validator::make($param,
                [
                    'type' => 'required',
                    'title' => 'required|max:255',
                    'content' => 'required|min:4',
                    'tag' => 'required',
                    'pic' => 'array',
                ]
            );
            //如果出错返回出错信息，如果正确执行下面的操作
            if ($validator->fails()){
                $messages = $validator->errors();
                if ($messages->has('title')) {
    				//如果验证失败,返回验证失败的信息
    			    return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'标题长度不能超过126个字']]);
    			}else if($messages->has('content')){
    				return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'工程简介不能低于4个字']]);
    			}
            }else{
                //创建用户表通过电话查询出用户电话
                $users=new \App\Users();
                $users_phone=$users->quer('phone',['users_id'=>$data['guid']])->toArray();
                //判断用户数据表中是否有电话联系方式
                if($users_phone[0]['phone']){
                    $users_message=new \App\Usermessages();
                    $users_contact=$users_message->quer('contact',['users_id'=>$data['guid']])->toArray();
                    //判断用户信息表中是否有联系人姓名
                    if($users_contact){
                        $tags_arr=explode(' ',$param['tags']);
                        $tags="";
                        if(!empty($tags_arr)){
                            foreach ($tags_arr as $tag_arr) {
                                $tags.=bin2hex($tag_arr)." ";
                            }
                        }
                        //定义图片变量
                        $imgs="";
                        //判断是否有图片
                        if($param['pic']){
                            foreach ($param['pic'] as $pic) {
                                $urls = str_replace('.oss-','.img-',$pic);
                                $imgs.=$urls.'#@#';
                            }
                        }
                        if(empty($param['endtime'])){
                            $business_data=[
                                'users_id' => $data['guid'],
                                'title' => $param['title'],
                                'type' => $param['type'],
                                'created_at' => date('Y-m-d H:i:s',$data['time']),
                                'content' => $param['content'],
                                'tag' => $param['tag'],
                                'tags' => $param['tags'],
                                'tags_match' => $tags,
                                'phone' => $users_phone[0]['phone'],
                                'contact' => $users_contact[0]['contact'],
                                'img'  => $imgs,
                            ];
                        }else{
                            $business_data=[
                                'users_id' => $data['guid'],
                                'title' => $param['title'],
                                'type' => $param['type'],
                                'created_at' => date('Y-m-d H:i:s',$data['time']),
                                'content' => $param['content'],
                                'tag' => $param['tag'],
                                'tags' => $param['tags'],
                                'tags_match' => $tags,
                                'endtime' => $param['endtime'],
                                'phone' => $users_phone[0]['phone'],
                                'contact' => $users_contact[0]['contact'],
                                'img'  => $imgs,
                            ];
                        }
                        //创建插入方法
                        $business=new \App\Business();
                        $result=$business->add($business_data);
                        //orm模型操作数据库会返回true或false,如果操作失败则返回错误信息
                        if($result){
                            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'发布信息成功']]);
                        }else{

                            return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'请重新发布信息']]);
                        }
                    }else{
                        return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'请完善个人信息中的联系方式']]);
                    }
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'请完善个人信息中的联系方式']]);
                }
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法是向APP提供类型与标签
    */
    public function typetag()
    {
        try{
            //判断缓存
            $typetag_array_cache=Cache::get('business_typetag_typetag_array');
            if($typetag_array_cache){
                //将缓存取出来赋值给变量
                $typetag_array=$typetag_array_cache;
            }else{
                //创建类型的orm模型
                $business_type=new \App\Business_type();
                //创建标签的orm模型
                $business_tag=new \App\Business_tag();
                //取出所有类型
                $business_type_data=$business_type->quer(['id','title'])->toArray();
                foreach ($business_type_data as $value) {
                    foreach ($value as $value_data) {
                        //因为取出的是数组所以要判断是否为id
                        if(is_numeric($value_data)){
                            //取出所有标签
                            $business_tag_data=$business_tag->quer('tag',$value_data)->toArray();
                            foreach ($business_tag_data as $business_tag_value) {
                                foreach ($business_tag_value as $business_tag_value1) {
                                    $business_tag_data_value[]=$business_tag_value1;
                                }
                            }
                        }else {
                            //通过拼接和组合将数据变成合格的json
                            $typetag_array[]=['type'=>$value_data,'tag'=>$business_tag_data_value];
                            $business_tag_data_value=null;
                        }
                    }
                }
                //将查询结果加入缓存
                Cache::add('business_typetag_typetag_array', $typetag_array, 600);
            }
            //假如没有查出数据
            if(empty($typetag_array)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>"查询失败"]]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$typetag_array]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供商机检索标签
    */
    public function search(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            switch ($param['type']) {
                //发布工程标签
                case '1':
                    $result_tag_cache=Cache::get('business_search_result_tag1');
                    break;
                //承接工程标签
                case '2':
                    $result_tag_cache=Cache::get('business_search_result_tag2');
                    break;
                //发布人才
                case '3':
                    $result_tag_cache=Cache::get('business_search_result_tag3');
                    break;
                //招聘人才
                case '4':
                    $result_tag_cache=Cache::get('business_search_result_tag4');
                    break;
                //默认的内容
                default:
                    $ad_result_cache=null;
                    break;
            }
            //判断缓存
            $result_tag_cache=Cache::get('business_search_result_tag');
            if($result_tag_cache){
                //将缓存取出来赋值给变量
                $result_tag=$result_tag_cache;
            }else{
                //创建标签的orm模型
                $business_tag=new \App\Business_tag();
                //查询分类标签
                $business_tag_tag=$business_tag->search_quer('tag',$param['type'])->toArray();
                //便利将关联数组转为索引数组
                foreach ($business_tag_tag as $value1) {
                    foreach ($value1 as $key => $value) {
                        $result_tag[]=$value;
                    }
                }
                //添加缓存
                switch ($param['type']) {
                    //发布工程标签
                    case '1':
                        Cache::add('business_search_result_tag1', $result_tag, 600);
                        break;
                    //承接工程标签
                    case '2':
                        Cache::add('business_search_result_tag2', $result_tag, 600);
                        break;
                    //发布人才
                    case '3':
                        Cache::add('business_search_result_tag3', $result_tag, 600);
                        break;
                    //招聘人才
                    case '4':
                        Cache::add('business_search_result_tag4', $result_tag, 600);
                        break;
                    //默认的内容
                    default:
                        break;
                }
            }
            //判断缓存
            $result_area_cache=Cache::get('business_search_result_area');
            if($result_area_cache){
                //将缓存取出来赋值给变量
                $result_area=$result_area_cache;
            }else{
                //创建标签的orm模型
                $business_tag=new \App\Business_tag();
                //查询地域标签
                $business_tag_area=$business_tag->search_quer('tag',0)->toArray();
                //便利将关联数组转为索引数组
                foreach ($business_tag_area as $value2) {
                    foreach ($value2 as $value3) {
                        $result_area[]=$value3;
                    }
                }
                //将查询结果加入缓存
                Cache::add('business_search_result_area', $result_area, 600);
            }
            //假如有数据就返回，否则返回查询失败
            if(empty($result_tag) && empty($result_area)){
                return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>"查询失败"]]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['tag'=>$result_tag,'area'=>$result_area]]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供商机查询
    */
    public function businessinfo(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量
            $limit=20;
            //创建商机表的orm模型
            $business=new \App\Business();
            $businessinfo=array('bid','phone','contact','title','content','tag','tags','created_at','endtime','img');
            if(empty($param['tag']) && empty($param['search'])){
                //假如没有检索则sql语句为
                $sql='type ='.$param['type'];
            }elseif(!empty($param['tag']) && empty($param['search'])){
                //根据标签检索
                $sql='type ='.$param['type']." and tag='".$param['tag']."'";
            }elseif(empty($param['tag']) && !empty($param['search'])){
                //自定义检索
                $sql="MATCH(tags_match) AGAINST('".bin2hex($param['search'])."') and type =".$param['type'];
            }elseif(!empty($param['tag']) && !empty($param['search'])){
                $sql="MATCH(tags_match) AGAINST('".bin2hex($param['search'])."') and type =".$param['type']." and tag ='".$param['tag']."'";
            }
            $businessinfo_data=$business->quer($businessinfo,$sql,(($param['page']-1)*$limit),$limit);
            $list=null;
            if($businessinfo_data['total']>0){
                //通过数组数据的组合将数据拼凑为{"total":3,"list":[{"bid":1,"phone":"","contact":"","title":"","content":"","tag":"","created_at":"2016-02-24 08:02:50","pic":["1","2"]}格式
                foreach ($businessinfo_data['list'] as $business_data) {
                    //进行图片分隔操作
                    $img=trim($business_data['img'],"#@#");
                    //判断是否有图片
                    if(!empty($img)){
                        $img_arr=explode('#@#',$img);
                        $business_data['pic']=$img_arr;
                    }
                    $list[]=$business_data;
                }
                $showphone=0;
                if($data['guid'] == 0){
                    $showphone=0;
                }else{
                    $users=new \App\Users();
                    $users_auth=$users->quer('certification',['users_id'=>$data['guid']])->toArray();
                    if($users_auth[0]['certification'] == 3){
                        $showphone=1;
                    }
                }
                //返回数据总数和具体数据
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$businessinfo_data['total'],'showphone'=>$showphone,'list'=>$list]]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>"查询失败"]]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供热门招标项目查询
    */
    public function businesshot(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量
            $limit=20;
            //只缓存第一页
            if($param['page'] == 1){
                //判断缓存
                $businessinfo_data_cache=Cache::get('business_businesshot_businessinfo_data');
            }else{
                $businessinfo_data_cache=null;
            }
            if($businessinfo_data_cache){
                //将缓存取出来赋值给变量
                $businessinfo_data=$businessinfo_data_cache;
            }else{
                //创建商机表的orm模型
                $business=new \App\Business();
                $businessinfo=array('bid','phone','contact','title','content','tag','tags','created_at','endtime','img');
                //假如没有检索则sql语句为
                $sql='recommend = 1 and type = 1';
                $businessinfo_data=$business->quer($businessinfo,$sql,(($param['page']-1)*$limit),$limit);
                //只缓存第一页
                if($param['page'] == 1){
                    //将查询结果加入缓存
                    Cache::add('business_businesshot_businessinfo_data', $businessinfo_data, 600);
                }
            }
            $list=null;
            if($businessinfo_data['total']>0){
                //通过数组数据的组合将数据拼凑
                foreach ($businessinfo_data['list'] as $business_data) {
                    //进行图片分隔操作
                    $img=trim($business_data['img'],"#@#");
                    //判断是否有图片
                    if(!empty($img)){
                        $img_arr=explode('#@#',$img);
                        $business_data['pic']=$img_arr;
                    }
                    $list[]=$business_data;
                }
                $showphone=0;
                if($data['guid'] == 0){
                    $showphone=0;
                }else{
                    $users=new \App\Users();
                    $users_auth=$users->quer('certification',['users_id'=>$data['guid']])->toArray();
                    if($users_auth[0]['certification'] == 3){
                        $showphone=1;
                    }
                }
                //返回数据总数和具体数据
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$businessinfo_data['total'],'showphone'=>$showphone,'list'=>$list]]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>"查询失败"]]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供热门工程项目查询
    */
    public function hotproject(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量
            $limit=20;
            //只缓存第一页
            if($param['page'] == 1){
                //判断缓存
                $businessinfo_data_cache=Cache::get('business_hotproject_businessinfo_data');
            }else{
                $businessinfo_data_cache=null;
            }
            if($businessinfo_data_cache){
                //将缓存取出来赋值给变量
                $businessinfo_data=$businessinfo_data_cache;
            }else{
                //创建商机表的orm模型
                $business=new \App\Business();
                $businessinfo=array('bid','phone','contact','title','content','tag','tags','created_at','endtime','img');
                //假如没有检索则sql语句为
                $sql='recommend = 1 and type in(1,2)';
                $businessinfo_data=$business->quer($businessinfo,$sql,(($param['page']-1)*$limit),$limit);
                //只缓存第一页
                if($param['page'] == 1){
                    //将查询结果加入缓存
                    Cache::add('business_hotproject_businessinfo_data', $businessinfo_data, 600);
                }
            }
            $list=null;
            if($businessinfo_data['total']>0){
                //通过数组数据的组合将数据拼凑为{"total":3,"list":[{"bid":1,"phone":"","contact":"","title":"","content":"","tag":"","created_at":"2016-02-24 08:02:50","pic":["1","2"]}格式
                foreach ($businessinfo_data['list'] as $business_data) {
                    //进行图片分隔操作
                    $img=trim($business_data['img'],"#@#");
                    //判断是否有图片
                    if(!empty($img)){
                        $img_arr=explode('#@#',$img);
                        $business_data['pic']=$img_arr;
                    }
                    $list[]=$business_data;
                }
                $showphone=0;
                if($data['guid'] == 0){
                    $showphone=0;
                }else{
                    $users=new \App\Users();
                    $users_auth=$users->quer('certification',['users_id'=>$data['guid']])->toArray();
                    if($users_auth[0]['certification'] == 3){
                        $showphone=1;
                    }
                }
                //返回数据总数和具体数据
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$businessinfo_data['total'],'showphone'=>$showphone,'list'=>$list]]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>"查询失败"]]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供最新招标项目查询
    */
    public function recent(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量
            $limit=20;
            //创建商机表的orm模型
            $business=new \App\Business();
            $businessinfo=array('bid','phone','contact','title','content','tag','tags','created_at','endtime','img');
            if(!empty($param['tag'])){
                //根据标签检索
                $sql=" tag = '".$param['tag']."' and type in(1,2)";
            }else{
                //假如没有检索则sql语句为
                $sql="type in(1,2)";
            }
            $businessinfo_data=$business->quer($businessinfo,$sql,(($param['page']-1)*$limit),$limit);
            $list=null;
            if($businessinfo_data['total']>0){
                //通过数组数据的组合将数据拼凑为{"total":3,"list":[{"bid":1,"phone":"","contact":"","title":"","content":"","tag":"","created_at":"2016-02-24 08:02:50","pic":["1","2"]}格式
                foreach ($businessinfo_data['list'] as $business_data) {
                    //进行图片分隔操作
                    $img=trim($business_data['img'],"#@#");
                    //判断是否有图片
                    if(!empty($img)){
                        $img_arr=explode('#@#',$img);
                        $business_data['pic']=$img_arr;
                    }
                    $list[]=$business_data;
                }
                $showphone=0;
                if($data['guid'] == 0){
                    $showphone=0;
                }else{
                    $users=new \App\Users();
                    $users_auth=$users->quer('certification',['users_id'=>$data['guid']])->toArray();
                    if($users_auth[0]['certification'] == 3){
                        $showphone=1;
                    }
                }
                //返回数据总数和具体数据
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$businessinfo_data['total'],'showphone'=>$showphone,'list'=>$list]]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>"查询失败"]]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }


    /*
    *   该方法提供单个商机查询
    */
    public function businessindex(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建商机表的orm模型
            $business=new \App\Business();
            $businessinfo=array('bid','phone','contact','title','content','tag','tags','created_at','endtime','img');
            //单个商机查询
            $businessinfo_data=$business->quertime($businessinfo,'bid='.$param['bid'])->toArray();
            $list=null;
            if($businessinfo_data){
                //进行图片分隔操作
                $img=trim($businessinfo_data[0]['img'],"#@#");
                //判断是否有图片
                if(!empty($img)){
                    $img_arr=explode('#@#',$img);
                    $businessinfo_data[0]['pic']=$img_arr;
                }
                $list['data']=$businessinfo_data[0];
                $showphone=0;
                if($data['guid'] == 0){
                    $showphone=0;
                }else{
                    $users=new \App\Users();
                    $users_auth=$users->quer('certification',['users_id'=>$data['guid']])->toArray();
                    if($users_auth[0]['certification'] == 3){
                        $showphone=1;
                    }
                }
                $list['showphone']=$showphone;
                //返回数据总数和具体数据
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$list]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>"查询失败"]]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   该方法提供个人发布商机查询
    */
    public function mybusinessinfo(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //默认每页数量
            $limit=20;
            //创建商机表的orm模型
            $business=new \App\Business();
            $businessinfo=array('bid','phone','contact','title','content','tag','tags','created_at','endtime','img');
            $businessinfo_data=$business->quer($businessinfo,'users_id='.$data['guid']." and type =".$param['type'],(($param['page']-1)*$limit),$limit);
            $list=null;
            if($businessinfo_data['total']>0){
                //通过数组数据的组合将数据拼凑为{"total":3,"list":[{"bid":1,"phone":"","contact":"","title":"","content":"","tag":"","created_at":"2016-02-24 08:02:50","pic":["1","2"]}格式
                foreach ($businessinfo_data['list'] as $business_data) {
                    //进行图片分隔操作
                    $img=trim($business_data['img'],"#@#");
                    //判断是否有图片
                    if(!empty($img)){
                        $img_arr=explode('#@#',$img);
                        $business_data['pic']=$img_arr;
                    }
                    $list[]=$business_data;
                }
                //返回数据总数和具体数据
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$businessinfo_data['total'],'list'=>$list]]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>"查询失败"]]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   对个人发布的商机做操作
    */
    public function businessaction(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //创建ORM模型
            $business=new \App\Business();
            //判断用户行为，1为更新时间
            if($param['action'] == "1"){
                //更新时间
                $result=$business->businessupdate($param['bid'],['created_at' => date('Y-m-d H:i:s',$data['time'])]);
                if($result){
                    $update_time=$business->quertime('updated_at','bid = '.$param['bid'])->toArray();
                    if($update_time){
                        //成功返回操作成功
                        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$update_time[0]['updated_at']]);
                    }else {
                        //失败返回操作失败
                        return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'操作失败']]);
                    }
                }else{
                    //失败返回操作失败
                    return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'操作失败']]);
                }
            //判断用户行为，2为删除
            }elseif($param['action'] == "2") {
                //开启事务处理
                $delresult=$business->businessdel($param['bid']);
                if($delresult){
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'操作成功']]);
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'操作失败']]);
                }
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'非法操作']]);
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }

    /*
    *   对个人发布的商机做修改
    */
    public function businessedit(Request $request)
    {
        try{
            //获得app端传过来的json格式的数据转换成数组格式
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //验证用户传过来的数据是否合法
            $validator = Validator::make($param,
                [
                    'type' => 'required',
                    'title' => 'required|max:126',
                    'content' => 'required|min:4',
                    'tag' => 'required',
                    'pic' => 'array',
                    'endtime' => 'required',
                ]
            );
            //如果出错返回出错信息，如果正确执行下面的操作
            if ($validator->fails())
            {
                return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'请填写完整，并且标题长度不能超过60个字，工程简介不能低于4个字']]);
            }else{
                $tags_arr=explode(' ',$param['tags']);
                $tags="";
                if(!empty($tags_arr)){
                    foreach ($tags_arr as $tag_arr) {
                        $tags.=bin2hex($tag_arr)." ";
                    }
                }
                //定义图片变量
                $imgs="";
                //判断是否有图片
                if($param['pic']){
                    foreach ($param['pic'] as $pic) {
                        $urls = str_replace('.oss-','.img-',$pic);
                        $imgs.=$urls.'#@#';
                    }
                }
                //需要更新的数据
                $business_data=[
                    'title' => $param['title'],
                    'created_at' => date('Y-m-d H:i:s',$data['time']),
                    'content' => $param['content'],
                    'tag' => $param['tag'],
                    'tags' => $param['tags'],
                    'tags_match' => $tags,
                    'endtime' => $param['endtime'],
                    'img'  => $imgs,
                ];

                //创建插入方法
                $business=new \App\Business();
                $updateresult=$business->businessupdate($param['bid'],$business_data);
                //假如更新成功就继续更新图片
                if($updateresult){
                    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['Message'=>'修改成功']]);
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>8,'ResultData'=>['Message'=>'修改信息失败，请重新修改']]);
                }
            }
        }catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>'该模块维护中']]);
        }
    }
}
