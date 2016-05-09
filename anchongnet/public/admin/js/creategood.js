/**
 * Created by lengxue on 2016/4/20.
 */
$(function(){
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
        $("#backselect").empty();
        $("#backselect").append(defaultopt);
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
        $("#backselect").empty();
        $("#backselect").append(defaultopt);
        $.get("/getlevel3",{pid:parseInt(val)},function(data,status){
            if(data.length==0){
                $("#backselect").empty();
                $("#backselect").append(nullopt);
            }else{
                for(var i=0;i<data.length;i++){
                    opt="<option  value="+data[i].cid+">"+data[i].cat_name+"</option>";
                    $("#backselect").append(opt);
                }
            }
        });
    });

    $("body").on("change",'#backselect',function(){
        var val=$(this).val();
        $("#name").empty();
        var shopid=$("#sid").val();
        $.get("/getsibilingscommodity",{pid:parseInt(val),sid:shopid},function(data,status){
            if(data.length==0){
                $("#name").append(nullopt);
            }else{
                for(var i=0;i<data.length;i++){
                    opt="<option  value="+data[i].goods_id+">"+data[i].title+"</option>";
                    $("#name").append(opt);
                }
            }
        })
    });

    $("#sub").click(function(){
        var gname=$("#name").find("option:selected").text();
        $("#goodname").val(gname);
    });

    $("body").on("click",'.gallery',function(){
        $(this).siblings(".pic").click();
    });

    $("body").on("change",'.pic',function(){
        var objUrl = getObjectURL(this.files[0]) ;
        console.log("objUrl = "+objUrl) ;
        if (objUrl) {
            $(this).siblings(".gallery").find(".img").attr("src",objUrl);
            if($(this).parents("li").hasClass("first")){
            }else{
                $(this).siblings(".gallery").before('<button type="button" class="delpic btn btn-xs btn-danger" title="删除">x</button>');
            }
        }
    });

    $("body").on("click",'.delpic',function(){
        $(this).parent().remove();
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

    $(".addpic").click(function(){
        if($(this).hasClass("goodpic")){
            var len=$(this).parentsUntil(".gal").find("li").length;
            if(len<6){
                $(this).before($(this).siblings(".template").clone().attr("class",""));
            }else{
                alert("最多只能添加五张图片！");
            }
        }else{
            $(this).before($(this).siblings(".template").clone().attr("class",""));
        }
    });


    $("body").on("click",'.addcuspro',function(){
        var len=$(".line").length;
        var line='<tr class="line"> <td> <input type="text" name="stock[region][]" class="form-control" required /> </td> <td> <input type="number" min="0" name="stock[num][]" class="form-control" required /> </td> <td> <button type="button" class="addcuspro btn-sm btn-link" title="添加"> <span class="glyphicon glyphicon-plus"></span> </button> <button type="button" class="delcuspro btn-sm btn-link" title="删除"> <span class="glyphicon glyphicon-minus"></span> </button> </td> </tr>';
        $("#stock").append(line);
    });

    $("body").on("click",'.delcuspro',function(){
        var len=$(".line").length;
        if(len>1){
            $(this).parents(".line").remove();
        }
    });
});
