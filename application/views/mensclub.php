<script>
$(function(){
	$('#gallery').load("<?=site_url('page/mensclubgallery')?>");
})
</script>
<div id="mainframe">
	<div>
		<div id="lefthead">
			<span>Мужской клуб</span>
		</div>
		<div id="leftbody">
			<div id="centertext" class="row-same-height">
				<div class="row-same-height col-md-height col-middle text-center">
					<p>Мужская фотосессия</p>
					<img src="<?=base_url('img/yolo-line.png')?>">
					<p>Профессиональная съемка</p>
					<button id="checkout" class="btn btn-yolo" data-target="<?=site_url('page/checkout')?>">Оформить заказ</button>
				</div>
			</div>			
		</div>
	</div>
	<div id="gallery">
	</div>
</div>