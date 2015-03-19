<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title ?></title>
	
<!--[if lt IE 9]>
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
	
	<link href="<?= base_url() ?>bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url() ?>css/style.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="<?= base_url() ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>js/jquery.form.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>js/main.js"></script>
	<script type="text/javascript">
		$(function(){
			url='<?= site_url('page') ?>'+'/';
			delay=5000;
			
			var loc, current;
			try{
				loc=location.href.match(/page\/\w+/)[0];
			} catch(err){
				loc=false;
			}
			echo($('#mainmenu div a'));
			echo(loc);
			$('#mainmenu div span').removeClass('activemi');
			$('#mainmenu div a').each(function(){
				var li=$(this).parents('.menuitem');
				if (!loc){
					echo(li);
					li.find('span').addClass('activemi');
					return false;
				}
				current=$(this).attr('href').match(/page\/\w+/)[0];
				if(current==loc && !li.hasClass('logo')) li.find('span').addClass('activemi');
			});
			/*
			*/
		})
		
	</script>

</head>

<body>
	<header>
	<nav role="navigation">
		<div class="container-fluid" style="height: 100%">
			<div id="mainmenu">

				<div class="text-center menuitem" style="width:8.4%"></div>
				<div class="text-center menuitem" style="width:8.4%"><a class="fs fsleft" href="<?php echo site_url('page/main');?>"><span>Главная</span></a></div>
				<div class="text-center menuitem" style="width:8.4%"><a class="fs fsleft" href="<?php echo site_url('page/team');?>"><span>Команда</span></a></div>
				<div class="text-center menuitem" style="width:8.4%"><a class="fs fsleft" href="<?php echo site_url('page/mensclub');?>"><span>Men's&nbsp;Club</span></a></div>
				<div class="text-center menuitem" style="width:8.4%"><a class="fs fsleft" href="<?php echo site_url('page/blog');?>"><span>Блог</span></a></div>

				<div class="menuitem" style="width:16%">
				  <a href="<?php echo site_url('page/main');?>">
					<img class="logo" alt="YOLO" src="<?php echo base_url('img/yolo-logo.png');?>">
				  </a>
				</div>

				<div class="text-center menuitem" style="width:10.5%"><a class="fs fsright" href="<?php echo site_url('page/cert');?>"><span>Сертификаты</span></a></div>
				<div class="text-center menuitem" style="width:10.5%"><a class="fs fsright" href="<?php echo site_url('page/partner');?>"><span>Сотрудничество</span></a></div>
				<div class="text-center menuitem" style="width:10.5%"><a class="fs fsright" href="<?php echo site_url('page/contacts');?>"><span>Контакты</span></a></div>
				<div class="text-center menuitem" style="width:10.5%">&nbsp;</div>

			</div>
		</div>
	</nav>
	</header>
	<div id="loadanimation"></div>
	<div id="orderok" style="display: none">
		<div class="text-center">
			<p>Заказ успешно отправлен и принят в обработку.</p>
			<p>Мы свяжемся с Вами для уточнения деталей в скором времени.</p>
			<button class="btn btn-yolo">Закрыть</button>
		</div>
	</div>
	<div id="fedback" style="display: none">
		<div class="text-center">
			<p>Спасибо за обращение.</p>
			<p>В ближайшее время наши сотрудники рассмотрят Ваш отзыв.</p>
			<button class="btn btn-yolo">Закрыть</button>
		</div>
	</div>
	<div id="imgPopup" class="gallery">
		<div class="control prev"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></div>
		<div class="control next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></div>
		<img>
		<ul class="carousel-indicators"></ul>
	</div>
	<div class="container-fluid content">
