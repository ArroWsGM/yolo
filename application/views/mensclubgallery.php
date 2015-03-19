<script>
	$(function(){
		delay=5000;
	})
</script>
<div class="row" style="height: 33.3%; padding: 0; margin: 0;">
<?php
	$path=base_url().$this->Page_model->getConParam('img_base_path').$this->Page_model->getConParam('img_mansclub_path');
	$i=1;
	foreach($mсgallery as $item):
?>
		<div class="col-md-4 imgcont" style="height: 100%; padding: 0; background-image: url(<?=$path.$item['thumb']?>);">
			<a class="imgPopupItem" data-width="<?=$item['width']?>" data-height="<?=$item['height']?>" data-index="<?=$i?>" href="<?=$path.$item['path']?>">&nbsp;</a>
		</div>
<?php
		if($i%3==0) echo '</div><div class="row" style="height: 33.3%; padding: 0; margin: 0;">';
		$i++;
	endforeach;
?>
</div>

<div id="pagination" class="text-center" data-target="#gallery">
	<?php
		echo $this->pagination->create_links();
		$curr=$this->pagination->cur_page;
		$total=ceil ($this->pagination->total_rows/$this->pagination->per_page);
		echo "$curr/$total";
		//echo $this->pagination->next_tag_open.$this->pagination->next_link.$this->pagination->next_tag_close;
	?>
</div>