/**
 * Created by lengxue on 2016/4/26.
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
});