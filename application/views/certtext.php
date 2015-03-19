<div id="righthead" style="line-height: 1;">
	<span><?= $cert['name'];?></span><br>
	<span style="font-size: 1vw">Стоимость: <?= $cert['price'];?> грн.</span>
</div>
<div class="col-md-12" style="margin-top: 3%">
	<?php echo $cert['text'];?>
</div>
<img class="aboutimg" src="<?=base_url('img/cert.jpg') ?>" width="100%" height="auto">