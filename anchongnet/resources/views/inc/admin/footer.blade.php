<footer class="main-footer">
	<div class="pull-right hidden-xs">
		<b>Version</b> 1.0
	</div>
	<strong>Copyright &copy; 2016 <a href="http://www.anchong.net">安虫网</a>.</strong> All rights
	reserved.
</footer>
{{--浏览器判定，只为兼容IE8--}}
<?php  
if (strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 8.0')) {
    echo '<script src="/admin/plugins/jquery1/1.9.1/jquery.js"></script>';
} else {
    echo '<script src="/admin/plugins/jQuery/jQuery-2.2.0.min.js"></script>';
}
?>
<script>
	$(function(){
		var activeFlag=$("#activeFlag").val();
		$(".active").removeClass("active");
		$("#"+activeFlag).addClass("active");
	})
</script>
