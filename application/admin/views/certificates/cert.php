<script>
$(function(){
	$(document).on('click', '#modalCFPopupBut', function(){
		$('#modalSpec').load(url+'certfilter');
	})
	$(document).on('change', '#certfilter', function(){
		//echo('<?= site_url("admincontroller/cert") ?>'+'/'+$(this).val());
		window.location='<?= site_url("admincontroller/cert") ?>'+'/'+$(this).val();
	})
})
</script>
<?php
if(isset($sesconfig)) echo '<p style="color: green;">Конфигурация успешно изменена</p>';
$path='/'.$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_certificates_path');
//var_dump($path);
?>
<!-- Широка модаль -->
<button type="button" class="btn btn-primary" id="modalCFPopupBut" data-toggle="modal" data-target="#modalSpecPopup">Фильтр цен</button>
<br>
<br>
<div class="modal fade bs-example-modal-lg" id="modalSpecPopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" id="modalSpec"></div>
</div>
<!-- Широка модаль -->
<?php
	if($total<1):
?>
	<div>
		<h3 class="text-center text-warning"><span>У Вас еще нет ни одного сертификата</span></h3>
		<p class="text-center"><a class="btn btn-primary" href="<?= site_url("admincontroller/certrecord/add") ?>">Добавить запись</a></p>
	</div>
<?php
	else:
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th class="col-lg-1" id="title">Photo</th>
			<th class="col-lg-6"><a href="<?= site_url("admincontroller/team/name") ?>">Name</a></th>
			<th class="col-lg-2">
				<select class="form-control" id="certfilter" name="certfilter">
						<option value="all" <?php if ($this->uri->segment(3)=='all' || $this->uri->segment(3)=='') echo 'selected="selected"'; ?>>Все</option>
						<?php if (count($certfilter)):
							foreach($certfilter as $val):?>
								<option value="<?php echo $val['id'] ?>" <?php if ($this->uri->segment(3)==$val['id']) echo 'selected="selected"'; ?>><?php echo $val['name'] ?></option>
						<?php endforeach;
							  endif;?>
				</select>
			</th>
			<th class="col-lg-1" id="checkbox" class="text-center"><button type="button" class="btn btn-primary btn-sm" id="checker" data-target=".mcheck">Выбрать все</button></th>
			<th class="col-lg-1" id="manage">Manage</th>
		</tr>
	</thead>
	<tbody class="cert">
<?php
		foreach ($certificates as $item):
?>
			<tr id="pageid_<?php echo $item['id']?>">
				<td class="col-lg-1">
					<?php if (!empty($item['photo'])):?>
						<img src="<?php echo base_url($path.$item['id'].'/'.$item['photo'].'?'.random_string('alnum', 4));?>" width="100%" height="auto">
					<?php else:?>
						<img src="<?=base_url('img/nophoto.jpg') ?>" width="100%" height="auto">
					<?php endif;?>
				</td>
				<td class="col-lg-6"><?php echo $item['name']?></td>
				<td class="col-lg-2"><?php echo $item['price'] ?></td>
				<td class="col-lg-1 text-center"><input class="mcheck" form="delBatch" name="checkid_<?php echo $item['id']?>" type="checkbox" value="<?php echo $item['id']?>"></td>
				<td class="col-lg-1 tmiddle">
					<p class="text-center"><a class="btn btn-primary" href="<?= site_url("admincontroller/certrecord/add") ?>">Добавить запись</a></p>
					<p class="text-center"><a class="btn btn-default" href="<?= site_url("admincontroller/certrecord/edit/{$item['id']}") ?>">Изменить</a></p>
					<hr>
					<p class="text-center"><a class="delete btn btn-danger" href="<?= site_url("admincontroller/deletePage/certificates/{$item['id']}/false/true") ?>">Удалить</a></p>
				</td>
			</tr>
<?php
		endforeach;
?>
	</tbody>
</table>
	<hr>
<?php
	$attributes = array('role' => 'form', 'id' => 'delBatch');
	echo form_open(site_url('admincontroller/deleteBatchEmpl/certificates/img_certificates_path'), $attributes);
?>
</form>
	<div class="form-group clearfix">
		<div class="col-sm-2  col-sm-offset-9 text-center">
			<input class="delete btn btn-danger" form="delBatch" type="submit" value="Удалить выбранные" />
		</div>
	</div>
<?php
	endif;
?>
	<hr>
	<div id="return">
		<p><a href="<?= base_url("index.php/page/cert/") ?>">Посмотреть на сайте</a></p>
	</div>
	<?=$this->pagination->create_links();?>