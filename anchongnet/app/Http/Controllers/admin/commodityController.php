<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Good;
use App\Shop;
use Auth;
use DB;

class commodityController extends Controller
{
    private $good;
    private $uid;
    private $sid;
    private $gid;
    public function __construct()
    {
        $this->good=new Good();
        //通过Auth获取当前登录用户的id
        $this->uid=Auth::user()['users_id'];
        //通过用户获取商铺id
        $this->sid=Shop::Uid($this->uid)->sid;
        //初始化gid属性为空
        $this->gid="";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyName=Requester::input('keyName');
        if($keyName==""){
            $datas=$this->good->paginate(8);
        }else{
            $datas = Good::Name($keyName)->paginate(8);
        }
        $args=array("keyName"=>$keyName);
        return view('admin/good/index_commodity',array("datacol"=>compact("args","datas")));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin/good/create_commodity",array('sid'=>$this->sid,'gid'=>$this->gid));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\CommodityRequest $request)
    {
        /*
         * 因为要向多个表中插入数据，
         * 所以需要开启事务处理
         * */
        DB::beginTransaction();
        //向goods表中插入数据并获取刚插入数据的主键
        $gid = DB::table('anchong_goods')->insertGetId(
            [
                'title'=>$request->name,
                'sid'=>$this->sid,
                'desc'=>$request->description,
                'type'=>$request->midselect
            ]
        );

        //通过一个for循环向属性表中插入数据
        for($i=0;$i<count($request->attrname);$i++){
            DB::table('anchong_goods_attribute')->insertGetId(
                [
                    'goods_id'=>$gid,
                    'name'=>$request->attrname[$i],
                    'value'=>$request->attrvalue[$i]
                ]
            );
        };

        //通过一个for循环向图片表中插入数据
        for($i=0;$i<count($request->pic);$i++){
            DB::table('anchong_goods_img')->insertGetId(
                [
                    'goods_id'=>$gid,
                    'url'=>$request->pic[$i]['url'],
                    'thumb_url'=>$request->pic[$i]['url'],
                    'type'=>$request->pic[$i]['imgtype']
                ]
            );
        }

        //将对象的gid属性设置为刚插入的那条数据的主键并返回给页面
        $this->gid=$gid;
        //提交事务
        DB::commit();
        return view("admin/good/create_commodity",array('sid'=>$this->sid,'gid'=>$this->gid,'mes'=>"添加成功！"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=$this->good->find($id);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=$this->good->find($id);
        return $data;
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
        $data=$this->good->find($id);
        $data->type=$request->backselect;
        $data->title=$request->title;
        $data->desc=$request->description;
        $result=$data->save();
        if($result){
            return redirect()->back();
        }else{
            return "更新失败，请返回重试";
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

    /*
     * 获取同一个分类下的商品的方法
     * */
    public function getSiblings(Request $request){
        $data=Good::Type($request['pid'],$request['sid'])->get();
        return $data;
    }
}
