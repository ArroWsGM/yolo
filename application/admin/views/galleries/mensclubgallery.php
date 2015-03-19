<script>
$(function(){
	$('.pagination a').on('click', function(e){
		e=e||window.event;
		e.preventDefault();
		var urlloc=$(this).attr('href');
		$('#bloggallitems').load(urlloc);
	});
});
</script>
<?php
	//var_dump($count);
?>
	<div class="form-group row">
		<div class="col-sm-2 text-center">
			<button type="button" class="btn btn-default" disabled="disabled">Всего: <?php if (isset($count)) echo '<span class="badge">'.$count.'</span>'; ?></button>
		</div>
		<div class="col-sm-2 col-sm-offset-8 text-center">
			<button type="button" class="btn btn-primary" id="checker" data-target=".pcheck">Выбрать все</button>
		</div>
	</div>
<table class="table table-striped timg">
	<tr>
		<th class="col-md-15" style="height: 0px; padding: 0; margin: 0; border: 0;"></th>
		<th class="col-md-15" style="height: 0px; padding: 0; margin: 0; border: 0;"></th>
		<th class="col-md-15" style="height: 0px; padding: 0; margin: 0; border: 0;"></th>
		<th class="col-md-15" style="height: 0px; padding: 0; margin: 0; border: 0;"></th>
		<th class="col-md-15" style="height: 0px; padding: 0; margin: 0; border: 0;"></th>
	</tr>
	<tr>
<?php
		$path=base_url($this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_mansclub_path')).'/';
		$i=0;
		foreach ($mensclubgallery as $item):
			$i++;
?>
				<td class="col-md-15" id="blogimgid_<?php echo $item['id']?>">
					<div class="thumbnail portfolio">
						<input class="pcheck" form="delBatch" name="checkid_<?php echo $item['id']?>" type="checkbox" value="<?php echo $item['id']?>">
						<a class="imgPopupItem" data-width="<?= $item['width'] ?>" data-height="<?= $item['height'] ?>" data-index="<?= $i ?>" href="<?php echo $path.$item['path']?>"><img src="<?php echo $path.$item['thumb']?>" alt="<?php echo $item['alt']?>" width="100%" height="auto"></a>
						<div class="caption">
							<p class="text-center">
								<span class="imgwidth label label-default"><?php echo $item['width']?></span>
								<span>&times;</span>
								<span class="imgheight label label-default"><?php echo $item['height']?></span>
							</p>
							<p class="text-center">
								<a class="bloggalldelete btn btn-danger btn-xs" data-view="mensclubgallery" data-table="mensclubgallery" data-name="<?php echo $item['path']?>" href="<?= site_url("admincontroller/deletePage/mensclubgallery/{$item['id']}/true") ?>">Удалить</a>
							</p>
						</div>
					</div>
				</td>
<?php
			if($i%5==0) echo '</tr><tr>';
		endforeach;
?>
	</tr>
</table>
<?php
	$attributes = array('role' => 'form', 'id' => 'delBatch');
	echo form_open(site_url('admincontroller/deleteBatchMensClub'), $attributes);
?>
</form>
	<div class="form-group clearfix">
		<div class="col-sm-2  col-sm-offset-10 text-center">
			<input class="delete delPort btn btn-danger" form="delBatch" type="submit" value="Удалить выбранные" />
		</div>
	</div>
<?=$this->pagination->create_links();?>