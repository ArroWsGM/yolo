<?php
	if(empty($portfolio)):
?>
	<div>
		<h3 class="text-center text-warning"><span>У Вас еще нет ни одной фотографии</span></h3>
	</div>
<?php
	else:
?>
<script>
	$(function(){
		$('#bloggallitems').load(url+'getBlogGalleryItems/portfolio/eployee_id/'+window.location.href.split("/").pop());
	})
</script>
<div id="bloggallitems">

</div>
<?php
	endif;
?>