<script>
$(function(){
	var hgt=$('#hm').height()*.8;
	tinyShortInit(null, hgt);
	path='./'+'<?php echo $this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_certificates_path')?>';
})
</script>
<div id="imgPopup">
	<div class="control prev"></div>
	<div class="control next"></div>
	<div class="carousel">
	</div>
		<ol class="carousel-indicators">
		</ol>
</div>
<div id="error" class="alert alert-danger" role="alert">
	<div></div>
	<div id="errorMessage"></div>
</div>
<div class="modal fade bs-example-modal-lg" id="modalTermsPopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" id="modalSpec"></div>
</div>
<?php
$path=$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_certificates_path');
//var_dump (isset($employee));
$attributes = array('role' => 'form', 'id' => 'certrecord');
echo form_open_multipart(site_url('admincontroller/certrecord/edit'), $attributes); ?>
</form>
<div id="blogeditdiv" class="row">
	<div id="hm" class="col-lg-5" style="height: 100%">
		<input form="certrecord" type="hidden" name="id" value="<?php if (isset($certificates['id'])) echo $certificates['id'] ?>" />
		<div class="form-group">
			<label for="name" class="control-label">Имя<?php echo ' '.form_error('name', '<span class="text-danger">', '</span>'); ?></label>
			<input form="certrecord" type="text" class="form-control" id="name" name="name" value="<?php if (isset($certificates['name'])) echo $certificates['name'] ?>">
		</div>
		<div class="form-group">
			<label for="price" class="control-label">Цена, грн<?php echo ' '.form_error('price', '<span class="text-danger">', '</span>'); ?></label>
			<input form="certrecord" type="text" class="form-control" id="price" name="price" value="<?php if (isset($certificates['price'])) echo $certificates['price'] ?>">
		</div>
		<div class="form-group">
			<label for="name" class="control-label">Фото</label>
			<div style="width: <?=$this->Admin_model->getConParam('img_employee_size')?>px; height: <?=$this->Admin_model->getConParam('img_employee_size')?>px;">
				<?php if(!empty($certificates['photo'])):?>
					<img class="img-circle" src="<?=base_url().$path.$certificates['id'].'/'.$certificates['photo'].'?'.random_string('alnum', 4); ?>" width="<?=$this->Admin_model->getConParam('img_employee_size')?>" height="<?=$this->Admin_model->getConParam('img_employee_size')?>">
				<?php else:?>
					<img src="<?=base_url('img/nophoto.jpg') ?>" width="100%" height="auto">
				<?php endif;?>
			</div>
		</div>
		<div class="form-group">
			<label for="photo" class="col-sm-4 control-label">Добавить/изменить</label>
			<div class="col-sm-8">
				<input form="certrecord" type="file" class="form-control" id="photo" name="photo">
			</div>
		</div>
	</div>
	<div class="col-lg-1" style="height: 100%">
	</div>
	<div class="col-lg-5" style="height: 100%">
		<div class="form-group">
			<label for="text" class="control-label">Текст<?php echo ' '.form_error('text', '<span class="text-danger">', '</span>'); ?></label><br>
			<textarea form="certrecord" class="form-control" id="text" name="text"><?php if (isset($certificates['text'])) echo $certificates['text'] ?></textarea>
		</div>
	</div>
</div>

<div class="row">
<hr>
	<div class="col-lg-4">
		<?php if (isset($certificates['id'])):?>
		<p class="text-left"><a class="delete btn btn-danger" href="<?= site_url("admincontroller/deletePage/certificates/{$certificates['id']}/false/true") ?>">Удалить</a></p>
		<?php endif; ?>
	</div>
	<div class="col-lg-4">
		<?php if (isset($certificates['id'])): ?>
		<p class="text-center"><a class="btn btn-primary" href="<?= site_url("admincontroller/certrecord/add") ?>">Добавить новую</a></p>
		<?php endif; ?>
	</div>
	<div class="col-lg-4 text-right">
		<input form="certrecord" class="btn btn-primary" type="submit" value="Изменить" />
	</div>
</div>

<div class="row" id="return">
	<p><a href="<?= base_url("certificates/") ?>">Посмотреть на сайте</a></p>
</div>