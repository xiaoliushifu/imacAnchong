/**
 * 这里定义了一些公用的js函数
 */

//自定义转码函数
	var hex2bin = function(data){
	    var data = (data || '') + '';
	    var tmpStr = '';
	    if (data.length % 2) {
	        console && console.log('hex2bin(): Hexadecimal input string must have an even length');
	        return false;
	    }
	    if (/[^\da-z]/ig.test(data)) {
	        console && console.log('hex2bin(): Input string must be hexadecimal string');
	        return false;
	    }
	    for (var i = 0, j = data.length; i < j; i += 2) {
	        tmpStr += '%' + data[i] + data[i + 1];
	    }
	    return decodeURIComponent(tmpStr);
	}
	//获取子分类
	var getsublevel = function (plevel){
		$.get("/getlevel",{pid:plevel},function(data,status){
			return data;
		});
	};
	//获取分类标签
	var getsiblevel = function (level){
	    	$.get("/getcatag",{cid:level},function(data,status){
	    		return data;
	    	});
	};