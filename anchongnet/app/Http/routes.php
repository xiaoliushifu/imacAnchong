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
//提供商品检索
     Route::post('/goods/goodsfilter','Api\Goods\GoodsController@goodsfilter');
    //网易云信注册机
    Route::post('/live/regnetease','Api\Live\LiveController@regnetease');
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
        //用户忘记密码的接口
        Route::post('/user/forgetpassword','Api\User\UserController@forgetpassword');
        //用户修改密码的接口
        Route::post('/user/editpassword','Api\User\UserController@editpassword');
        //用户设置支付密码
        Route::post('/user/paypassword','Api\User\UserController@paypassword');
        //获得用户资料
        Route::post('/user/getmessage','Api\User\UsermessagesController@show');
        //修改用户资料
        Route::post('/user/setmessage','Api\User\UsermessagesController@update');
        //设置头像
        Route::post('/user/sethead','Api\User\UsermessagesController@setUserHead');
        //用户进行个体认证的路由
        Route::post('/user/indivi','Api\User\UserIndiviController@index');
        //用户进行修改认证的路由
        Route::post('/user/changeindivi','Api\User\UserIndiviController@change');
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
        Route::post('/goods/tag','Api\Goods\GoodsController@tag');

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
        //购物车分享
        Route::post('/cart/cartshare','Api\Cart\CartController@cartshare');

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
        //查看订单及物流状态
        Route::post('/order/orderstate','Api\Order\OrderController@orderstate');
        //单个订单详情查看
        Route::post('/order/orderdetail','Api\Order\OrderController@orderdetail');
        //订单修改
        Route::post('/order/orderedit','Api\Order\OrderController@orderedit');
        //订单免运费
        Route::post('/order/freefreight','Api\Order\OrderController@freefreight');

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
        //店铺联系客服
        Route::post('/shops/Cservice','Api\Shop\ShopsController@Cservice');
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
        //聊聊消息提示
        Route::post('/community/message','Api\Community\CommunityController@message');
        //聊聊消息统计
        Route::post('/community/countmessage','Api\Community\CommunityController@countmessage');
        //聊聊消息删除
        Route::post('/community/delmessage','Api\Community\CommunityController@delmessage');
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
        //余额app支付
        Route::post('/pay/moneypay','Api\Pay\PayController@moneypay');
		//微信app支付
        Route::post('/pay/wxapppay','Api\Pay\PayController@wxapppay');
        //支付宝app支付
        Route::post('/pay/aliapppay','Api\Pay\PayController@aliapppay');
        //余额app订单内支付
        Route::post('/pay/moneyorderpay','Api\Pay\PayController@moneyorderpay');
        //支付宝app订单内支付
        Route::post('/pay/aliapporderpay','Api\Pay\PayController@aliapporderpay');
        //微信app订单内支付
        Route::post('/pay/wxapporderpay','Api\Pay\PayController@wxapporderpay');

        /*
        *   广告模块
        */
        //商机首页广告
        Route::post('/advert/businessadvert','Api\Advert\AdvertController@businessadvert');
        //商机首页资讯
        Route::post('/advert/information','Api\Advert\AdvertController@information');
        //商城首页广告
        Route::post('/advert/goodsadvert','Api\Advert\AdvertController@goodsadvert');
        //促销模块
        Route::post('/advert/promotion','Api\Advert\AdvertController@promotion');
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
        //优惠券兑换
        Route::post('/purse/couponexchange','Api\Purse\PurseController@couponexchange');
        //优惠券兑换码兑换
        Route::post('/purse/cpexchange','Api\Purse\PurseController@cpexchange');
        //注册优惠券兑换码
        Route::post('/purse/regboot','Api\Purse\PurseController@regboot');
        //我的优惠券
        Route::post('/purse/mycoupon','Api\Purse\PurseController@mycoupon');
        //优惠券使用
        Route::post('/purse/usecoupon','Api\Purse\PurseController@usecoupon');
        //虫豆充值页面
        Route::post('/purse/beansrecharge','Api\Purse\PurseController@beansrecharge');
        //虫豆购买
        Route::post('/purse/buybeans','Api\Purse\PurseController@buybeans');
        //签到首页
        Route::post('/purse/signinindex','Api\Purse\PurseController@signinindex');
        //虫豆签到
        Route::post('/purse/signin','Api\Purse\PurseController@signin');
        //钱袋充值
        Route::post('/purse/recharge','Api\Purse\PurseController@recharge');
        //钱袋提现状态
        Route::post('/purse/withdrawstate','Api\Purse\PurseController@withdrawstate');
        //钱袋提现
        Route::post('/purse/withdraw','Api\Purse\PurseController@withdraw');
        //钱袋账单
        Route::post('/purse/bill','Api\Purse\PurseController@bill');
        //虫豆查看
        Route::post('/purse/beans','Api\Purse\PurseController@beans');
        //账单详情
        Route::post('/purse/billinfo','Api\Purse\PurseController@billinfo');
        //删除账单
        Route::post('/purse/delbill','Api\Purse\PurseController@delbill');


        /*
        *   直播模块
        */
        //判断是否有直播
        Route::post('/live/isliving','Api\Live\LiveController@isliving');
        //生成直播
        Route::post('/live/createlive','Api\Live\LiveController@createlive');
        //生成直播间头像
        Route::post('/live/livepic','Api\Live\LiveController@livepic');
        //生成网易云信聊天室
        Route::post('/live/createroom','Api\Live\LiveController@createroom');
        //结束直播
        Route::post('/live/endlive','Api\Live\LiveController@endlive');
        //直播保存
        Route::post('/live/savelive','Api\Live\LiveController@savelive');
        //直播列表
        Route::post('/live/livelist','Api\Live\LiveController@livelist');
        //重播列表
        Route::post('/live/relivelist','Api\Live\LiveController@relivelist');
        //直播搜索
        Route::post('/live/livesearch','Api\Live\LiveController@livesearch');
        //主播搜索
        Route::post('/live/anchorsearch','Api\Live\LiveController@anchorsearch');
        //重播搜索
        Route::post('/live/relivesearch','Api\Live\LiveController@relivesearch');
        //个人重播列表
        Route::post('/live/mylivelist','Api\Live\LiveController@mylivelist');
        //直播礼物
        Route::post('/live/livegift','Api\Live\LiveController@livegift');
        //重播删除
        Route::post('/live/dellive','Api\Live\LiveController@dellive');
        //网易云信状态改变
        Route::post('/live/livestate','Api\Live\LiveController@livestate');

    });
});


//支付宝路由
Route::group(['domain' => 'pay.anchong.net'], function () {
    //安虫自营路由组
    Route::group(['middleware'=>'PayAuthen'],function(){
        Route::post('/pay/mobilenotify','Api\Pay\PayController@mobilenotify');
    });

    //支付宝支付
    Route::any('/pay/alipay','Api\Pay\PayController@alipay');
    //支付后异步回调
    Route::any('/pay/webnotify','Api\Pay\PayController@webnotify');
    //微信支付
    Route::any('/pay/wxpay','Api\Pay\PayController@wxpay');
    //微信支付回调
    Route::any('/pay/wxnotify','Api\Pay\PayController@wxnotify');
});
//聚合向安虫推送订单及物流状态信息的对外地址
Route::group(['domain'=>'courier.anchong.net'],function(){
    Route::post('/order','admin\orderController@ostatus');
    Route::post('/logis','admin\orderController@lstatus');
    Route::any('/osscall','Home\Info\InfoController@osscall');
});
//后台路由
Route::group(['domain' => 'admin.anchong.net','middleware'=>'defper'], function () {
        //商品搜索
        Route::controller('/search','Api\SearchController');
        //支付宝
        //Route::get('/pay/alipay','Api\Pay\PayController@alipay');
        //登录提交
        Route::post('/checklogin',['uses'=>'admin\indexController@checklogin']);
        //加中间件的路由组
        Route::group(['middleware' => 'LoginAuthen'], function () {
                //首页路由
            Route::get('/','admin\indexController@index');

            //安虫自营路由组
            Route::group(['middleware'=>'anchong'],function(){
                //直播管理路由
                Route::resource('/live','admin\LiveController');
                //用户路由
                Route::controller('/user','admin\userController');
                //优惠券路由
                Route::resource('/coupon','admin\couponController');
                //商铺路由
                Route::controller('/shop','admin\shopController');
                //商铺物流公司管理
                Route::resource('/logis','admin\logisController');
                //标签管理路由
                Route::resource('/tag','admin\tagController');
                //分类标签管理路由
                Route::resource('/catag','admin\caTagController');
                //商品分类管理路由
                Route::resource('/goodcate','admin\goodCateController');
                //商品品牌管理路由
                Route::resource('/goodbrand','admin\brandController');
                //钱袋管理路由
                Route::resource('/purse','admin\PurseController');
                //签到管理路由
                Route::resource('/signin','admin\SigninController');
                //虫豆管理路由
                Route::resource('/beans','admin\BeansController');
                //公告管理路由
                Route::resource('/notice','admin\NoticeController');
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
                //社区所有聊聊
                Route::get('/releases','admin\releaseController@releases');
                //所有商机
                Route::get('/businesss','admin\businessController@businesss');
                //后台促销
                Route::resource('/promotion','admin\PromotionController');
                //开始促销
                Route::get('/startpromotion/{num}','admin\PromotionController@promotion');
                //结束促销
                Route::get('/endpromotion/{num}','admin\PromotionController@endpromotion');
                //结束促销
                Route::resource('/promotioninfo','admin\PromotioninfoController');
            });
                //后台登出
            Route::get('/logout','admin\indexController@logout');
            //订单管理路由
            Route::controller('/order','admin\orderController');
            //获取订单详情的路由
            Route::get('/orderinfo','admin\orderinfoController@orderdetail');
            //获取优惠券信息
            Route::get('/getacpinfo','admin\couponController@couponinfo');

            //获取所有物流
            Route::get('/getlogis','admin\logisController@getAll');
            //获取所有商机标签路由
            Route::get('/getag','admin\tagController@geTag');
            //由分类得标签
            Route::get('/getcatag','admin\caTagController@getagByCat');

            //获取商品一级或二级分类路由
            Route::get('/getlevel','admin\goodCateController@getsubLevel');
            //获取商品所有二级分类路由
            Route::get('/getlevel2','admin\goodCateController@getLevel2');
            //获取同一个一级分类下的所有二级分类的路由
            Route::get('/getSib','admin\goodCateController@getSiblings');

            //货品管理路由
            Route::resource('/good','admin\goodController');
            //商品管理路由
            Route::resource('/commodity','admin\commodityController');
            //得oem由goods_id
            Route::get('/oem','admin\commodityController@oem');
            //获取同一分类下的商品的路由
            Route::get('/getcommodity','admin\commodityController@getBycat');
            //获取商品关键字
            Route::get('/getKeywords','admin\commodityController@getKeywords');
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
            //干货操作
            Route::controller('/upfile','admin\upfileController');
            //后台推送
            Route::resource('/propel','admin\Propel\PropelController');

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

Route::group(['domain' => 'www.anchong.net','middleware'=>['csrf']], function () {
            Route::controller('/search','Api\SearchController');
            //订单内支付宝支付
            Route::post('/pay/aliweborderpay', 'Api\Pay\PayController@aliweborderpay');
            //订单内微信支付
            Route::post('/pay/wxweborderpay', 'Api\Pay\PayController@wxweborderpay');
            Route::resource('/user/register', 'Home\User\RegController');
            Route::post('/user/sharelogin', 'Home\User\LoginController@sharelogin');
            Route::get('/user/logout', 'Home\User\LoginController@logout');
            Route::resource('/user/login', 'Home\User\LoginController');
            Route::get('/quit', 'Home\User\LoginController@quit');
            //手机短信
            Route::post('/user/smsauth', 'Home\User\RegController@smsauth');
            //前台重置密码
            Route::resource('/user/forgetpwd', 'Home\User\ForgetpwdController');

            //购物车分享功能
            Route::resource('/cartshare', 'Home\Cart\CartShareController');
            //获取商品参数html代码
            Route::get('/getparam', 'admin\uEditorController@getParam');
            Route::get('/getpackage', 'admin\uEditorController@getPackage');
            //获取虫虫资讯
            Route::get('/information/{infor_id}', 'Api\Advert\AdvertController@informations');
            //首页
            Route::get('/', 'Home\IndexController@index');
            //商机主页
            Route::get('/business', 'Home\Business\BusinessController@index');
            //商机下属人才板块
            Route::resource('/talent', 'Home\Talent\TalentController');
            //商机下属工程板块
            Route::resource('/project', 'Home\project\ProjectController');
            //商机下属找货板块
            Route::resource('/sergoods', 'Home\Findgoods\FindgoodsController');
            //页码跳转
            Route::controller('/gopage', 'PageController');
            //人才服务，区域管理
            Route::controller('/server', 'Home\Talent\ServerController');
            //工程服务，区域管理
            Route::controller('/serproject', 'Home\project\SerproController');
            // 个人中心部分路由
            Route::group(['namespace' => 'Home\Pcenter','middleware'=>['loginhome']], function () {
                //个人中心
                Route::controller('/pcenter', 'IndexController');
                // 服务消息
                Route::get('/servermsg', 'IndexController@servermsg');
                //地址管理
                Route::resource('/adress', 'AddressController');
                //申请商铺
                Route::get('/applysp', 'IndexController@applysp');
                //申请商铺提交
                Route::post('/applysp/store', 'IndexController@apstore');
                //会员认证提交
                Route::any('/honor/store', 'IndexController@quas');
                //会员认证
                Route::get('/honor', 'IndexController@honor');
                //上传头像
                Route::get('/uphead', 'IndexController@uphead');
                //人才自荐
                Route::get('/mypublish', 'PublishController@publish');
                //我发布的人才
                Route::get('/pubtalent', 'PublishController@pubtalent');
                //发包工程
                Route::get('/conwork', 'PublishController@work');
                //个人订单
                Route::resource('/order','OrderController');
                //承接工程
                Route::get('/continuepro', 'PublishController@continu');
                //我的找货
                Route::get('/fngoods', 'PublishController@myfgoods');
                //个人中心收藏
                //商品
                Route::get('/colgoods', 'CollectionController@colgoods');
                //商铺
                Route::get('/colshop', 'CollectionController@colshop');
                //社区
                Route::get('/colcommunity', 'CollectionController@colcommunity');
            });

            //购物车
            Route::resource('/cart','Home\Cart\CartController');
            Route::group(['namespace' => 'Home\Cart','middleware'=>['loginhome']], function () {
                    //订单确认
                    Route::resource('/cartconfirm','ConfirmationController');
            });

            //设备选购
            Route::controller('/equipment', 'Home\Equipment\EquipmentController');
            //资讯干货
            Route::resource('info', 'Home\Info\InfoController');
            Route::get('/getphp', 'Home\Info\InfoController@getphp');
            Route::get('/getpic', 'Home\Info\InfoController@picaction');
            //社区
            Route::group(['namespace' => 'Home\Community'], function () {
                 //社区
                 Route::resource('/community', 'CommunityController');
                 //回复评论
                 Route::post('/replay',"CommunityController@replay");
                 //闲聊
                 Route::get('/talk', 'CommunityController@talk');
                 //问问
                 Route::get('/question', 'CommunityController@question');
                 //活动
                 Route::get('/activity', 'CommunityController@activity');
                 //聊聊操作
                 Route::resource('/chat','ChatController');
            });
            Route::resource('/collect','Home\Collect\CollectController');
});
 //验证码类,需要传入数字
 Route::get('/captcha/{num}', 'CaptchaController@captcha');
