<footer class="main-footer">
	<div class="pull-right hidden-xs">
		<b>Version</b> 1.0
	</div>
	<strong>Copyright &copy; 2016 <a href="http://www.anchong.net">安虫网</a>.</strong> All rights
	reserved.
</footer>
<script src="/admin/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script>
	$(function(){
		var activeFlag=$("#activeFlag").val();
		$(".active").removeClass("active");
		$("#"+activeFlag).addClass("active");
	})
</script>