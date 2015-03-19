/*
console.log();
*/
function echo(string){
	console.log(string);
}
////////////////////////////////////////////////////////////////////////
/*****************************************
 *	Global variables
 *****************************************/
var url, index=0, total, interval, timeout, delay, blocked=false;
/*****************************************
 *	Functions
 *****************************************/
	$.fn.valignfunc=function(pos){
		pos=pos||'relative';
		var parent=($(this).parent('body').length)?$(window):$(this).parent();
		var pHeight=parent.height();
		var marg=(pHeight-$(this).outerHeight(true))/2;
		$(this).css({
			position: pos,
			'top': marg
		});
		return $(this);
	}
	$.fn.halignfunc=function(pos){
		pos=pos||'relative';
		var parent=($(this).parent('body').length)?$(window):$(this).parent();
		var pWidth=parent.width();
		var marg=(pWidth-$(this).outerWidth(true))/2;
		$(this).css({
			position: pos,
			'left': marg
		});
		return $(this);
	}
	$.fn.exists = function(){
		return $(this).length;
	}
	function getImgBg(){
		//echo(index);
		var imgbg=$('.gallerymain img').eq(index);
		var imgtext;
		if($('.centertext').eq(index).data('id')!='empty')
			imgtext=$('.centertext').eq(index).html();
		else imgtext=false;
		
		//echo($('.gallerymain img'));

		var imgbgsrc=imgbg.attr('src');
		var imgbgid=imgbg.data('id');
		$('#slideshow').fadeOut(function(){
			$('#slideshow').css('background-image', 'url('+imgbgsrc+')');
			(imgtext)?$('#centertext').show():$('#centertext').hide();
			$('#centertext span').html(imgtext);
			$('#slideshow').fadeIn();
		});
	}
	function setImg(link){
		var img=$('#imgPopup img');
		var width = link.data('width');
		var height = link.data('height');
		var pwidth = $('#imgPopup').width();
		var pheight = $('#imgPopup').height();
		//echo(img.attr('src'));
		
		$('.carousel-indicators').empty();
		for(i=0; i<=total; i++){
			if(i==index) $('.carousel-indicators').append('<li class="active"></li>')
			else $('.carousel-indicators').append('<li></li>')
		}

		if(img.attr('src')){
			img.animate({
				top: -pheight
			}, function(){
				if(width/height > pwidth/pheight) img.attr('src', link.attr('href')).width('95%').height('auto');
				else img.attr('src', link.attr('href')).width('auto').height('85%');
				img.animate({
					top: pheight/2
				});
			});
		}
		else{
			if(width/height > pwidth/pheight) img.attr('src', link.attr('href')).width('95%').height('auto');
			else img.attr('src', link.attr('href')).width('auto').height('85%');
		}
		//$('#imgPopup img').valignfunc().halignfunc();
		//if(width/height > pwidth/pheight) $('#imgPopup').css('background-size', '95% auto');
		//else $('#imgPopup').css('background-size', 'auto 90%');
	}
	function carousel(target, dir){
		var num=target.children().length;
		var shift=target.children().width();
		
		if(dir=='next'){
			if(parseInt(target.css('left'))>-shift*(num-1))
				target.animate({
					left: '-='+shift,
				});
			else
				target.animate({
					left: '0',
				});
		}
		if(dir=='prev'){
			if(parseInt(target.css('left'))<0)
				target.animate({
					left: '+='+shift,
				});
			else
				target.animate({
					left: '-='+shift*(num-1),
				});
		}
	}
	function setTerms(){
		if($('#terms > div').length){
			var width=$('#terms').width();
			$('#terms').width($('#terms > div').length*width);
			$('#terms > div').width(width);
		}
		else $('.controlcar').hide();
	}
/*****************************************
 *	Event listeners
 *****************************************/
	$(document).on('click', '.fs', function(e){
		e=e||window.event;
		//e.preventDefault();
		var tar;
		try{
			tar=e.target;
		}catch(err){
			tar=e.srcElement;
		}
		clearInterval(interval);
		$('#mainmenu li span').removeClass('active');
		$(this).find('span').addClass('active');
		//$('#mainframe').load($(this).attr('href'));
	})
	$(document).on('click', '.getblog', function(e){
		e=e||window.event;
		e.preventDefault();
		if($(this).parents('.bloghead').length){
			$('.bloghead').removeClass('active');
			$(this).parents('.bloghead').addClass('active');
			$('#blogtext').load($(this).attr('href'), function(){
				//echo($(this));
				$(this).scrollTop(0);
			});
			return;
		}
		else if($(this).parents('.employee').length){
			$('#leftblock').load($(this).attr('href'), function(){
				//echo($(this));
			});
			return;
		}
		else if($(this).parents('.cert').length){
			$('#gallery').load($(this).attr('href'));
			return;
		}
		else{
			$($('#pagination').data('target')).load($(this).find('a').attr('href'), function(){
			});
		}
	})
	$(document).on('click', '.controlcar', function(e){
		e=e||window.event;
		e.preventDefault();
		e.stopImmediatePropagation();
		
		if($(this).hasClass('next')){
			carousel($($(this).data('target')), 'next');
		}
		if($(this).hasClass('prev')){
			carousel($($(this).data('target')), 'prev');
		}
	});
	$(document).on('click', '.control', function(e){
		e=e||window.event;
		e.preventDefault();
		e.stopImmediatePropagation();
		if($(this).hasClass('next')){
			if(index>=total) index=0;
			else index++;
			$(this).parents('#imgPopup').length ? setImg($('#gallery a').eq(index)) : getImgBg();
		}
		else if($(this).hasClass('prev')){
			if(index) index--;
			else index=total;
			$(this).parents('#imgPopup').length ? setImg($('#gallery a').eq(index)) : getImgBg();
		}
	});
	$(document).on('mouseout', '.control', function(e){
		var el=$(this).parents('#imgPopup').length; 
		interval=setInterval(function(){
			if(index>=total) index=0;
			else index++;
			el ? setImg($('#gallery a').eq(index)) : getImgBg();
		}, delay);
	});
	$(document).on('mouseover', '.control', function(e){
		clearInterval(interval);
	});
	$(document).on('click', '.imgPopupItem', function(e){
		e=e||window.event;
		e.stopImmediatePropagation();
		e.preventDefault();
		
		index=$(this).data('index')-1;
		total=$('.imgPopupItem').length-1;
		
		setImg($(this));
		$('#imgPopup').fadeIn(function(){
			interval=setInterval(function(){
				if(index>=total) index=0;
				else index++;
				setImg($('#gallery a').eq(index));
			}, delay);
		});
	});
	$(document).on('click', '#imgPopup', function(){
		$(this).fadeOut(function(){
			$('#imgPopup img').attr('src', '');
			clearInterval(interval);
		});
	});
	$(document).on('click', '.carousel-indicators li', function(e){
		e=e||window.event;
		e.stopImmediatePropagation();
		
		index=$(this).index()-1;
		$('.control.next').trigger('click');
	});
	$(document).on('click', '#checkout', function(e){
		e=e||window.event;
		//e.stopImmediatePropagation();
		$('#gallery').load($(this).data('target'));
	});
	$(document).on('submit', '.checkout', function(e){
		e=e||window.event;
		e.preventDefault();
		var error=false;
		var referFrom=($(this).hasClass('mensclub'))?'mensclub':'team';
		var name=$('#name').val();
		var email=$('#email').val();
		var text=$('#text').val();
		var phone='+38'+$('#phone').val().replace(/\(|\)|-|\s/g,'');
		
		if (!name.match(/^(([a-zа-я\.-]{1,30} ){0,2}[a-zа-я\.-]{1,30})$/i)){
			$('#name').parents('.input-group').addClass('has-error');
			error=true;
		}
		if (!email.match(/^[0-9a-zA-Z]+([0-9a-zA-Z]*[-._+])*[0-9a-zA-Z]+@[0-9a-zA-Z]+([-.][0-9a-zA-Z]+)*([0-9a-zA-Z]*[.])[a-zA-Z]{2,6}$/i)){
			$('#email').parents('.input-group').addClass('has-error');
			error=true;
		}
		if (!phone.match(/^\+38([0-9]){10}$/i)){
			$('#phone').parents('.input-group').addClass('has-error');
			error=true;
		}
		if (!text.match(/[\w\s-'"\.а-я]{4,}/ig)){
			$('#text').parents('.form-group').addClass('has-error');
			error=true;
		}
		
		if(!error){
			$(this).ajaxSubmit({
				dataType: 'json',
				clearForm: true,
				success: function(json){
					if(json.error){
						$('#gallery').html(json.view);
					}
					else{
						if(referFrom=='mensclub'){
							$('#orderok').fadeIn(function(){
								clearTimeout(timeout);
								timeout=setTimeout(function(){
									$('#orderok').fadeOut();
								}, 5000);
							});
						}
						else{
							$('#fedback').fadeIn(function(){
								clearTimeout(timeout);
								timeout=setTimeout(function(){
									$('#fedback').fadeOut();
								}, 5000);
							});
						}
					}
				},
			});
		}
	});
	$(document).on('focusin', "input[type='text']", function(e){
		$(this).parents('.input-group').removeClass('has-error');
	})
	$(document).on('focusin', "textarea", function(e){
		$(this).parents('.form-group').removeClass('has-error');
	})
	$(document).on('click', '#validerror, #orderok, #fedback', function(){
		$(this).fadeOut();
	});
	var resizeTimer;
	$(window).resize(function() {
		var code="setTerms()";
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(code, 250);
	});
	$(document).on('click', '.filter', function(e){
		e=e||window.event;
		e.preventDefault();
		var target=$($(this).data('target'));
		
		if($(this).hasClass('cert')){
			var arr={};
			arr['name']=$(this).html();
			arr['min']=$(this).data('min');
			arr['max']=$(this).data('max');
			target.load($(this).attr('href'), arr);
			return;
		}
		else{
			target.load($(this).attr('href'));
		}
	});
/*
*
*	AJAX load & errors
*
*/
	$(document).on('ajaxStart', function(){
		$('#loadanimation').show();
		$('#error').hide();
	});
	$(document).on('ajaxStop', function(){
		//echo('stop');
		$('#loadanimation').hide();
	});
	$(document).ajaxError(function(event, jqxhr, settings, thrownError){
		echo(event);
		echo(jqxhr.responseText);
		echo(settings);
		echo(thrownError);
	});
// document ready function
$(function(){

})