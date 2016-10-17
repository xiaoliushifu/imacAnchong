/**
 * Created by lengxue on 2016/4/27.
 */
$(function(){
	
	var GlobalObj=[];
	/**
	 * '打印订单'按钮
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
        //为html赋值
        $("#ordertime").text('订单日期:'+$(this).attr("data-time"));
        $("#ordernum").text('订单编号:  '+$(this).attr("data-num"));
        $("#ordersname").text('商铺名称:'+$(this).attr("data-sname"));
        $("#ordername").text('收货人:'+$(this).attr("data-name"));
        $("#orderphone").text('联系方式:'+$(this).attr("data-phone"));
        $("#orderaddress").text('配送地址:'+$(this).attr("data-address"));
        $("#ordertname").text('客户名称:'+$(this).attr("data-tname"));
        //判断是否有发票
        if($(this).attr("data-invoice")){
            //根据#进行发票信息的分隔
            var invoice=$(this).attr("data-invoice").split("#");
            //判断是否分隔成功
            if(invoice[1] == undefined){
                $('#orderinvoice').text("发票抬头:"+invoice[0]);
            }else{
                $('#orderinvoiceinfo').text("发票信息:"+invoice[0]);
                $('#orderinvoice').text("发票抬头:"+invoice[1]);
            }
        }
        //判断是否有优惠券
        if($(this).attr("data-acpid")){
            //优惠券
            var acpid=$(this).attr("data-acpid");
            //优惠券查询
            $.get("/getacpinfo",{acpid:acpid},function(data,status){
                if(data[0].title){
                    acpl='<tr><td width="25%" colspan="2" align="left" valign="middle">优惠券类型：'+data[0].title+'</td><td width="25%" colspan="5" align="left" valign="middle">优惠价格：'+data[0].cvalue+'</td></tr>';
                    console.log($("#mbody").children().children().last().after(acpl));
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
        $("#cbody").empty();
        var dl='';
        var num=$(this).attr("data-num");
        var id=$(this).attr("data-id");
        //两个按钮准备好
        $("#pass").attr("data-id",id).attr("data-num",num);
        $("#fail").attr("data-id",id).attr("data-num",num);
        //由订单号获得订单详情数据
        if (!GlobalObj[id]) {
	        	$.get("/orderinfo",{num:num},function(data,status){
	        		GlobalObj[id]=data;//Cache
	            for(var i=0;i<data.length;i++){
	                dl+='<dl class="dl-horizontal"> <dt>订单编号</dt> <dd>'+data[i].order_num+'</dd> <dt>商品名称</dt> <dd>'+data[i].goods_name+'</dd> <dt>规格型号</dt> <dd>'+data[i].goods_type+'</dd> <dt>商品数量</dt> <dd>'+data[i].goods_num+'</dd> <dt>商品价格</dt> <dd>'+data[i].goods_price+'</dd></dl>';
	            }
	            $("#cbody").append(dl);
	        });
        } else {
        		data=GlobalObj[id];
        		for(var i=0;i<data.length;i++){
                dl+='<dl class="dl-horizontal"> <dt>订单编号</dt> <dd>'+data[i].order_num+'</dd> <dt>商品名称</dt> <dd>'+data[i].goods_name+'</dd> <dt>规格型号</dt> <dd>'+data[i].goods_type+'</dd> <dt>商品数量</dt> <dd>'+data[i].goods_num+'</dd> <dt>商品价格</dt> <dd>'+data[i].goods_price+'</dd></dl>';
            }
        		$("#cbody").append(dl);
        }
    });
    /**
     * 统一'通过|不通过'按钮
     */
    $('.modal-footer').on('click','button',function(){
	    	if(confirm("确定"+$(this).text()+"审核吗？")){
	    		//订单ID和订单编号
	        var id=$(this).attr("data-id");
	        var num=$(this).attr("data-num");
	    		var pdata={'oid':id,'num':num,'isPass':$(this).attr('id')};
	    		$.post('/checkorder',pdata,function(data,status){
	                console.log(data);
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
    
    //点击'发货'按钮，弹出发货方式选择页
    $(".shipbtn").click(function(){
        $("#orderid").val($(this).attr("data-id"));
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
    
  //点击'查看物流状态'按钮，弹出发货方式选择页
    $(".status").click(function(){
    		//显示物流信息
    		var onum = $(this).attr("data-num");
        $("#cancelO").attr('data-num',onum);
        $("#cancelO").attr('data-id',$(this).attr("data-id"));
        $("#ff").text(onum);
        $.post('/getStatus',{lnum:onum},function(data){
        	$('#wlstatus p').empty();
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
              url:'/ordership',
              success:function(data){
            	  	if (data) {
            	  		$('small').text(data);
            	  	} else {
            	  		location.reload();
            	  	}
              },
          });
      });
    
    /**
     * 弹框中，执行取消订单
     */
      $("#cancelO").click(function(){
          $.post('/ordercancel',{oid:$(this).attr("data-id"),onum:$(this).attr("data-num")},function(data){
                  //console.log(data);
                  location.reload();
              });
      });
});
