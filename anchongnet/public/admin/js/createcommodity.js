/**
 * Created by lengxue on 2016/4/26.
 */
$(function(){
    var opt;
    var one0=0;
    var defaultopt="<option value=''>请选择</option>";
    var nullopt="<option value=''>无数据，请重选上级分类</option>";
    //开始时，为商品和配套商品 及他们各自的隐藏副本获得分类信息
    $.get("/getlevel",{pid:one0},function(data,status){
        for(var i=0;i<data.length;i++){
            opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
            $(".mainselect").append(opt);
        }
    });

    	//为一级分类信息，绑定事件，使其获得二级分类信息
    $("body").on("change",".mainselect",function(){
        var val=$(this).val();
        $(".waitforopt").removeClass("waitforopt");
        $(this).parent().siblings("div").find(".midselect").empty().addClass("waitforopt");
        $(this).parent().siblings("div").find(".name").empty();
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

    /*----添加一条分类，把隐藏域的副本，稍微调整即可得---*/
    
    $("body").on("click",".add button",function(){
        var tem=$(".catemplate").clone().removeClass("hidden").removeClass("catemplate");
        $("#catarea").append(tem);
    });

    /*----删除分类----*/
    $("body").on("click",".minus button",function(){
        var len=$("#catarea").children().length;
        if(len<1){
            alert("不能删除仅有的分类信息！");
        }else{
            $(this).parents(".form-group").remove();
        }
    });
    //属性添加
    $("body").on("click",'.addcuspro',function(){
        var len=$(".line").length;
        var line='<tr class="line"> <td> <input type="text" name="attrname[]" class="form-control" required /> </td> <td> <textarea name="attrvalue[]" class="form-control" required rows="5"></textarea> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
        $("#stock").append(line);
    });
    //属性删除
    $("body").on("click",'.delcuspro',function(){
        var len=$(".line").length;
        if(len>1){
            $(this).parents(".line").remove();
        }
    });

    //添加配套商品部分，选择二级分类时获取该分类下的商品
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

    //添加配套商品部分，选中商品时获取该商品的第一条货品
    $("body").on("change",".supname",function(){
        var txt=$(this).find("option:selected").text();
        //用隐藏域保存选中的配套商品名
        $(this).siblings(".goodsname").val(txt);
        var val=$(this).val();
        $(this).siblings(".supval").empty();
        $(".waitforspe").removeClass("waitforspe");
        $(this).addClass("waitforspe");
        //会获得所有货品数据，但是只显示第一条，有点浪费带宽了
        $.get('/getsiblingsgood',{'good':val},function(data,status){
            var spe;
            if(data.length==0){
            		//配套商品的货品即使为空，也得在数据库表中占用一条记录
                spe='<input type="hidden" name="gid[]" value=" "><input type="hidden" name="title[]" value=" "><input type="hidden" name="price[]" value=" "><input type="hidden" name="img[]" value=" ">';
            }else{
                spe='<input type="hidden" name="gid[]" value='+data[0].gid+'><input type="hidden" name="title[]" value="'+data[0].title+'"><input type="hidden" name="price[]" value='+data[0].market_price+'><input type="hidden" name="img[]" value='+data[0].goods_img+'>';
            }
            $(".waitforspe").siblings(".supval").append(spe);
        })
    });

    //添加配套商品输入框
    $("body").on("click",".addsup",function(){
        var suptem=$(".suptemp").clone().removeClass("hidden").removeClass("suptemp");
        $("#img").before(suptem);
    });

    //删除配套商品
    $("body").on("click",".minusup",function(){
        $(this).parents(".form-group").remove();
    });
    
    /**
	 * 表单验证部分
	 */
	$('body').on('submit','form',function(){
		//已经上传的商城详情图片的数量
		var len=$("#img").find("li").length;
		if (len < 1) {
			$('small:eq(0)').removeClass('hidden');
			return false;
		}
	});
});

/*商品详情图片添加*/
$('#detail').diyUpload({
    url:'/img',
    formData:{
        imgtype:1
    },
    success:function( data ) {
        console.info( data.message );
        var len=$("#img").find("li").length;
        if (len == 1) {
    			alert('只上传一张图片即可');
    			return;
        }
        var lis='<li> <input type="hidden" name="pic['+len+'][url]" value="'+data.url+'"> <input type="hidden" name="pic['+len+'][imgtype]" value="1"> </li>';
        $("#img").append(lis);
    },
    error:function( err ) {
        console.info( err );
    },
});
