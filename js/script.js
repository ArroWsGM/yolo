/*
console.log();
*/
function echo(string){
	console.log(string);
}
////////////////////////////////////////////////////////////////////////
var url, tinyHeight, show=false, color;
var pathGall, index, tlength; // for delete function
var allowedimg='jpg|jpeg|png';
function tinyShortInit(selector, height){
	selector = (selector) ? '#'+selector : '';
	height = height || 100;
	tinymce.init({
		selector: "textarea"+selector,
		browser_spellcheck: true,
		width: '100%',
		height: height,
		resize: "vertical",
		language: 'uk',
		relative_urls: false,
		//document_base_url: "http://www.site.com/path1/"
		//menubar : false,
		plugins: [
			"link paste charmap charcount",
			//"autoresize",
			"code preview visualchars searchreplace"
		],
		//autoresize_min_height: 300,
		//autoresize_max_height: 400,
		toolbar: [
			//"undo redo | cut copy paste pastetext | bold italic underline strikethrough | fontsizeselect | alignleft aligncenter alignright | visualchars preview"
		],
		setup : function(ed){
			ed.on('init', function(){
				this.getDoc().body.style.fontSize = '14px';
			});
		},
        plugin_preview_width: '800',
        plugin_preview_height : "600"
	});
}
function tinyInit(){
	//tinymce.execCommand('mceRemoveControl', true, 'textarea');
	tinymce.init({
		selector: "textarea",
		browser_spellcheck: true,
		width: '100%',
		height: tinyHeight,
		resize: "vertical",
		language: 'uk',
		relative_urls: false,
		//document_base_url: "http://www.site.com/path1/"
		//menubar : false,
		plugins: [
			"link image paste textcolor charmap",
			//"autoresize",
			"table code preview visualchars searchreplace"
		],
		//autoresize_min_height: 300,
		//autoresize_max_height: 400,
		toolbar: [
			"newdocument | undo redo | cut copy paste pastetext | link image | styleselect | bold italic underline strikethrough | fontsizeselect | forecolor backcolor | alignleft aligncenter alignright alignjustify | charmap",
			"bullist numlist | table | visualchars code preview"
		],
		setup : function(ed){
			ed.on('init', function(){
				this.getDoc().body.style.fontSize = '14px';
			});
		},
        plugin_preview_width: '800', //This do the trick
        plugin_preview_height : "600"
	});
}
$(document).on('click', '#showform', function(e){
	e=e||window.event;
	e.preventDefault();
	var tar, height, cont;
	try{
		tar=e.target;
	}catch(err){
		tar=e.srcElement;
	}
	id=$(tar).attr('href');
	$(id).toggle();
	//echo(document.documentElement.scrollHeight);
	cont=$('#bloggall')[0]||document.documentElement;
	height=cont.scrollHeight;
	$('#bloggall').scrollTop(height);
});
function loadGallery(table, view){
	var tname=(table) ? table.replace(/\/.+/, '') : '';
	var path = (table) ? 'getBlogGallery/false/'+tname+'/false/false/'+view : 'getBlogGallery';
	if(!table){
		$('#bloggall').load(url+path, function(){
			//echo(tinyHeight);
			tinyInit();
			loadGalleryItems();
		});
	}
	else{
	echo(url+path);
	echo(table);
		$('#bloggall').load(url+path, function(){
			loadGalleryItems(table);
		});
	}
	
}
function loadGalleryItems(table){
	//echo(table);
	var path = (table) ? 'getBlogGalleryItems/'+table : 'getBlogGalleryItems';
	$('#bloggallitems').load(url+path);
}

function loadTeamSpec(urlloc, data){
	urlloc=urlloc||url+'teamspec';
	data=data||null;
	//echo(urlloc);
	//echo(data);
	$('#modalSpec').load(urlloc, data);
}

function changePage(id, text){
	$.ajax({
        type: "POST",
        url: url+'changePage/'+id,
        data: {'text': text},
		dataType : "text",
        success: function(text) {
            $('#pageid_'+id+' td textarea').val(text);
        },
		error: function(xhr, status, errorThrown) {
			alert("Произошла ошибка при передаче данных");
				console.log("Error: " + errorThrown);
				console.log("Status: " + status);
				console.dir(xhr);
		},
		complete: function() {
			echo( "The request is complete!" );
		}
    });
}
function setImg(link){
	var width = link.data('width');
	var height = link.data('height');
	var pwidth = $('#imgPopup').width();
	var pheight = $('#imgPopup').height();
	//echo($('.imgPopupItem').eq(index));
	$('#imgPopup').css({
		'background-image': 'url('+link.attr('href')+')',
		'background-repeat': 'no-repeat',
		'background-position': 'center',
	});
	if(width/height > pwidth/pheight) $('#imgPopup').css('background-size', '95% auto');
	else $('#imgPopup').css('background-size', 'auto 95%');
}
// document ready function
$(function(){
	$('#changeadmin').on('click', function(){
		if($(this).is(':checked')){
			$('#userdata input').each(function(){
				$(this).attr('disabled', false);
			});
		}
		else{
			$('#userdata input').each(function(){
				$(this).attr('disabled', true);
			});
		}
	})
	$('.delete').on('click', function(e){
		e=e||window.event;
		e.stopImmediatePropagation();
		var tar, href;
		try{
			tar=e.target;
		}catch(err){
			tar=e.srcElement;
		}
		var r = confirm("Вы уверены?");
		if (r == true) {
			return;
		} else {
			e.preventDefault();
		}
		//href=$(tar).parents('tr').attr('href');
	})
	$('.change').on('click', function(e){
		e=e||window.event;
		e.preventDefault();
		var tar, id, text;
		try{
			tar=e.target;
		}catch(err){
			tar=e.srcElement;
		}
		id=$(tar).parents('tr').attr('id').replace(/pageid_/, '');
		text=$(tar).parents('td').find('textarea').val();
		$('#pageid_'+id+' td textarea').val('');
		changePage(id, text);
	})
	$('#mcheck').on('click', function(){
		if($(this).is(':checked')){
			$('.mcheck').prop('checked', true);
		}
		else{
			$('.mcheck').prop('checked', false);
		}
	});
	$(document).on('click', '#checker', function(){
		var target=$(this).data('target');
		$(target).each(function(){
			$(this).prop('checked', !$(this).prop('checked'));
		});
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
/*
*
*	Gallery function
*
*/
	$(document).on('click', '.tinyInsert', function(e){
		e=e||window.event;
		e.preventDefault();
		var src=$(this).parents('td').find('img').attr('src');
		//echo(src);
		var alt=$(this).parents('td').find('img').attr('alt');
		var width=$(this).parents('td').find('.imgwidth')[0].innerText;
		var height=$(this).parents('td').find('.imgheight')[0].innerText;
		var img='<img src="'+src+'" alt="'+alt+'" width="'+width+'" height="'+height+'">';
		tinyMCE.execCommand('mceInsertContent', false, img);
	});
	$(document).on('click', '#error', function(e){
		$(this).hide();
		$('#bloggall').removeClass('.loading');
	})
	$(document).on('click', '.bloggalldelete', function(e){
		e=e||window.event;
		e.stopImmediatePropagation();
		e.preventDefault();
		var r = confirm("Вы уверены?");
		if (r == true) {
			//$('#loadanimation').show();
			var href=$(this).attr('href');
			var name=$(this).data('name');
			var table=$(this).data('table');
			var view=$(this).data('view');
			$(this).load(href, {'deleteFiles': path+name}, function(){
				loadGallery(table, view);
			});
		} else {
			return;
		}
	});
	$(document).on('submit', '#addimageform', function(e){
		e=e||window.event;
		e.stopImmediatePropagation();
		e.preventDefault();
		$('#blogimgerror').hide();
		//echo($(this).find('input'));
		if(!$('#blogimg').val()){
			$('#blogimgerror').show();
			return;
		}
		
		var progress = $('.progress');
		var bar = $('.bar');
		var percent = $('.percent');
		var table = $(this).data('table');
		var view = $(this).data('view');
   
		$(this).ajaxSubmit({
			//url: '<?= site_url('admincontroller/getBlogGallery/true') ?>', // point to server-side PHP script 
			dataType: 'json',
			clearForm: true,
			beforeSend: function(){
				progress.show();
				var percentVal = '0%';
				bar.width(percentVal)
				percent.html(percentVal);
			},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%';
				bar.width(percentVal)
				percent.html(percentVal);
				//console.log(percentVal, position, total);
			},
			success: function() {
				progress.hide();
				var percentVal = '100%';
				bar.width(percentVal)
				percent.html(percentVal);
				loadGallery(table, view);
			},
			error: function(json){
				echo(json);
				obj=jQuery.parseJSON(json.responseText)
				var message='<div id="errorMessage">'+obj.message+'</div>';
				$('#errorMessage').replaceWith(message);
				$('#error').show().delay(10000).fadeOut();
			},
		});
	});
/*
*
*	Team
*
*/
	$(document).on('mouseenter', '.highlight', function(){
		color=$(this).css('background-color');
		$(this).css('background-color', '#B2B2FF');
	})
	.on('mouseleave', '.highlight', function(){
		$(this).css('background-color', color);
	});
	$(document).on('click', '.teamspec', function(e){
		e=e||window.event;
		e.stopImmediatePropagation();
		e.preventDefault();
		//echo(input);
		try{
			tinymce.remove(input);
		}catch(error){
			echo(error);
		}
		var array = {};
		var input = $(this).data('id');
		if (input=='multi'){
			var field = $(this).data('field');
			$(field).each(function(){
				array[$(this).attr('name')] = $(this).val();
			});
			//return
		}
		else{
			var field = $(this).data('field');
			array[field] = $(input).val();
		}
		//echo ($(this).attr('href'));
		//echo(array);
		loadTeamSpec($(this).attr('href'), array);
		//$(body).prepend('<div class="modal-backdrop"></div>');
	});
	$(document).on('submit', '#addSpec', function(e){
		e=e||window.event;
		e.stopImmediatePropagation();
		e.preventDefault();
		var error=false;
		$('.error').hide();
		
		//echo($('#specname').length);
		//echo($('#cfname').length);
		//return;
		if($('#specname').length){
			if(!$('#specname').val()){
				$('#addSpecerror').show();
				return;
			}
		}
		if($('#cfname').length){
			if(!$('#cfname').val()){
				$('#addNameerror').show();
				error=true;
			}
			if(!$('#cfname').val()){
				$('#addMinerror').show();
				error=true;
			}
			if (error) return;
		}
		var locurl = $(this).data('url');
		
		$(this).ajaxSubmit({
			clearForm: true,
			success: function() {
				if (locurl) loadTeamSpec(locurl);
				else loadTeamSpec();
			},
		});
	});
	$(document).on('click', '#modalSpecPopupBut', function(){
		$('#modalSpec').load(url+'teamspec');
	})
	$(document).on('click', '.carousel-indicators li', function(e){
		e=e||window.event;
		e.stopImmediatePropagation();
		
		index=$(this).index()-1;
		$('.control.next').trigger('click');
	});
	$(document).on('click', '.imgPopupItem', function(e){
		e=e||window.event;
		e.stopImmediatePropagation();
		e.preventDefault();
		
		index=$(this).data('index')-1;
		tlength=$('.imgPopupItem').length;
		
		$('.carousel-indicators').empty();
		
		setImg($(this));
		for(i=0; i<tlength; i++){
			if(i==index) $('.carousel-indicators').append('<li class="active"></li>')
			else $('.carousel-indicators').append('<li></li>')
		}
		$('#imgPopup').fadeIn();
	});
	$(document).on('click', '#imgPopup', function(){
		$(this).fadeOut();
	});
	$(document).on('click', '.control', function(e){
		e=e||window.event;
		e.stopImmediatePropagation();
		e.preventDefault();
			if($(this).hasClass('next')){
				index++;
				if(index==tlength) index=0;
				setImg($('.imgPopupItem').eq(index));
				$('.carousel-indicators li').removeClass('active').eq(index).addClass('active');
			}
			else if($(this).hasClass('prev')){
				index--;
				if(index<0) index=tlength-1;
				setImg($('.imgPopupItem').eq(index));
				$('.carousel-indicators li').removeClass('active').eq(index).addClass('active');
			}
	});
/**********************
 *	orders & feedback
 **********************/
	$(document).on('blur', '.ordernotes', function(){
		var table=($(this).data('table'));
		var id=($(this).data('id'));
		$(this).load(url+'changenotes/'+table+'/'+id, {notes: $(this).val()});
	});
	$(document).on('change', '.orderstatus', function(){
		var statusid=($(this).val());
		var target=$(this).find('option:selected').data('target');
		var color=$(this).find('option:selected').data('color');
		var id=target.replace('#pageid_', '');
		$(target).load(url+'changestatus/order/'+id+'/'+statusid, function(){
			$(target).css('background-color', color);
		});
	});
})