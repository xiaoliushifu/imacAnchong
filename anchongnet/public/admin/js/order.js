/**
 * Created by lengxue on 2016/4/27.
 */
$(function(){

	var GlobalObj=[];
	/*
	*	改价按钮
	*/
	$(".edit").click(function(){
		$('#orderid').val($(this).attr('data-id'));
		$('#editordernum').text($(this).attr('data-num'));
		$('#editname').text($(this).attr('data-name'));
		$('#editphone').text($(this).attr('data-phone'));
		$('#editaddress').text($(this).attr('data-address'));
		$('#editprice').val($(this).attr('data-price'));
		$('#editfreight').val($(this).attr('data-freight'));
	});

	//为表单，绑定jquery插件，来应用js验证功能
    $('#editorderform').validate({
    		//绑定submit回调
    		submitHandler:function(){
    			//执行ajax提交
    			$("#editorderform").ajaxSubmit({
                type: 'post',
                success: function (data) {
                    if(data.ServerNo == 0){
                        alert(data);
                        location.reload();
                    }else{
                        alert(data);
                    }
                },
            })
            //阻止浏览器默认动作
            return false;
		},
		rules:{
			price:{
				required:true
			},
			freight:{
				 required:true
			 },
		},
		messages:{
			price:{
				 required:"价格不能为空",
			},
			freight:{
				required:"运费可以为0但不能为空",
			},
		}
	});

	/**
	 * '打印'按钮
	 */
    $(".view").click(function(){
         $(".orderinfos").empty();
         //为了打印让后面页面隐藏
         $("#pageindex").attr("class","hidden");
         $('.main-footer').attr("class","hidden");
        var num=$(this).attr("data-num");
        //价格
        var price=$(this).attr("data-price");
        //运费
        var freight=$(this).attr("data-freight");
        //总价
        var total_price=Number(freight)+Number(price);
        //订单货品详情html
        var dl;
        //运费总价htm
        var al;
        //标题
        var tl;
		//运费
		var iv="";
        //为html赋值
        $("#ordertime").text('订单日期:'+$(this).attr("data-time"));
        $("#ordernum").text('订单编号:  '+$(this).attr("data-num"));
        $("#ordersname").text('商铺名称:'+$(this).attr("data-sname"));
        $("#ordername").text('收货人:'+$(this).attr("data-name"));
        $("#orderphone").text('联系方式:'+$(this).attr("data-phone"));
        $("#orderaddress").text('配送地址:'+$(this).attr("data-address"));
        $("#ordertname").text('客户名称:'+$(this).attr("data-tname"));
        //判断是否有发票
        if($(this).attr("data-invoicetype") != 0){
            //根据#进行发票信息的分隔
            var invoice=$(this).attr("data-invoice").split("#");
			// for(var i=0;i<invoice.length;i++){
			// 	iv += invoice[i]+" ";
			// }
			if($(this).attr("data-invoicetype") == 1){
				$('#orderinvoiceinfo').text("发票抬头:"+invoice[0]);
				$('#orderinvoice').text("发票信息:"+invoice[1]);
			}else if ($(this).attr("data-invoicetype") == 2) {
				$('#orderinvoiceinfo').remove();
				$('#orderinvoice').remove();
				// $('#orderinvoice').text("发票信息:"+iv);
				// $('#orderinvoiceinfo').text("发票类型:增值发票");
				iv="<tr><td colspan='2'>发票类型:增值发票</td><td colspan='5'>发票抬头:"+invoice[0]+"</td></tr><tr><td colspan='2'>纳税人识别号:"+invoice[1]+"</td><td colspan='5'>地址与电话:"+invoice[2]+"</td></tr><tr><td colspan='2'>开户行及账号:"+invoice[3]+"</td><td colspan='5'>货物名称:"+invoice[4]+"</td></tr>";
				$("#mbody").append(iv);
			}
        }else{
			$('#orderinvoice').text("发票信息:");
			$('#orderinvoiceinfo').text("发票类型:无发票");
		}
        //判断是否有优惠券
        if($(this).attr("data-acpid")){
            //优惠券
            var acpid=$(this).attr("data-acpid");
            //优惠券查询
            $.get("/getacpinfo",{acpid:acpid},function(data,status){
                if(data[0].title){
                    acpl='<tr><td width="25%" colspan="2" align="left" valign="middle">优惠券类型：'+data[0].title+'</td><td width="25%" colspan="5" align="left" valign="middle">优惠价格：'+data[0].cvalue+'</td></tr>';
                    // console.log($("#mbody").children().children().last().after(acpl));
                }
            });
        }
        //ajax查询订单详细信息
        $.get("/orderinfo",{num:num},function(data,status){
            //订单总费用的html
            al='<tr class="orderinfoss"><td width="25%" colspan="2" align="left" valign="middle">运费：'+freight+'</td><td width="25%" colspan="5" align="left" valign="middle">总价：'+total_price+'</td></tr>';
            $("#mbody").append(al);
            // //定义类型
            //通过遍历数据在html上显示
            for(var i=0;i<data.length;i++){
                //截取商品的简要名称
                var gname=data[i].goods_name.split(" ");
                //显示商品的型号数组
                var goodsname=gname[0]+" "+(gname[1]?gname[1]:"")+" "+(gname[2]?gname[2]:"");
                //定义oem
                var oem=data[i].oem;
                if(oem == ""){
                    oem="无";
                }
                dl='<tr class="orderinfos"><td align="center" valign="middle">'+data[i].goods_numbering+'</td><td align="center" valign="middle">'+goodsname+'</td><td align="center" valign="middle">'+data[i].goods_type+'</td><td align="center" valign="middle">'+data[i].model+'</td><td align="center" valign="middle">'+oem+'</td><td align="center" valign="middle">'+data[i].goods_num+'</td><td align="center" valign="middle">'+data[i].goods_price+'</td></tr>';
                $("#mbody").prepend(dl);
            }
            //标题插入
            cl='<tr><th width="11%">序号</th><th width="27%">商品名称</th><th width="17%">规格</th><th width="10%">型号</th><th width="7%">OEM</th><th width="6%">数量</th><th width="12%">价格</th></tr>';
            $("#mbody").prepend(cl);
        });

    });
    /**
     * 点击 “审核”按钮，获得审核数据(订单详情)
     */
    $(".check").click(function(){
        $("#cdiv").empty();
		$("#ddiv").empty();
        var dl='';
		var cl='';
        var num=$(this).attr("data-num");
        var oid=$(this).attr("data-id");
        //两个按钮准备好
        $("#pass").attr("data-id",oid).attr("data-num",num);
        $("#fail").attr("data-id",oid).attr("data-num",num);
        $("#userid").val($(this).attr("data-u"));
        $("#prices").val($(this).attr("data-price"));
		//获取付款信息
		$.get('/order/paycode',{id:oid},function(data){
			 if(data){
				var paydata=data[0].split(":");
				//判断是什么支付
				switch(paydata[0])
				{
					case 'alipay':
						$("#paytype").val("alipay");
						cl+='<dl class="dl-horizontal"> <dt>支付方式</dt> <dd>支付宝支付</dd> <dt>交易单号</dt> <dd>'+paydata[1]+'</dd> <dt>退款地址</dt> <dd><a href="https://mbillexprod.alipay.com/enterprise/tradeOrder.htm" target="_blank">地址链接</a></dd> </dl>';
						$("#cdiv").append(cl);
					break;
					case 'wxpay':
						$("#paytype").val("wxpay");
						cl+='<dl class="dl-horizontal"> <dt>支付方式</dt> <dd>微信支付</dd> <dt>交易单号</dt> <dd>'+paydata[1]+'</dd> <dt>退款地址</dt> <dd><a href="https://pay.weixin.qq.com/index.php/core/trade/search_new" target="_blank">地址链接</a></dd> </dl>';
						$("#cdiv").append(cl);
					break;
					case 'moneypay':
						$("#paytype").val("moneypay");
						cl+='<dl class="dl-horizontal"> <dt>支付方式</dt> <dd>余额支付</dd> <dt>交易单号</dt> <dd>'+paydata[1]+'</dd> <dt>退款地址</dt> <dd>点击通过自动退款到余额</dd> </dl>';
						$("#cdiv").append(cl);
					break;
					default:
					break;
				}
			 }
		 });
        //由订单号获得订单详情数据
        if (!GlobalObj[oid]) {
	        	$.get("/orderinfo",{num:num},function(data,status){
	        		GlobalObj[oid]=data;//Cache
	            for(var i=0;i<data.length;i++){
	                dl+='<dl class="dl-horizontal"> <dt>订单编号</dt> <dd>'+data[i].order_num+'</dd> <dt>商品名称</dt> <dd>'+data[i].goods_name+'</dd> <dt>规格型号</dt> <dd>'+data[i].goods_type+'</dd> <dt>商品数量</dt> <dd>'+data[i].goods_num+'</dd> <dt>商品价格</dt> <dd>'+data[i].goods_price+'</dd> </dl>';
	            }
	            $("#ddiv").append(dl);
	        });
        } else {
        		data=GlobalObj[oid];
        		for(var i=0;i<data.length;i++){
                dl+='<dl class="dl-horizontal"> <dt>订单编号</dt> <dd>'+data[i].order_num+'</dd> <dt>商品名称</dt> <dd>'+data[i].goods_name+'</dd> <dt>规格型号</dt> <dd>'+data[i].goods_type+'</dd> <dt>商品数量</dt> <dd>'+data[i].goods_num+'</dd> <dt>商品价格</dt> <dd>'+data[i].goods_price+'</dd></dl>';
            }
        		$("#ddiv").append(dl);
        }
    });
    /**
     * 统一'通过|不通过'按钮
     */
    $('#myCheck').on('click','button',function(){
    		if (!$(this).is('.btn')) {
    			return;
    		}
	    	if(confirm("确定"+$(this).text()+"审核吗？")){
	    		//订单ID和订单编号
	        var id=$(this).attr("data-id");
	        var num=$(this).attr("data-num");
	    		var pdata={'oid':id,'num':num,'users_id':$("#userid").val(),'total_price':$("#prices").val(),'paytype':$("#paytype").val(),'isPass':$(this).attr('id')};
	    		$.post('/order/checkorder',pdata,function(data,status){
	                alert(data);
	                location.reload();
	         });
	    	};
    });

    /**
     * '别针'按钮
     */
    $("#viewclose").click(function(){
        location.reload();
    });

    /**
     * 点击'发货'按钮，弹出发货方式选择页
     */
    $(".shipbtn").click(function(){
    		//避免命名冲突 最好使用由上到下的方式获取元素
    		//$('#mySend input[name="orderid"]').val($(this).attr("data-id"));
    		$('#shiporderid').val($(this).attr("data-id"));
        $("#onum").val($(this).attr("data-num"));
        $("#wlist input:first").val($(this).attr("data-num"));
    });

    /**
     * 发货方式选择
     */
    $("input:radio[name='ship']").change(function (){
    			if ($(this).val() == 'wl') {
    				$("#logs").empty();
    		        $.get("/getlogis",function(data,status){
    		        		var opt='';
    		            for (var i=0;i<data.length;i++) {
    		                opt+='<option value='+data[i].num+'|'+data[i].name+'>'+data[i].name+'</option>';
    		            }
    		            $("#logs").append(opt);
		            $("#wlist").removeClass("hidden");
    		        });
    			} else {
    				$("#wlist").addClass("hidden");
    			}
    	});

  /**
   * 查看物流状态
   */
    $(".status").click(function(){
    		//显示物流信息
    		var onum = $(this).attr("data-num");
        $("#cancelO").attr('data-num',onum);
        $("#cancelO").attr('data-id',$(this).attr("data-id"));
        $("#ff").text(onum);
        $.post('/order/status',{lnum:onum},function(data){
        	$('#wlstatus p').empty();
        		//如果有状态信息的话
        		if (data) {
        			$('#wlstatus p:first').append(data['order']);
        			$('#wlstatus p:eq(1)').append(data['wl']);
        		}
        });
    });


    /**
     * 弹框中，点击'开始发货'按钮
     */
      $("#go").click(function(){
          $("#goform").ajaxSubmit({
              type:'post',
              url:'/order/ordership',
              success:function(data){
            	  console.log(data);
            	  //有内容说明有问题
            	  if (data) {
            	  		alert(data);
            	  	} else {
            	  		alert('发货成功');
            	  		$('#example1  button[data-id="'+$('#shiporderid').val()+'"].shipbtn').toggleClass('hidden');
            	  		$('#example1  button[data-id="'+$('#shiporderid').val()+'"].status').toggleClass('hidden');
            	  		$('#mySend').modal('hide');
            	  	}
              },
          });
      });

    /**
     * 弹框中，执行取消发货
     */
      $("#cancelO").click(function(){
    	  	  var tmp = $(this).attr("data-id");
          $.post('/order/ordercancel',{oid:tmp,onum:$(this).attr("data-num")},function(data){
		        	  console.log(data);
		        	  //有内容说明有问题
		      	  	if (data) {
		      	  		alert(data);
		      	  	} else {
		      	  		alert('撤单成功');
		      	  		$('#example1  button[data-id="'+tmp+'"].shipbtn').toggleClass('hidden');
		      	  		$('#example1  button[data-id="'+tmp+'"].status').toggleClass('hidden');
		      	  		$('#myStatus').modal('hide');
		      	  	}
              });
      });
});
