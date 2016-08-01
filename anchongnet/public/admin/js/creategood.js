/**
 * Created by lengxue on 2016/4/20.
 */
$(function(){
    /*-------------------------------------------基本信息---------------------------------------------*/
    var opt;
    var one0=0;
    var defaultopt="<option value=''>请选择</option>";
    var nullopt="<option value=''>无数据，请重选上级分类</option>";
    $.get("/getlevel",{pid:one0},function(data,status){
        for(var i=0;i<data.length;i++){
            opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
            $("#mainselect").append(opt);
        }
    });

    $("#mainselect").change(function(){
        var val=$(this).val();
        $("#midselect").empty();
        $("#midselect").append(defaultopt);
        $("#name").empty();
        $("#name").append(defaultopt);
        if(val==""){

        }else{
            $.get("/getlevel",{pid:parseInt(val)},function(data,status){
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

    $("#midselect").change(function(){
        var val=$(this).val();
        var sid=$("#sid").val();
        $("#name").empty();
        $("#name").append(defaultopt);
        $("#checks").empty();
        $("#attrs").empty();
        $.get("/getsibilingscommodity",{pid:parseInt(val),sid:sid},function(data,status){
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
        $.get("/getsiblingstag",{cid:val},function(data,status){
            for(var i=0;i<data.length;i++){
                var lab='<label><input type="checkbox" name="tag[]" value='+data[i].tag+'>'+data[i].tag+'</label>&nbsp;&nbsp;&nbsp;';
                $("#checks").append(lab);
            }
        })
    });

    $("#name").change(function(){
        var val=$(this).val();
        var li;
		var optioner;
        var txt=$("#name option:selected").text();
        $("#attrs").empty();
        $("#commodityname").val(txt);
        $.get("/getsiblingsattr",{gid:parseInt(val)},function(data,status){
            for(var i=0;i<data.length;i++){
			    $("#selectforattr").attr("id","");
                li='<li> <label class="col-sm-2 control-label">'+data[i].name+'</label> <div class="col-sm-3"> <select class="form-control" name="attr[]" required id="selectforattr"> </select> </div> </li> <div class="clearfix"><br><br></div>';
                $("#attrs").append(li);
                var arr=data[i].value.split(" ");
                for(var j=0;j<arr.length;j++){
					optioner='<option value='+arr[j]+'>'+arr[j]+'</option>';
					$("#selectforattr").append(optioner);
                }
            }
        });
        //选择商品时，从goods表里获得商品的关键字和商品id，type字段为商品id
        $.get("/commodity/"+val,function(data,status){
            $("#keyword").val(data.keyword);
            $("#type").val(data.type);
        });
    });

    //增加一条仓储记录input框，因采购无权，暂无用
    $("body").on("click",'.addcuspro',function(){
        var len=$(".line").length;
        var line='<tr class="line"> <td> <input type="text" name="stock[location][]" class="form-control" required /> </td> <td> <input type="number" min="0" name="stock[num][]" class="form-control" required /> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
        $("#stock").append(line);
    });
    //删除一条仓储记录
    $("body").on("click",'.delcuspro',function(){
        var len=$(".line").length;
        if(len>1){
            $(this).parents(".line").remove();
        }
    });
});

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
    },
});
