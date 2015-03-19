<script>
// document ready function
$(function(){
	var loc=location.href.match(/admincontroller\/\w+/)[0], current;
	$('#mainmenu li').removeClass('active');
	$('#mainmenu li a').each(function(){
		current=$(this).attr('href').match(/admincontroller\/\w+/)[0];
		if(current==loc) $(this).parents('li').addClass('active');
	});
});
</script>

	<nav class="navbar navbar-default" role="navigation">
		<ul id="mainmenu" class="nav navbar-nav">
			<li><a href="<?php echo site_url('admincontroller/mainpage');?>">Главная</a></li>
			<li><a href="<?php echo site_url('admincontroller/team');?>">Команда</a></li>
			<li><a href="<?php echo site_url('admincontroller/mensclubgallery');?>">Men's Club</a></li>
			<li><a href="<?php echo site_url('admincontroller/blog/date');?>">Блог</a></li>
			<li><a href="<?php echo site_url('admincontroller/cert');?>">Сертификаты</a></li>
			<li><a href="<?php echo site_url('admincontroller/orders');?>">Заказы</a></li>
			<li><a href="<?php echo site_url('admincontroller/feedback');?>">Отзывы</a></li>
			<li><a href="<?php echo site_url('admincontroller/config');?>">Настройки</a></li>
		</ul>
	</nav>
<!--	<div class="test">
	</div>-->