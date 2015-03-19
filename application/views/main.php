<script>
$(function(){
	total=$('.gallerymain img').length-1;
	getImgBg();
	interval=setInterval(function(){
		if(index>=total) index=0;
		else index++;
		getImgBg();
	}, delay)
})
</script>
<?php
	$path=base_url().$this->Page_model->getConParam('img_base_path').$this->Page_model->getConParam('img_mainpage_path');
	//var_dump($path);
	//var_dump($total);
	//var_dump($mainpage);
?>
<div class="control prev"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></div>
<div class="control next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></div>
<div id="slideshow">
	<div id="centertext" class="row-same-height"><p class="row-same-height col-md-height col-middle"><span></span></p></div>
	<div class="gallerymain gallery">
<?php
	foreach($mainpage as $item):
?>
			<img src="<?php echo $path.$item['id'].'/'.$item['img_bg_name']?>" width="<?=$item['width']?>" height="<?=$item['height']?>" data-id="<?=$item['id']?>">
			<div class="centertext" data-id="<?=($item['text'])?$item['id']:'empty';?>"><?=$item['text']?></div>
<?php
	endforeach;
?>
	</div>
</div>