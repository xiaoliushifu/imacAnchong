(function( factory ) {
	if ( typeof define === "function" && define.amd ) {
		define( ["jquery", "../jquery.validate"], factory );
	} else {
		factory( jQuery );
	}
}(function( $ ) {

/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: ZH (Chinese, 中文 (Zhōngwén), 汉语, 漢語)
 */
$.extend($.validator.messages, {
	required: "这是必填字段",
	remote: "请修正此字段",
	email: "请输入有效的电子邮件地址",
	url: "请输入有效的网址",
	date: "请输入有效的日期",
	dateISO: "请输入有效的日期 (YYYY-MM-DD)",
	number: "请输入有效的数字",
	digits: "只能输入数字",
	creditcard: "请输入有效的信用卡号码",
	equalTo: "你的输入不相同",
	extension: "请输入有效的后缀",
	maxlength: $.validator.format("最多可以输入 {0} 个字符"),
	minlength: $.validator.format("最少要输入 {0} 个字符"),
	rangelength: $.validator.format("请输入长度在 {0} 到 {1} 之间的字符串"),
	range: $.validator.format("请输入范围在 {0} 到 {1} 之间的数值"),
	max: $.validator.format("请输入不大于 {0} 的数值"),
	min: $.validator.format("请输入不小于 {0} 的数值")
});

/**
 * 自定义一条验证规则
 * $.validator.addMethod(param1,param2,param3)
 * param1是方法名
 * param3是提示信息
 * param2是一个函数，执行实际的规则验证（return false代表验证失败，true代表成功）
 * param2代表的函数，可以接收三个参数value,element,param
 * 本来验证规则应该单独写一个js文件中的，但是因为本项目只扩展了一条验证规则，故为省事就写到了本文件里
 * 这里param2函数里没有第三个参数，则默认是boolean，所以调用时，nochinese:true即可，nochinese不行。
 */
$.validator.addMethod("nochinese", function(value,element) {
		return this.optional(element) || !/[\u4e00-\u9fa5]/g.test(value);
	}, '不能使用中文');


/**
 * 实例
 */
/*$.validator.addMethod("byteRangeLength", function(value, element, param) {
	var length = value.length;
	for(var i = 0; i < value.length; i++){
		//一般认为是中文的头一个字节，需要了解gbk编码的知识
		if(value.charCodeAt(i) > 127){
			length++;
		}
	}
	//optional函数，是validate.js中的工具方法，是一个非空的判定
	return this.optional(element) || ( length >= param[0] && length <= param[1] );
	}, '请确保输入的值在3-15个字节之间(一个中文字算2个字节)')*/
}));