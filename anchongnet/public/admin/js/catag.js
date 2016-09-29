/**
 * Created by lengxue on 2016/5/6.
 */
$(function(){
    /*
     * 页面初始化时候将一级分类加载进来
     * */
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

    /*
    * 页面初始化时候将二级分类加载进来
    * */
    $.get('/getlevel2',function(data,status){
        var cat=$("#waitforcat").val();
        for(var i=0;i<data.length;i++){
            if(data[i].cat_id==cat){
                opt='<option selected value='+data[i].cat_id+'>'+data[i].cat_name+'</option>';
            }else{
                opt='<option  value='+data[i].cat_id+'>'+data[i].cat_name+'</option>';
            }
            $("#cat").append(opt);
        }
    });

    /*
    * 标签编辑
    * */
    $(".edit").click(function(){
        var id=$(this).attr("data-id");
        var cid=$(this).attr("data-cid");
        $("#updateform").attr("action","/catag/"+id);
        $.get("/catag/"+id,function(data,status){
            $("#tag").val(data.tag);
            $("#catname").val(data.cat_name);
        });
        $.get("/getSib",{cid:cid},function(data,status){
            $("#midselect").empty();
            for(var i=0;i<data.length;i++){
                opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
                $("#midselect").append(opt);
            }
            $("#midselect option[value="+cid+"]").attr("selected",true);
            firstPid=data[0].parent_id;
            $("#mainselect option[value="+firstPid+"]").attr("selected",true);
        });
    });

    $("#mainselect").change(function(){
        var val=$(this).val();
        $("#midselect").empty();
        $("#midselect").append(defaultopt);
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
        var txt=$("#midselect option:selected").text();
        $("#catname").val(txt);
    });

    /*
    * 删除标签
    * */
    $(".del").click(function(){
        if(confirm("确定要删除该条标签吗？")){
            var o=$(this);
            var id=o.attr("data-id");
            $.ajax({
                url: '/catag/'+id,
                type:'DELETE',
                success:function(result){
                    alert(result);
                    o.parents('tr').remove();
                }
            });
        }
    });
});