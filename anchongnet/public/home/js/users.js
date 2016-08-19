$(function(){
    //当点击验证码的时候
    $("#authnumbutton").click(function(){
        //获得填的电话号码
        var phone=$('#sign_in_name').val();
        var time=30;
        //判断是否是格式正确的电话
        if(phone.length == 11 && phone.substr(0,1) == "1"){
            // $.ajaxSetup({
            //     //默认添加请求头
            //     headers: {
            //        "X-CSRF-TOKEN": $('[name="_token"]').val(),
            //    } ,
            // });
            //假如成功就请求短信接口
            $.ajax({
                url: '/user/smsauth',
                //添加csrf请求头
                beforeSend: function (xhr) {
                    var token = $('[name="_token"]').val();
                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data:{phone:phone,action:1},
                type:'post',
                success:function(result){
                    alert(result);
                    $("#authnumbutton").attr("disabled","true");
                    $("#authnumfont").text(time+"s");
                }
            });
            //计时器方式刷验证码
            var t=setInterval(function(){
                if(time == 0){
                    clearTimeout(t);
                    $("#authnumbutton").removeAttr("disabled");
                    $("#authnumfont").text("获取验证码");
                    return;
                }
                time=time-1;
                $("#authnumfont").text(time+"s");
            },1000);
        }else{
            //假如失败就提示
            alert('请填写正确的手机号！');
        }


    });

    //当点击验证码的时候
    $("#resetpwd").click(function(){
        //获得填的电话号码
        var phone=$('#sign_in_name').val();
        var time=30;
        //判断是否是格式正确的电话
        if(phone.length == 11 && phone.substr(0,1) == "1"){
            $.ajaxSetup({
                //默认添加请求头
                headers: {
                   "X-CSRF-TOKEN": $('[name="_token"]').val(),
               } ,
            });
            //假如成功就请求短信接口
            $.ajax({
                url: '/user/smsauth',
                data:{phone:phone,action:2},
                type:'post',
                success:function(result){
                    alert(result);
                    $("#resetpwd").attr("disabled","true");
                    $("#resetpwdfont").text(time+"s");
                }
            });
            //计时器方式刷验证码
            var t=setInterval(function(){
                if(time == 0){
                    clearTimeout(t);
                    $("#resetpwd").removeAttr("disabled");
                    $("#resetpwdfont").text("获取验证码");
                    return;
                }
                time=time-1;
                $("#resetpwdfont").text(time+"s");
            },1000);
        }else{
            //假如失败就提示
            alert('请填写正确的手机号！');
        }
    });
});
