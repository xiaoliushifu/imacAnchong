/**
 * Created by lengxue on 2016/4/19.
 */
$(function(){
    var defaultopt="<option value='0'>无</option>";
    $("#par0").append(defaultopt);
    var opt;
    var one0=0;
    $.get("/getlevel",{pid:one0},function(data,status){
        for(var i=0;i<data.length;i++){
            opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
            $("#par0").append(opt);
        }
    });
});