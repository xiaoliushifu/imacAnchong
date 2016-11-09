/**
 * Created by lengxue on 2016/4/20.
 */
$(function(){
	
	var Level1;
	var Level2;
    /*-------------------------------------------基本信息---------------------------------------------*/
    var opt;
    var one0=0;
    var defaultopt="<option value=''>请选择</option>";
    var nullopt="<option value=''>无数据，请重选上级分类</option>";
//    $.get("/getlevel",{pid:one0},function(data,status){
//        for(var i=0;i<data.length;i++){
//            opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
//            $("#mainselect").append(opt);
//        }
//    });

    	/**
    	 * 顶级分类的change
    	 */
    $("#mainselect").change(function(){
        var val=$(this).val();
        Level1=val;
        //二级分类信息初始化
        $("#midselect").empty();
        $("#midselect").append(defaultopt);
        //商品名称初始化
        $("#name").empty();
        $("#name").append(defaultopt);
        if(val==""){
        		return ;
        }else{
            $.get("/getlevel",{pid:val},function(data,status){
                if(data.length==0){
                    $("#midselect").empty();
                    $("#midselect").append(nullopt);
                }else{
                    for(var i=0;i<data.length;i++){
                        opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
                        $("#midselect").append(opt);
                    }
                }
            });
        }
    });

    /**
     * 二级分类的选择
     */
    $("#midselect").change(function(){
        var val=$(this).val();
        Level2=val;
        var sid=$("#sid").val();
        //商品名初始化
        $("#name").empty();
        $("#name").append(defaultopt);
        //分类标签
        $("#checks").empty();
        //属性
        $("#attrs").empty();
        //获得有关该分类的所有商品
        $.get("/getcommodity",{pid:Level2,sid:sid},function(data,status){
            if(data.length==0){
                $("#name").empty();
                $("#name").append(nullopt);
            }else{
                 for(var i=0;i<data.length;i++){
                     opt="<option  value="+data[i].goods_id+">"+data[i].title+"</option>";
                     $("#name").append(opt);
                 }
            }
        });
        //获得有关该分类的标签
        $.get("/getcatag",{cid:val},function(data,status){
            for(var i=0;i<data.length;i++){
                var lab='<label><input type="checkbox" name="tag[]" value='+data[i].tag+'>'+data[i].tag+'</label>&nbsp;&nbsp;&nbsp;';
                $("#checks").append(lab);
            }
        })
    });

    /**
     * 商品的选择
     */
    $("#name").change(function(){
        var val=$(this).val();
        var li;
		var optioner;
        var txt=$("#name option:selected").text();
        $("#attrs").empty();
        $("#commodityname").val(txt);//商品名保存
        $.get("/getsiblingsattr",{gid:parseInt(val)},function(data,status){
            for(var i=0;i<data.length;i++){
			    $("#selectforattr").attr("id","");
                li='<li> <label class="col-sm-2 control-label">'+data[i].name+'</label> <div class="col-sm-3"> <select class="form-control" name="attr[]" required id="selectforattr"> </select> </div> </li> <div class="clearfix"><br><br></div>';
                $("#attrs").append(li);
                var arr=data[i].value.split(" ");
                for(var j=0;j<arr.length;j++){
                		if(arr[j]){
                			optioner='<option value='+arr[j]+'>'+arr[j]+'</option>';
                			$("#selectforattr").append(optioner);
                		}
                }
            }
        });
        //选择商品时，从goods表里获得商品的关键字和商品类型，商品描述。
        $.get("/commodity/"+val,function(data,status){
            $("#keyword").val(data.keyword);
            //注意，这里的商品分类，是重新从商品表里获得，所以录入一条货品时，
            //它的分类信息实际保存的是所属商品的所有分类，而不是页面显示的一个分类。
            $("#type").val(data.type);
            $("#desc").val(data.desc);
        });
    });

    /**
     * 增加一条仓储记录input框，因采购无权，暂无用
     */
    $("body").on("click",'.addcuspro',function(){
        var len=$(".line").length;
        var line='<tr class="line"> <td> <input type="text" name="stock[location][]" class="form-control" required /> </td> <td> <input type="number" min="0" name="stock[num][]" class="form-control" required /> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
        $("#stock").append(line);
    });
    /**
     * 删除一条仓储记录
     */
    $("body").on("click",'.delcuspro',function(){
        var len=$(".line").length;
        if(len>1){
            $(this).parents(".line").remove();
        }
    });
    
    
});
/**
 * 商品图片上传
 */
$('#test').diyUpload({
    url:'/thumb',
    success:function( data ) {
        console.info( data.message );
        var len=$("#img").find("li").length;
        var lis='<li> <input type="hidden" name="pic['+len+'][url]" value="'+data.url+'"> </li>';
        $("#img").append(lis);
    },
    error:function( err ) {
        console.info( err );
    }
});

/**
 * 表单验证部分
 */
$('body').on('submit','form',function(){
	//已经上传的货品图片的数量
	var len=$("#img").find("li").length;
	if (len < 1) {
		$('.gal i').addClass('text-danger');
		return false;
	}
});
