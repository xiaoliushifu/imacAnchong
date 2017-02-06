<?php
return [

	// 安全检验码，以数字和字母组成的32位字符。
	'key' => 'z7kxat401dg5y2skoo87o1iz0nozoo30',

	//签名方式
	'sign_type' => 'MD5',

	// 服务器异步通知页面路径。
	'notify_url' => 'http://pay.anchong.net/pay/webreturn',

	// 页面跳转同步通知页面路径。
	'return_url' => 'http://pay.anchong.net/pay/webnotify',
];
