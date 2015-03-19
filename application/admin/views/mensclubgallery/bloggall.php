<?php
	if(empty($mensclubgallery)):
?>
	<div>
		<h3 class="text-center text-warning"><span>У Вас еще нет ни одной фотографии</span></h3>
	</div>
<?php
	else:
?>
<script>
	$(function(){
		$('#bloggallitems').load(url+'getBlogGalleryItems/mensclubgallery');
	})
</script>
<div id="bloggallitems">

</div>
<?php
	endif;
?>