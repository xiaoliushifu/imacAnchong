/**
 * Created by lengxue on 2016/4/26.
 */

//二级分类信息 catarr[1]=[[56,'智能']]
//二级分类信息 catsibs[56]里是二级56的信息
var catarr=[[], [], [], [], [], [], [], [], [], []];
var catsibs=[];
var Level1='';
var Level2='';
$(function(){

    //加载一级分类
    var one0=0;
    $.get("/getlevel",{pid:one0},function(data,status){
        for(var i=0;i<data.length;i++){
          var  opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
            $(".mainselect").append(opt);
        }
    });


    /**
     * 商品编辑
     */
    $(".edit").click(function() {
        $("#stock").empty();//库存部分
        $("#sups").empty();	//配套商品部分
        $("#futuresups").empty();//配套商品输入框

        var o = $(this);
        var tr = o.parents('tr');
        var id = o.attr("data-id");
        var sid=$("#sid").val();

        $("#gid").val(o.attr("data-id"));

        $("#updataForm").attr("action", "/commodity/" + id);
        //组织当前商品的分类信息
        var arr=$.trim(tr.children(':eq(8)').text()).split(/\s/);
        $("#catarea").empty();
        //从模板克隆一套分类信息
        var cat=$(".catemplate").clone(true).removeClass("hidden").removeClass("catemplate");
        $("#title").val(tr.children(':eq(1)').text());
        $("#description").val(tr.children(':eq(2)').text());
        $("#remark").text(tr.children(':eq(3)').text());
        $("#keyword").val(tr.children(':eq(4)').text());
        $("#img").attr("src",tr.children(':eq(5)').text());
        UE.getEditor('container').setContent(tr.children(':eq(6)').text());
        UE.getEditor('container1').setContent(tr.children(':eq(7)').text());

        //获取商品的配套商品
        $.get("/getsupcom",{"gid":id,'sid':sid},function(data,status){
            var sup;
            for(var i=0;i<data.length;i++){
                sup='<li class="list-group-item">'+data[i].goods_name+'<button type="button" data-id='+data[i].supid+' class="delsup btn btn-warning btn-xs pull-right glyphicon glyphicon-minus" title="删除条配套信息"></button></li>';
                $("#sups").append(sup);
            }
        });
        /*----获取商品属性信息，只读，暂不可编辑----*/
        $.get('/getsiblingsattr', {gid: id}, function (data, status) {
            for (var i = 0; i < data.length; i++) {
                var line = '<tr class="line"> <td> <input type="text" class="attrname form-control" value="' + data[i].name + '" /> </td> <td><textarea rows="3" class="attrvalue form-control">' + data[i].value + '</textarea> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="savestock btn-sm btn-link" data-id="' + data[i].atid + '" title="保存"> <span class="glyphicon glyphicon-save"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除" data-id="' + data[i].atid + '"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
                $("#stock").append(line);
            }
        });
        /*----OEM部分----*/
        $("#oem").val('');
        $.get('/oem', {gid : id}, function (data) {
        			if (data.length) {
        				$("#oem").val(data[0].value);
        			}
        });

        //获取二级分类信息，因为该商品有可能属于多个分类，故循环
        for (var f=0; f<arr.length; f++) {
	        	tmpcat = cat.clone(true);
	        	$("#catarea").append(tmpcat);
	            //如果凑巧这个二级分类信息已经有了
	        	Level2 = hex2bin(arr[f]);
	        	if(!catsibs[Level2]) {
	        		//不存在时只得跑一趟了
		            $.ajax({
		            	url:'/getSib?a='+Math.random(),
		            	data:{cid:Level2},
		            	async:false,//同步(只有获得分类信息后，才能处理接下来的数据)
		            	success:function(data){
		            		Level1 = data[0].parent_id;
		            		for(var i in data){
		            			catsibs[data[i].cat_id] = data[i];
		            			catarr[Level1].push([data[i].cat_id,data[i].cat_name]);
		            		}
		            	},
		        });
	        	}
	        	Level1 = catsibs[Level2].parent_id;
	        	var opt;
            for (var j = 0; j < (catarr[Level1]).length; j++) {
                opt += "<option  value='" + catarr[Level1][j][0] + "'>" + catarr[Level1][j][1] + "</option>";
            }
            $('#catarea .midselect:eq('+f+')').append(opt);
          //设置选中项
            $('#catarea .mainselect:eq('+f+') option[value="'+Level1+'"]').attr("selected",true);
            $('#catarea .midselect:eq('+f+') option[value="'+Level2+'"]').attr("selected",true);

        }
    });

    	/**
    	 * 商品删除
    	 */
    	$(".del").click(function(){
    		 if(confirm("确定要删除该商品，删除该商品会把相关的货品也一并删除？")){
    			 var o = $(this);
    			 $.ajax({
    	                url: "/commodity/404",
    	                type: 'DELETE',
    	                data:{npx:o.attr('data-id')},
    	                success: function(result) {
    	                    alert(result);
    	                    if( result.indexOf('成功') != -1){
    	                    		o.parents('tr').remove();
    	                    }
    	                }
    	            });
    		 }
    	});


    /*----添加一组分类----*/
    $("body").on("click",".add button",function(){
    		/*分类信息不可更改*/
		console.log('分类信息不可更改');
		return false;
		/*分类信息不可更改*/
        var tem=$(".catemplate").clone().removeClass("hidden").removeClass("catemplate");
        $("#catarea").append(tem);
    });

    /*----删除分类----*/
    $("body").on("click",".minus button",function(){
    		/*分类信息不可更改*/
    		console.log('分类信息不可更改');
    		return false;
    		/*分类信息不可更改*/

        var len=$("#catarea").find(".form-group").length;
        if(len==1){
            alert("不能删除仅有的分类信息！");
        }else{
            $(this).parentsUntil("#catarea").remove();
        }
    });

  //设计实现：商品编辑时，使得商品的分类信息不可更改。
    $('#catarea').on('change','select',function(){
    		console.log('商品分类信息不可更改');
    		$(this).val($(this).find('option[selected="selected"]').val());
    		return false;
    });
    /**注释，使得商品分类不可修改**/
//    var nullopt="<option value=''>无数据，请重选上级分类</option>";
//    var defaultopt="<option value=''>请选择</option>";
//    $("body").on("change",".mainselect",function(){
//        var val=$(this).val();
//        $(".waitforopt").removeClass("waitforopt");
//        $(this).parent().siblings("div").find(".midselect").empty().addClass("waitforopt");
//        $(this).parent().siblings("div").find(".midselect").append(defaultopt);
//        if(val==""){
//        	return;
//        }else{
//            $.get("/getlevel",{pid:parseInt(val)},function(data,status){
//                if(data.length==0){
//                    $(".waitforopt").find(".midselect").empty();
//                    $(".waitforopt").append(nullopt);
//                }else{
//                    for(var i=0;i<data.length;i++){
//                        opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
//                        $(".waitforopt").append(opt);
//                    }
//                }
//            });
//        }
//    });
    
    //添加一组配套商品输入框
    $(".addsup").click(function(){
        var suptem=$(".suptemp").clone().removeClass("hidden").removeClass("suptemp");
        $("#futuresups").append(suptem);
    });

    /**编辑框，配套商品部分
     * 一级分类时的change事件
     * **/
    var nullopt="<option value=''>无数据，请重选上级分类</option>";
    var defaultopt="<option value=''>请选择</option>";
    $("#futuresups").on("change",".mainselect",function(){
        var val=$(this).val();
        $(".waitforopt").removeClass("waitforopt");
        $(this).parent().siblings("div").find(".midselect").empty().addClass("waitforopt");
        $(this).parent().siblings("div").find(".midselect").append(defaultopt);
        if(val==""){
        	return;
        }else{
            $.get("/getlevel",{pid:parseInt(val)},function(data,status){
                if(data.length==0){
                    $(".waitforopt").find(".midselect").empty();
                    $(".waitforopt").append(nullopt);
                }else{
                    for(var i=0;i<data.length;i++){
                        opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
                        $(".waitforopt").append(opt);
                    }
                }
            });
        }
    });
    
    
    //保存配套信息
    $("body").on("click",".save",function(){
    		//检测配套商品id
        var currobj=$(this).parentsUntil(".form-group");
        var goodsid=currobj.find(".supname").val();
        if (goodsid=="") {
            alert("请选择商品");
            return;
        } else {
            var agid=$("#gid").val();
            var goodname=currobj.find(".goodsname").val();//商品名
            var gid=currobj.find(".gid").val();//货品id
            var title=currobj.find(".title").val();//货品title
            var price=currobj.find(".price").val();//货品市场价
            var img=currobj.find(".img").val();//货品图
            $.post("/goodsupporting",{"goodsid":goodsid,"goodsname":goodname,"gid":gid,"title":title,"price":price,"img":img,"agid":agid},function(data,status){
                alert(data.message);
                //里面显示
                var sup='<li class="list-group-item">'+data.name+'<button type="button" data-id='+data.id+' class="delsup btn btn-warning btn-xs pull-right glyphicon glyphicon-minus" title="删除条配套信息"></button></li>';
                $("#sups").append(sup);
            })
        }
    });

    //删除一条配套信息输入框
    $("body").on("click",".delone",function(){
        $(this).parents(".form-group").remove();
    });
    /*----删除一条配套信息----*/
    $("body").on("click",".delsup",function(){
        if(confirm("确定要删除该条配套信息吗？")){
            $(this).parent().addClass("waitfordel");
            var id=$(this).attr("data-id");
            $.ajax({
                url: "/goodsupporting/" + id,
                type: 'DELETE',
                success: function (result) {
                    alert(result);
                    $(".waitfordel").remove();
                }
            });
        }
    });

    //配套商品部分，选择二级分类时获取对应的分类下的商品
    $("body").on("change",".midforsup",function(){
        var val=$(this).val();
        var sid=$("#sid").val();
        $("#checked").attr("id","");
        $(this).parentsUntil(".form-group").find(".supname").attr("id","checked");
        $(this).parentsUntil(".form-group").find(".supname").empty().append(defaultopt);
        $.get("/getcommodity",{pid:parseInt(val),sid:sid},function(data,status){
            if(data.length==0){
                $("#checked").empty();
                $("#checked").append(nullopt);
            }else{
                for(var i=0;i<data.length;i++){
                    opt="<option  value="+data[i].goods_id+">"+data[i].title+"</option>";
                    $("#checked").append(opt);
                }
            }
        });
    });

    //添加配套商品的时候获取选中商品的第一条货品
    $("body").on("change",".supname",function(){
        var txt=$(this).find("option:selected").text();
        $(this).siblings(".goodsname").val(txt);
        var val=$(this).val();
        $(this).siblings(".supval").empty();
        $(".waitforspe").removeClass("waitforspe");
        $(this).addClass("waitforspe");
        $.get('/getsiblingsgood',{'good':val},function(data,status){
            var spe;
            if(data.length==0){
                spe='<input type="hidden" name="gid" value=" " class="gid"><input type="hidden" name="title" value=" " class="title"><input type="hidden" name="price" value=" " class="price"><input type="hidden" name="img" value=" " class="img">';
            }else{
                spe='<input type="hidden" name="gid" value='+data[0].gid+' class="gid"><input type="hidden" name="title" value="'+data[0].title+'" class="title"><input type="hidden" name="price" value='+data[0].market_price+' class="price"><input type="hidden" name="img" value='+data[0].goods_img+' class="img">';
            }
            $(".waitforspe").siblings(".supval").append(spe);
        })
    });

    	/**
    	 * 添加一条商品属性输入框
    	 */
    $("body").on("click", '.addcuspro', function () {
        var len = $(".line").length;
        var line = '<tr class="line"> <td> <input type="text" class="attrname form-control" /> </td> <td><textarea rows="3" class="attrvalue form-control" required></textarea> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="savestock btn-sm btn-link" title="保存"> <span class="glyphicon glyphicon-save"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
        $("#stock").append(line);
    });

    	/**
    	 * 保存商品属性
    	 */
    $("body").on("click", '.savestock', function () {
        var aname = $(this).parentsUntil("#stock").find(".attrname").val();
        var avalue = $(this).parentsUntil("#stock").find(".attrvalue").val();
        if (aname == "") {
            alert("属性名不能为空！");
            $(this).parentsUntil("#stock").find(".attrname").focus();
        } else if (avalue == "") {
            alert("属性值不能为空！");
            $(this).parentsUntil("#stock").find(".attrvalue").focus();
        } else {
            var id = $(this).attr("data-id");
            var gid = $("#gid").val();
            $("#save").attr("id", "");
            $(this).attr("id", "save");
            $("#del").attr("id", "");
            $(this).siblings(".delcuspro").attr("id", "del");
            //添加属性
            if (id == undefined) {
                $.ajax({
                    url: "/attr",
                    type: 'POST',
                    data: {gid: gid, name: aname, value: avalue},
                    success: function (response) {
                        alert(response.message);
                        $("#save").attr("data-id", response.id);
                        $("#del").attr("data-id", response.id);
                    }
                });
            //修改属性
            } else {
                $.ajax({
                    url: "/attr/" + id,
                    type: 'PUT',
                    data: {gid: gid, name: aname, value: avalue},
                    success: function (response) {
                        alert(response.message);
                    }
                });
            }
        }
    });

    	/**
    	 * 删除商品属性
    	 */
    $("body").on("click", '.delcuspro', function () {
        if (confirm("你确定要删除该条属性信息吗？")) {
            var id = $(this).attr("data-id");
            //标记为waitfordel，使得删除方便。
            $(this).parents(".line").addClass("waitfordel");
            if (typeof id == "undefined") {
            		$(".waitfordel").remove();
            		return ;
            }
            //如果只是一个框子，则直接删除即可
            $.ajax({
                url: "/attr/" + id,
                type: 'DELETE',
                success: function (result) {
                    alert(result);
                    $(".waitfordel").remove();
                }
            });
        }
    });

    //建立一個可存取到該file的url
    function getObjectURL(file) {
        var url = null ;
        if (window.createObjectURL!=undefined) { // basic
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }

    /*----事件转移----*/
    $("body").on("click",'.gallery',function(){
        $(this).siblings(".pic").click();
    });

    /*----替换详情图片的操作----*/
    $("body").on("change",'.pic',function(){
        var gid=$("#gid").val();
        if(confirm('你确定要替换这张图片吗？')){
            var objUrl = getObjectURL(this.files[0]) ;
            if (objUrl) {
                $(".isEdit").removeClass("isEdit");
                $(this).siblings(".gallery").find(".img").addClass("isEdit");
                $("#formToUpdate").ajaxSubmit({
                    type:'post',
                    url:'/updataimg',
                    data:{gid:gid},
                    success:function(data){
                        alert(data.message);
                        if(data.isSuccess==true){
                            $(".isEdit").attr("src",objUrl);
                        }
                    }
                });
            }
        }
    });
});
