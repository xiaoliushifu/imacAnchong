<?php

namespace App\Http\Controllers\Api\User;

use Request;
use App\Usermessages;
use App\Users;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Order;
use App\Shop;
use App\Users_login;
use DB;

use OSS\OssClient;
use OSS\Core\OssException;

class UsermessagesController extends Controller
{
	//定义变量
    private $JsonPost;
	private $usermessages;
	private $user;
	private $order;
	private $shop;
	private $login;
	public function __construct(){
		$this->JsonPost=new \App\JsonPost\JsonPost();
		$this->usermessages=new usermessages();
		$this->user=new Users();
		$this->order=new Order();
		$this->shop=new Shop();
		$this->login=new Users_login();
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
		$data=$request::all();
		//通过guid获取用户实例
		$id=$data['guid'];
		$shop=$this->shop->User($id)->get();
		if(count($shop)==0){
			$audit=0;
		}else{
			$audit=$shop[0]['audit'];
		};
		$person=Users::Ids($id)->first();
		switch($person->certification){
			case 0:
			$status="未提交认证";
			break;
			case 1:
			$status="认证待审核";
			break;
			case 2:
			$status="审核未通过";
			break;
			case 3:
			$status="审核已通过";
			break;
		};
        $data=Usermessages::Message($id)->take(1)->get();

		if(count($data)==0){
			return response()->json(
			[
				'serverTime'=>time(),
				'ServerNo'=>0,
				'ResultData'=>[
					'contact' => "",
					'nickname'=>"",
					'account'=>"",
					'qq'=>"",
					'email'=>"",
					'headpic'=>"",
					'authStatus'=>$status,
					'authNum'=>$person->certification,
					'waitforcash'=>0,
					'waitforsend'=>0,
					'waitforreceive'=>0,
					'aftermarket'=>0,
					'shopstatus'=>'',
					'shopname'=>'',
					'shoplogo'=>'',
					'shopid'=>'',
					'beans' => '',
				],
			]);
		}else{
			//获取数据
			$users_handle=$this->user->find($id);
			$user=Usermessages::where('users_id', '=', $id)->first();
			$waitforcash=count($this->order->US($id,1)->get());
			$waitforsend=count($this->order->US($id,2)->get());
			$waitforreceive=count($this->order->US($id,3)->get());
			$aftermarket=count($this->order->US($id,7)->get());
			if($audit==2){
				$shopname=$shop[0]['name'];
				$shoplogo=$shop[0]['img'];
				$shopid=$shop[0]['sid'];
			}else{
				$shopname="";
				$shoplogo="";
				$shopid="";
			}
			return response()->json(
				[
					'serverTime'=>time(),
					'ServerNo'=>0,
					'ResultData'=>[
						'contact' => $user->contact,
						'nickname'=>$user->nickname,
						'account'=>$user->account,
						'qq'=>$user->qq,
						'email'=>$user->email,
						'headpic'=>$user->headpic,
						'authStatus'=>$status,
						'authNum'=>$person->certification,
						'waitforcash'=>$waitforcash,
						'waitforsend'=>$waitforsend,
						'waitforreceive'=>$waitforreceive,
						'aftermarket'=>$aftermarket,
						'shopstatus'=>$audit,
						'shopname'=>$shopname,
						'shoplogo'=>$shoplogo,
						'shopid'=>$shopid,
						'beans' => $users_handle->beans,
						'paypassword' => $users_handle->password?1:0,
					],
				]
			);
		}

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view("admin/users/edit");
    }

    /**
     * 	用户资料的设置和修改
     */
    public function update(Request $request)
    {
		$data=$request::all();
		$param=json_decode($data['param'],true);
		//通过guid获取用户实例
		$id=$data['guid'];
        $message_data=Usermessages::Message($id)->take(1)->get();
		$validator = Validator::make($param,
            [
                'qq' => 'digits_between:5,11',
                'email' => 'email|unique:anchong_usermessages,email',
				'nickname' => 'unique:anchong_usermessages,nickname'
            ]
        );
		//验证失败时返回错误信息
		if ($validator->fails()) {
			$messages = $validator->errors();
			if ($messages->has('qq')) {
			    return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData' => ['Message'=>'qq格式不正确']]);
			} elseif ($messages->has('email')) {
				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData' => ['Message'=>'email格式不正确或该邮箱已经被注册']]);
			} elseif ($messages->has('nickname')) {
				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData' => ['Message'=>'该昵称已被注册，请更换昵称']]);
			}
		} else {
			//查出用户账号
			$account=DB::table('anchong_users_login')->where('users_id', $id)->pluck('username');
		    //库中无，则是添加资料
			if (count($message_data)==0) {
				$this->usermessages->account=$account[0];
				$this->usermessages->users_id = $id;
				if ($param['nickname']!=null) {
					$this->usermessages->nickname = $param['nickname'];
				}
				if ($param['qq']!=null) {
					$this->usermessages->qq = $param['qq'];
				}
				if ($param['email']!=null) {
					$this->usermessages->email = $param['email'];
				}
				if ($param['contact']!=null) {
					$this->usermessages->contact = $param['contact'];
				}
				//网易云信
	            $url  = "https://api.netease.im/nimserver/user/create.action";
	            $datas = 'accid='.($account[0]).'&name='.($param['nickname']?$param['nickname']:$account[0]).'&token=3c374b5bc7a7d5235cde6426487d8a3c';
	            list($return_code, $return_content) = $this->JsonPost->http_post_data($url, $datas);
	            //判断是否请求成功
	            if($return_code != 200){
	                return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData' => ['Message'=>'更新失败']]);
	            }else {
					//对数据库进行更新
	                $results=DB::table('anchong_users_login')->where('users_id',$id)->update(['netease_token'=>'3c374b5bc7a7d5235cde6426487d8a3c']);
					//更新失败就返回
					if(!$results){
						return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData' => ['Message'=>'更新失败']]);
					}
	            }
				$result=$this->usermessages->save();
			} else {
			    //库中有，则是修改资料
				$user=usermessages::where('users_id', '=', $id)->first();
				if ($param['nickname']!=null) {
					$user->nickname = $param['nickname'];
					//网易云信
		            $url  = "https://api.netease.im/nimserver/user/create.action";
					$datas = 'accid='.($account[0]).'&name='.($param['nickname']);
		            list($return_code, $return_content) = $this->JsonPost->http_post_data($url, $datas);
		            //判断是否请求成功
		            if($return_code != 200){
		                return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData' => ['Message'=>'更新失败']]);
		            }
				}
				if ($param['qq']!=null) {
					$user->qq = $param['qq'];
				}
				if ($param['email']!=null) {
					$user->email = $param['email'];
				}
				if ($param['contact']!=null) {
					$user->contact = $param['contact'];
				}
				$result=$user->save();
			}

			//返回给客户端数据
			if ($result) {
				return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['Message'=>'更新成功']]);
			} else {
				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData' => ['Message'=>'更新失败']]);
			}
		}
    }

	/*
	*	用户头像设置
	*/
	public function setUserHead(Request $request)
	{
		$data=$request::all();
		//通过guid获取用户实例
		$id=$data['guid'];
		$param=json_decode($data['param'],true);

		//配置阿里云oss配置
		$accessKeyId = "HJjYLnySPG4TBdFp";
		$accessKeySecret = "Ifv0SNWwch5sgFcrM1bDthqyy4BmOa";
		$endpoint = "oss-cn-hangzhou.aliyuncs.com";
		$bucket="anchongres";

		//设置上传到阿里云oss的对象的键名
		switch ($_FILES["headpic"]["type"]){
			case "image/png":
			$object="headpic/".time().".png";
			break;
			case "image/jpeg":
			$object="headpic/".time().".jpg";
			break;
			case "image/jpg":
			$object="headpic/".time().".jpg";
			break;
			case "image/gif":
			$object="headpic/".time().".gif";
			break;
			default:
			$object="headpic/".time().".jpg";
		}

		$filePath = $data['headpic'];
		try {
			//实例化一个ossClient对象
			$ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
			//上传文件
			$ossClient->uploadFile($bucket, $object, $filePath);
			//获取到上传文件的路径
			$signedUrl = $ossClient->signUrl($bucket, $object);
			$pos=strpos($signedUrl,"?");
			$urls = substr($signedUrl, 0, $pos);
			$url = str_replace('.oss-','.img-',$urls);
			//判断该表是否有该用户
			$num=$this->usermessages->countquer('users_id ='.$id);
			//查出该用户的账号
			$account=DB::table('anchong_users_login')->where('users_id', $id)->pluck('username');
			//假如没有该用户则创建该用户
			if($num == 0){
				//创建新的一条数据并插入头像
				$this->usermessages->users_id=$id;
				$this->usermessages->headpic=$url;
				//网易云信
	            $url  = "https://api.netease.im/nimserver/user/create.action";
	            $datas = 'accid='.($account[0]).'&icon='.($url).'&token=3c374b5bc7a7d5235cde6426487d8a3c';
	            list($return_code, $return_content) = $this->JsonPost->http_post_data($url, $datas);
	            //判断是否请求成功
	            if($return_code != 200){
	                return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData' => ['Message'=>'头像上传失败']]);
	            }else {
					//对数据库进行更新
	                $results=DB::table('anchong_users_login')->where('users_id',$id)->update(['netease_token'=>'3c374b5bc7a7d5235cde6426487d8a3c']);
					//更新失败就返回
					if(!$results){
						return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData' => ['Message'=>'头像上传失败']]);
					}
	            }
				$result=$this->usermessages->save();
			}elseif($num == 1){
				//更新数据
				$data=Usermessages::where('users_id', '=', $id)->first();
				$data->headpic=$url;
				//网易云信
				$url  = "https://api.netease.im/nimserver/user/create.action";
				$datas = 'accid='.($account[0]).'&icon='.($url);
				list($return_code, $return_content) = $this->JsonPost->http_post_data($url, $datas);
				//判断是否请求成功
				if($return_code != 200){
					return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData' => ['Message'=>'头像更新失败']]);
				}
				$result=$data->save();
			}
			//假如头像插入成功
			if($result){
				$userlogin=Users_login::Uid($id);
				$userlogin->headpic=$url;
				$results=$userlogin->save();
			}else{
				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData'=>['Message'=>'头像上传失败']]);
			}
			if($results){
				//返回数据
				return response()->json(["serverTime"=>time(),"ServerNo"=>0,"ResultData" => [
						'Message'=>'上传成功',
						'headPicUrl' => $url
				]]);
			}else{
				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData'=>['Message'=>'头像上传失败']]);
			}
		} catch (OssException $e) {
			print $e->getMessage();
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
}
