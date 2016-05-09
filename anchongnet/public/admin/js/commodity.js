/**
 * Created by lengxue on 2016/4/26.
 */
$(function(){
    //加载一级分类
    var opt;
    var one0=0;
    $.get("/getlevel",{pid:one0},function(data,status){
        for(var i=0;i<data.length;i++){
            opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
            $("#mainselect").append(opt);
        }
    });

    $(".edit").click(function(){
        $("#backselect").empty();
        $("#midselect").empty();
        var cid=$(this).attr("data-tid");
        var opt;
        var firstPid;
        var secondPid;
        $.get("/getsiblingslevel",{cid:cid},function(data,status){
            for(var i=0;i<data.length;i++){
                opt="<option  value="+data[i].cid+">"+data[i].cat_name+"</option>";
                $("#backselect").append(opt);
            }
            $("#backselect option[value="+cid+"]").attr("selected",true);
            firstPid=data[0].cat_id;
            secondPid=data[0].parent_id;

            $("#mainselect option[value="+firstPid+"]").attr("selected",true);

            $.get("/getlevel",{pid:firstPid},function(data,status){
                for(var j=0;j<data.length;j++){
                    opt="<option  value="+data[j].cat_id+">"+data[j].cat_name+"</option>";
                    $("#midselect").append(opt);
                }
                $("#midselect option[value="+secondPid+"]").attr("selected",true);
            });
        });

        var id=$(this).attr("data-id");
        $("#updataForm").attr("action","/commodity/"+id);
        $.get("/commodity/"+id+"/edit",function(data,status){
            $("#title").val(data.title);
            $("#description").val(data.desc);
        })
    })

    var nullopt="<option value=''>无数据，请重选上级分类</option>";
    $("body").on("change",'#mainselect',function(){
        var val=$(this).val();
        $("#midselect").empty();
        $("#backselect").empty();
        $.get("/getlevel",{pid:parseInt(val)},function(data,status){
            if(data.length==0){
                $("#midselect").append(nullopt);
            }else{
                for(var i=0;i<data.length;i++){
                    opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
                    $("#midselect").append(opt);
                }
            }
        });
    });

    $("body").on("change",'#midselect',function() {
        var val = $(this).val();
        $("#backselect").empty();
        $.get("/getlevel3", {pid: parseInt(val)}, function (data, status) {
            if (data.length == 0) {
                $("#backselect").append(nullopt);
            } else {
                for (var i = 0; i < data.length; i++) {
                    opt = "<option  value=" + data[i].cid + ">" + data[i].cat_name + "</option>";
                    $("#backselect").append(opt);
                }
            }
        })
    })
});
