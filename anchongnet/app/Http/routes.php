<?php


/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

//接口路由组

Route::group(['domain' => 'api.anchong.net'], function () {
    Route::post('/community/chonggou','Api\Community\CommunityController@chonggou');
    Route::post('/business/chonggou','Api\Business\BusinessController@chonggou');
    //商品检索
    Route::post('/goods/goodssearch','Api\Goods\GoodsController@goodssearch');
    //智能提示
    Route::controller('/search','Api\SearchController');
    //加上token验证的api
    Route::group(['middleware' => 'AppPrivate'], function () {
        /*
        *   APP更新
        */
        //安卓更新接口
        Route::post('/android/androidupdate','Api\Feedback\FeedbackController@androidupdate');
        /*
        *   用户模块
        */
        //短信验证码的接口
        Route::post('/user/smsauth','Api\User\UserController@smsauth');
        //用户注册的接口
        Route::post('/user/register','Api\User\UserController@register');
        //用户登录的接口
        Route::post('/user/login','Api\User\UserController@login');
        //用户修改密码的接口
        Route::post('/user/forgetpassword','Api\User\UserController@forgetpassword');
        //获得用户资料
        Route::post('/user/getmessage','Api\User\UsermessagesController@show');
        //修改用户资料
        Route::post('/user/setmessage','Api\User\UsermessagesController@update');
        //设置头像
        Route::post('/user/sethead','Api\User\UsermessagesController@setUserHead');
        //用户进行个体认证的路由
        Route::post('/user/indivi','Api\User\UserIndiviController@index');
        //上传的sts认证
        Route::post('/user/sts','Api\User\UserController@sts');
        //上传回调
        Route::post('/user/callback','Api\User\UserController@callback');
        //用户收货地址列表
        Route::post('/user/address','Api\User\UserAddressController@show');
        //用户添加收货地址
        Route::post('/user/storeaddress','Api\User\UserAddressController@store');
        //用户进入修改收货地址界面的方法
        Route::post('/user/editaddress','Api\User\UserAddressController@edit');
        //用户修改收货地址
        Route::post('/user/updateaddress','Api\User\UserAddressController@update');
        //获取用户默认收货地址
        Route::post('/user/getdefaultaddress','Api\User\UserAddressController@getdefault');
        //用户设置默认收货地址
        Route::post('/user/setdefaultaddress','Api\User\UserAddressController@setdefault');
        //用户删除收货地址
        Route::post('/user/deladdress','Api\User\UserAddressController@del');
        //获取指定用户资料
        Route::any('/user/getmessage','Api\User\UsermessagesController@show');
        Route::any('/catbrand','Api\Shop\CatbrandController@index');

        /*
        *   商机模块
        */
        //商机首页
        Route::post('/business/businessindex','Api\Business\BusinessController@businessindex');
        //商机发布
        Route::post('/business/release','Api\Business\BusinessController@release');
        //发布类别和标签
        Route::post('/business/typetag','Api\Business\BusinessController@typetag');
        //商机检索标签
        Route::post('/business/search','Api\Business\BusinessController@search');
        //商机查看
        Route::post('/business/businessinfo','Api\Business\BusinessController@businessinfo');
        //热门招标项目查看
        Route::post('/business/businesshot','Api\Business\BusinessController@businesshot');
        //最新招标项目查看
        Route::post('/business/recent','Api\Business\BusinessController@recent');
        //热门工程查看
        Route::post('/business/hotproject','Api\Business\BusinessController@hotproject');
        //个人发布商机查看
        Route::post('/business/mybusinessinfo','Api\Business\BusinessController@mybusinessinfo');
        //个人商机操作
        Route::post('/business/businessaction','Api\Business\BusinessController@businessaction');
        //个人商机修改
        Route::post('/business/businessedit','Api\Business\BusinessController@businessedit');

        /*
        *   商品模块
        */
        //商铺路由
        Route::resource('/shop','Api\Shop\ShopController');
        //商品详细分类信息
        Route::post('/goods/catinfo','Api\Category\CategoryController@catinfo');
        //商品列表
        Route::post('/goods/goodslist','Api\Goods\GoodsController@goodslist');
        //商品列表所有商品
        Route::post('/goods/goodsall','Api\Goods\GoodsController@goodsall');
        //提供商品标签的检索
        Route::post('/goods/tag','Api\Goods\GoodsController@goodslist');
        //商品详情
        Route::post('/goods/goodsinfo','Api\Goods\GoodsController@goodsinfo');
        //商品推荐
        Route::post('/goods/correlation','Api\Goods\GoodsController@correlation');
        //商品配套
        Route::post('/goods/supporting','Api\Goods\GoodsController@supporting');
        //商品规格
        Route::post('/goods/goodsformat','Api\Goods\GoodsController@goodsformat');
        //货品详情
        Route::post('/goods/goodsshow','Api\Goods\GoodsController@goodsshow');
        //商品发布
        Route::post('/goods/goodsrelease','Api\Goods\GoodsController@goodsrelease');
        //商品检索标签
        Route::post('/goods/goodstag','Api\Goods\GoodsController@goodstag');

        /*
        *   购物车模块
        */
        //购物车添加
        Route::post('/cart/cartadd','Api\Cart\CartController@cartadd');
        //购物车查看
        Route::post('/cart/cartinfo','Api\Cart\CartController@cartinfo');
        //购物车物品数量加减
        Route::post('/cart/cartnum','Api\Cart\CartController@cartnum');
        //购物车物品删除
        Route::post('/cart/cartdel','Api\Cart\CartController@cartdel');
        //购物车商品数量
        Route::post('/cart/cartamount','Api\Cart\CartController@cartamount');


        /*
        *   订单模块
        */
        //订单添加
        Route::post('/order/ordercreate','Api\Order\OrderController@ordercreate');
        //订单查看
        Route::post('/order/orderinfo','Api\Order\OrderController@orderinfo');
        //订单操作
        Route::post('/order/orderoperation','Api\Order\OrderController@orderoperation');
        //订单付款
        Route::post('/order/orderpay','Api\Order\OrderController@orderpay');

        /*
        *   商铺模块
        */
        //商铺商品查看
        Route::post('/shops/goodsshow','Api\Shop\ShopsController@goodsshow');
        //商铺商品操作
        Route::post('/shops/goodsaction','Api\Shop\ShopsController@goodsaction');
        //商铺商品筛选分类
        Route::post('/shops/goodstype','Api\Shop\ShopsController@goodstype');
        //商铺商品筛选
        Route::post('/shops/goodsfilter','Api\Shop\ShopsController@goodsfilter');
        //商铺订单查看
        Route::post('/shops/shopsorder','Api\Shop\ShopsController@shopsorder');
        //商铺订单操作
        Route::post('/shops/shopsoperation','Api\Shop\ShopsController@shopsoperation');
        //商铺地址添加操作
        Route::post('/shops/addressadd','Api\Shop\ShopsController@addressadd');
        //我的店铺
        Route::post('/shops/myshops','Api\Shop\ShopsController@myshops');
        //我的店铺信息修改
        Route::post('/shops/shopsedit','Api\Shop\ShopsController@shopsedit');
        //店铺全部商品
        Route::post('/shops/shopsgoods','Api\Shop\ShopsController@shopsgoods');
        //店铺首页商品
        Route::post('/shops/shopsindex','Api\Shop\ShopsController@shopsindex');
        //店铺新商品
        Route::post('/shops/newgoods','Api\Shop\ShopsController@newgoods');
        //商铺发货快递公司
        Route::post('/shops/logistcompany','Api\Shop\ShopsController@logistcompany');

        /*
        *   收藏模块
        */
        //添加收藏
        Route::post('/collect/addcollect','Api\Collect\CollectController@addcollect');
        //取消收藏
        Route::post('/collect/delcollect','Api\Collect\CollectController@delcollect');
        //查询收藏的货品
        Route::post('/collect/goodscollect','Api\Collect\CollectController@goodscollect');
        //查询收藏的商铺
        Route::post('/collect/shopscollect','Api\Collect\CollectController@shopscollect');


        /*
        *   社区模块
        */
        //发布聊聊
        Route::post('/community/release','Api\Community\CommunityController@release');
        //发布评论
        Route::post('/community/comment','Api\Community\CommunityController@comment');
        //回复评论
        Route::post('/community/reply','Api\Community\CommunityController@reply');
        //聊聊首页显示
        Route::post('/community/communityshow','Api\Community\CommunityController@communityshow');
        //我的聊聊显示
        Route::post('/community/mycommunity','Api\Community\CommunityController@mycommunity');
        //我收藏的聊聊
        Route::post('/community/mycollect','Api\Community\CommunityController@mycollect');
        //聊聊详情
        Route::post('/community/communityinfo','Api\Community\CommunityController@communityinfo');
        //聊聊详情评论
        Route::post('/community/communitycom','Api\Community\CommunityController@communitycom');
        //评论详情
        Route::post('/community/commentinfo','Api\Community\CommunityController@commentinfo');
        //收藏聊聊
        Route::post('/community/addcollect','Api\Community\CommunityController@addcollect');
        //取消收藏聊聊
        Route::post('/community/delcollect','Api\Community\CommunityController@delcollect');
        //删除聊聊
        Route::post('/community/communitydel','Api\Community\CommunityController@communitydel');

        /*
        *   支付模块
        */
        //支付宝
        Route::get('/pay/alipay','Api\Pay\PayController@alipay');
        //支付后跳转页面
        Route::any('pay/webnotify','Api\Pay\PayController@webnotify');
        //支付后跳转页面
        Route::any('pay/webreturn','Api\Pay\PayController@webreturn');
		//微信app支付
        Route::post('/pay/wxapppay','Api\Pay\PayController@wxapppay');

        /*
        *   广告模块
        */
        //商机首页广告
        Route::post('/advert/businessadvert','Api\Advert\AdvertController@businessadvert');
        //商机首页资讯
        Route::post('/advert/information','Api\Advert\AdvertController@information');
        //商城首页广告
        Route::post('/advert/goodsadvert','Api\Advert\AdvertController@goodsadvert');
        //聊聊首页广告
        Route::post('/advert/projectadvert','Api\Advert\AdvertController@projectadvert');

        /*
        *   意见反馈模块
        */
        //意见反馈提交
        Route::post('/feedback/release','Api\Feedback\FeedbackController@release');
        //意见反馈回复
        Route::post('/feedback/reply','Api\Feedback\FeedbackController@reply');
        //意见反馈操作
        Route::post('/feedback/replyedit','Api\Feedback\FeedbackController@replyedit');
        //意见反馈未查看数量
        Route::post('/feedback/replycount','Api\Feedback\FeedbackController@replycount');

        /*
        *   钱袋模块
        */
        //钱袋余额
        Route::post('/purse/pursemoney','Api\Purse\PurseController@pursemoney');
        //可用余额
        Route::post('/purse/usablemoney','Api\Purse\PurseController@usablemoney');
        //虫豆首页
        Route::post('/purse/beansindex','Api\Purse\PurseController@beansindex');
        //虫豆签到
        Route::post('/purse/signin','Api\Purse\PurseController@signin');
    });
});

//支付宝路由
Route::group(['domain' => 'pay.anchong.net'], function () {
    //安虫自营路由组
    Route::group(['middleware'=>'PayAuthen'],function(){
        Route::post('/pay/mobilenotify','Api\Pay\PayController@mobilenotify');
    });
    //支付后异步回调
    Route::any('/pay/webnotify','Api\Pay\PayController@webnotify');
    //微信支付
    Route::any('/pay/wxpay','Api\Pay\PayController@wxpay');
    //微信支付回调
    Route::any('/pay/wxnotify','Api\Pay\PayController@wxnotify');
    //银联支付处理
    Route::get('/unionpay/pay','Api\Pay\UnionpayController@pay');
});

//后台路由
Route::group(['domain' => 'admin.anchong.net'], function () {
    //搜索
        //Route::controller('/search','Api\SearchController');
        //注册相关
        Route::any('/userregister', 'admin\indexController@userregister');
        Route::any('/zhuce', 'admin\indexController@zhuce');
        //支付宝
        Route::get('/pay/alipay','Api\Pay\PayController@alipay');
        //验证码类,需要传入数字
        Route::get('/captcha/{num}', 'CaptchaController@captcha');
        //登录检查
        Route::any('/checklogin','admin\indexController@checklogin');
        //加中间件的路由组
        Route::group(['middleware' => 'LoginAuthen'], function () {
                //首页路由
            Route::get('/','admin\indexController@index');

            //安虫自营路由组
            Route::group(['middleware'=>'anchong'],function(){
                /**** 抽奖临时*****/
                Route::controller('/prize','PrizeController');
                /*********/
                //用户路由
                Route::resource('/users','admin\userController');
                //认证路由
                Route::resource('/cert','admin\certController');
                //认证检查
                Route::get('/check','admin\CheckController@check');
                //商铺路由
                Route::resource('/shop','admin\shopController');
                //商铺审核路由
                Route::get("/checkShop",'admin\checkShopController@index');
                //物流管理
                Route::resource('/logis','admin\logisController');
                //标签管理路由
                Route::resource('/tag','admin\tagController');
                //分类标签管理路由
                Route::resource('/catag','admin\caTagController');
                //分类管理路由
                Route::resource('/goodcate','admin\goodCateController');

                /*
                 *   后台广告
                 */
                //编辑时候添加图片
                Route::post('/advert/addpic','admin\Advert\AdvertController@addpic');
                //商机广告
                Route::post('/advert/businessadvert','admin\Advert\AdvertController@businessadvert');

                //单个资讯查看
                Route::get('/advert/firstinfor/{id}','admin\Advert\AdvertController@firstinfor');
                //资讯更新
                Route::post('/advert/inforupdate','admin\Advert\AdvertController@inforupdate');
                //发布资讯
                Route::post('/advert/releasenews','admin\Advert\AdvertController@releasenews');
                //删除资讯
                Route::get('/advert/infordel/{num}','admin\Advert\AdvertController@infordel');
                //发布资讯页面
                Route::get('/advert/newsshow','admin\Advert\AdvertController@newsshow');
                //查看资讯页面
                Route::get('/advert/newsindex','admin\Advert\AdvertController@newsindex');
                //查看商机广告页面
                Route::get('/advert/busiadvert','admin\Advert\AdvertController@busiadvert');

                /*
                *   商铺操作与管理
                */
                //商铺的开启与关闭
                Route::post('/shop/shopstate','admin\shopController@shopstate');
                
                //社区所有聊聊
                Route::resource('/releases','admin\releaseController@releases');
                //所有商机
                Route::resource('/businesss','admin\businessController@businesss');
            });
                //后台登出
            Route::get('/logout','admin\indexController@logout');
            //订单管理路由
            Route::resource('/order','admin\orderController');
            //订单发货路由
            Route::post('/ordership','admin\orderController@orderShip');
            //订单审核路由
            Route::post('/checkorder','admin\orderController@checkorder');
            //获取同一个订单的订单信息的路由
            Route::get('/getsiblingsorder','admin\orderinfoController@getSiblingsOrder');

            //获取所有物流
            Route::get('/getlogis','admin\logisController@getAll');
            //获取商铺的主营品牌
            Route::get('/getbrand','admin\shopController@getbrand');
            //获取商铺的主营类别
            Route::get('/getcat','admin\shopController@getcat');
            //获取所有标签路由
            Route::get('/getag','admin\tagController@geTag');
            //获取同一个分类的所有标签的路由
            Route::get('/getsiblingstag','admin\caTagController@getSiblings');

            //获取商品一级或二级分类路由
            Route::get('/getlevel','admin\goodCateController@getLevel');
            //获取商品一级或二级分类路由
            Route::get('/newgetlevel','admin\goodCateController@newgetLevel');
            //获取商品所有二级分类路由
            Route::get('/getlevel2','admin\goodCateController@getLevel2');
            //获取同一个一级分类下的所有二级分类的路由
            Route::get('/getsiblingscat','admin\goodCateController@getSiblings');
            //获取同一个一级分类下的所有二级分类的路由
            Route::get('/newgetsiblingscat','admin\goodCateController@newgetSiblings');

            //商品管理路由
            Route::resource('/good','admin\goodController');
            Route::resource('/commodity','admin\commodityController');
            //获取同一分类下的商品的路由
            Route::get('/getsibilingscommodity','admin\commodityController@getSiblings');
            //获取同一商品下的所有货品的路由
            Route::get('/getsiblingsgood','admin\goodController@getSiblings');
            //获取商品的配套商品的路由
            Route::get('/getsupcom','admin\goodSupportingController@getSupcom');
            //配套商品管理路由
            Route::resource('/goodsupporting','admin\goodSupportingController');

            //商品图片管理路由
            Route::resource('/thumb','admin\thumbController');
            Route::get('/getgoodthumb','admin\thumbController@getGoodThumb');
            Route::resource('/img','admin\ImgController');
            Route::get('/getgoodimg','admin\ImgController@getGoodImg');
            //编辑货品时添加货品图片的路由
            Route::post('/addgoodpic','admin\goodController@addpic');
            //替换商品详情图片的路由
            Route::post('/updataimg','admin\commodityController@updateImg');

            //库存管理路由
            Route::resource('/stock','admin\stockController');
            //获取指定货品库存路由
            Route::get('/getStock','admin\stockController@getStock');
            //更新货品的库存总数
            Route::get('/getotal','admin\stockController@getTotal');

            //商品属性路由
            Route::resource('/attr','admin\attrController');
            //获取同一个商品的所有属性信息的路由
            Route::get('/getsiblingsattr','admin\attrController@getSiblings');

            //社区路由
            Route::resource('/release','admin\releaseController');
            //社区图片上传路由
            Route::resource('/releaseimg','admin\releaseImgController');
            //获取指定发布图片的路由
            Route::get('/relimg','admin\releaseImgController@getImg');
            //编辑发布的时候添加发布图片
            Route::post('/addrelimg','admin\releaseController@addpic');
            //删除指定商机图片
            Route::get('/delrelimg','admin\releaseImgController@delpic');

            //评论路由
            Route::resource('/comment','admin\commentController');
            //回复评论路由
            Route::resource('/reply','admin\replyController');

            //商机管理
            Route::resource('/business','admin\businessController');
            //商机图片
            Route::resource('/businessimg','admin\busimgController');
            //获取指定商机的商机图片
            //Route::get('/busimg','admin\busimgController@getImg');
            //删除指定商机图片
            Route::get('/delimg','admin\busimgController@delpic');
            //编辑商机的时候修改商机图片
            Route::post('/editbusimg/{num}','admin\businessController@editpic');
            //删除商机指定图片
            Route::post('/delbusinessimg/{num}','admin\businessController@delpic');




            //权限管理 隐式路由
            Route::controller('/permission','admin\PermissionController');
            /*
            *   后台商品
            */
            //后台商品删除
            Route::post('/goods/goodsdel','admin\Goods\GoodsController@goodsdel');

            /*
            *   后台社区
            */
            //后台社区编辑获取图片
            Route::get('/community/imgshow/{num}','admin\releaseController@imgshow');

            /*
            *   后台商机
            */
            //后台商机编辑获取图片
            Route::get('/business/imgshow/{num}','admin\businessController@imgshow');

            /*
            *   后台意见反馈
            */
            //后台意见反馈查看
            Route::get('/feedback/show','admin\Feedback\FeedbackController@show');
            //后台意见图片查看
            Route::get('/feedback/imgshow/{num}','admin\Feedback\FeedbackController@imgshow');
            //后台意见删除
            Route::get('/feedback/feedbackdel/{num}','admin\Feedback\FeedbackController@feedbackdel');
            //后台意见状态修改
            Route::post('/feedback/feedbackedit/{num}','admin\Feedback\FeedbackController@feedbackedit');
            //后台意见回复
            Route::post('/feedback/feedbackreply','admin\Feedback\FeedbackController@feedbackreply');
            //后台意见状态修改
            Route::post('/feedback/feedbackview','admin\Feedback\FeedbackController@feedbackview');
        });
    });


//前台路由
Route::group(['domain' => 'www.anchong.net'], function () {
    //获取商品参数html代码
    Route::get('/getparam','admin\uEditorController@getParam');
    Route::get('/getpackage','admin\uEditorController@getPackage');
    //获取虫虫资讯
    Route::get('/information/{infor_id}','Api\Advert\AdvertController@informations');
    Route::get('/','home\indexController@index');

    //前台安全防护
    Route::group(['middleware'=>'csrf'],function(){
        //个人中心
        Route::controller('/pcenter','Home\Pcenter\IndexController');
        //前台注册
        //前台注册
        Route::resource('/user/register','Home\User\RegController');
        //手机短信
        Route::post('/user/smsauth','Home\User\RegController@smsauth');
        //前台登录
        Route::resource('/user/login','Home\User\LoginController');
        //前台重置密码
        Route::resource('/user/forgetpwd','Home\User\ForgetpwdController');
    });
});

//验证码类,需要传入数字
Route::get('/captcha/{num}', 'CaptchaController@captcha');
