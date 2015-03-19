<script>
	$(function(){
		delay=5000;
	})
</script>
<div class="row imgportrow" style="padding: 0; margin: 0;">
<?php //var_dump($portfolio);
	$path=base_url().$this->Page_model->getConParam('img_base_path').$this->Page_model->getConParam('img_employee_path');
	$i=1;
	foreach($portfolio as $item):
?>
		<div class="col-md-15 imgcont imgport" style="height: 100%; padding: 0; background-image: url(<?=$path.$id.'/'.$item['thumb']?>);">
			<a class="imgPopupItem" data-width="<?=$item['width']?>" data-height="<?=$item['height']?>" data-index="<?=$i?>" href="<?=$path.$id.'/'.$item['path']?>">&nbsp;</a>
		</div>
<?php
		if($i%5==0 && $i<25) echo '</div><div class="row imgportrow" style="padding: 0; margin: 0;">';
		$i++;
	endforeach;
?>
</div>
<?php
	if ($total>25):
?>
<div id="pagination" class="text-center" data-target="#gallery">
	<?php
		echo $this->pagination->create_links();
		$curr=$this->pagination->cur_page;
		$total=ceil ($this->pagination->total_rows/$this->pagination->per_page);
		echo "$curr/$total";
	?>
</div>
<?php
	endif;
?>