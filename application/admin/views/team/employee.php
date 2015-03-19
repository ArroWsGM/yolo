<script>
$(function(){
	tinyShortInit();

	$('#modalSpec').load(url+'terms/null/null/<?php if (isset($employee['id'])) echo $employee['id'] ?>');
	$('#modalTermsPopup').on('hidden.bs.modal', function () {
		location.reload();
	});
	//loadGallery('portfolio/eployee_id/<?php if (isset($employee['id'])) echo $employee['id'] ?>');
	
	path='./'+'<?php echo $this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_employee_path')?>';
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
$path=$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_employee_path');
//var_dump (isset($employee));
$attributes = array('role' => 'form', 'id' => 'employee');
echo form_open_multipart(site_url('admincontroller/employee/edit'), $attributes); ?>
</form>
<div id="blogeditdiv" class="row">
	<div class="col-lg-5" style="height: 100%">
		<input form="employee" type="hidden" name="id" value="<?php if (isset($employee['id'])) echo $employee['id'] ?>" />
		<div class="form-group">
			<label for="name" class="control-label">Имя<?php echo ' '.form_error('name', '<span class="text-danger">', '</span>'); ?></label>
			<input form="employee" type="text" class="form-control" id="name" name="name" value="<?php if (isset($employee['name'])) echo $employee['name'] ?>">
		</div>
		<div class="form-group">
			<label for="spec" class="control-label">Специальность<?php echo ' '.form_error('spec_id', '<span class="text-danger">', '</span>'); ?></label>
			<select form="employee" type="text" class="form-control" id="spec" name="spec_id" value="<?php if (isset($employee['spec'])) echo $employee['spec'] ?>">
				    <option <?php if (!isset($employee['spec_id'])) echo 'selected="selected"'; ?> disabled>Выберите специальность</option>
					<?php if (count($spec)):
						foreach($spec as $val):?>
							<option <?php	if (isset($employee['spec_id']))
												if ($employee['spec_id']==$val['id'])
													echo 'selected="selected"'; ?> value="<?php echo $val['id'] ?>"><?php echo $val['name'] ?></option>
					<?php endforeach;
						endif; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="name" class="control-label">Фото</label>
			<div style="width: <?=$this->Admin_model->getConParam('img_employee_size')?>px; height: <?=$this->Admin_model->getConParam('img_employee_size')?>px;">
				<?php if(isset($employee['photo'])):?>
					<img class="img-circle" src="<?=base_url().$path.$employee['id'].'/'.$employee['photo'].'?'.random_string('alnum', 4); ?>" width="<?=$this->Admin_model->getConParam('img_employee_size')?>" height="<?=$this->Admin_model->getConParam('img_employee_size')?>">
				<?php else:?>
					<img src="<?=base_url('img/nophoto.jpg') ?>" width="100%" height="auto">
				<?php endif;?>
			</div>
		</div>
		<div class="form-group">
			<label for="photo" class="col-sm-4 control-label">Добавить/изменить</label>
			<div class="col-sm-8">
				<input form="employee" type="file" class="form-control" id="photo" name="photo">
			</div>
		</div>
		<div class="form-group">
			<label for="qualification" class="control-label">Квалификация<?php echo ' '.form_error('qualification', '<span class="text-danger">', '</span>'); ?></label><br>
			<textarea form="employee" class="form-control" id="qualification" name="qualification"><?php if (isset($employee['qualification'])) echo $employee['qualification'] ?></textarea>
		</div>
		<div class="form-group" id="terms">
		
			<?php
				if (isset($employee['id'])):
			?>
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label">Дополнительная информация</label><br>
						<p class="text-left"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTermsPopup">Добавить/изменить</button></p>
					</div>
				</div>
			<?php
				endif;
				if (isset($terms)):
			?>
				
				<?php
					foreach($terms as $val):
				?>
				<div class="form-group">
					<div class="alert alert-info">
						<p class="text-left"><?php echo $val['term_text'] ?></p>
					</div>
				</div>
			
			<?php
					endforeach;
			?>
				
			<?php
				endif;
			?>
			
			
		</div>
	</div>
	
<!--

*******************************Портфолио

-->
	<div class="col-lg-7" style="height: 100%">
<div id="loadanimation">
	<div class="progress">
		<div class="bar"></div>
		<div class="percent">0%</div>
	</div>
</div>
		<h2 class="text-center text-muted">Портфолио</h2>
	<?php
		if (!isset($employee['id'])):
	?>
		<div>
			<h3 class="text-center text-warning"><span>Чтобы создать портфолио, сначала добавьте сотрудника</span></h3>
		</div>
	<?php
		else:
	?>
		<div id="bloggall" class="bloggall">
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
					$('#bloggallitems').load(url+'getBlogGalleryItems/portfolio/eployee_id/'+<?php echo $employee['id']; ?>);
				})
			</script>
			<div id="bloggallitems">

			</div>
			<?php
				endif;
			?>
		</div>
		<p class="text-center"><a id="showform" class="btn btn-primary" href="#addimageform">Добавить фото</a></p>
		<?php
			$attributes = array('class' => 'form-horizontal', 'style' => 'display: none', 'id' => 'addimageform', 'data-table' => 'portfolio/eployee_id/'.$employee['id'], 'data-view' => 'team');
			echo form_open_multipart(site_url('admincontroller/getBlogGallery/true/portfolio/alt/port_'), $attributes);
		?>		
				<input type="hidden" class="form-control" id="path" name="path" value="<?php echo './'.$path.$employee['id'].'/'; ?>">
				<input type="hidden" class="form-control" id="eployee_id" name="eployee_id" value="<?php echo $employee['id']; ?>">
				<input type="hidden" class="form-control" id="thumbs" name="thumbs" value="thumbs">
				<div class="form-group">
					<label for="portfolio" class="col-sm-3 control-label">Изображение для блога</label>
					<div class="col-sm-6">
						<input type="file" class="form-control" id="blogimg" name="portfolio[]" multiple>
					</div>
					<div class="col-sm-2">
						<span id="blogimgerror" class="text-danger">Файл не выбран</span>
					</div>
				</div>
				<div class="form-group">
					<label for="alt" class="col-sm-3 control-label">Описание</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="alt" name="alt" value="<?php echo set_value('alt'); ?>">
					</div>
				</div>
				<div class="form-group">
					<p class="text-center">
						<input class="btn btn-primary btn-sm" type="submit" value="Добавить" />
					</p>
				</div>
			
			</form>
	<?php
		endif;
	?>
	
	</div>
</div>
<!--<div id="bloggall" class="col-lg-6 bloggallshow"></div>-->
<div class="row">
<hr>
	<div class="col-lg-4">
		<?php if (isset($employee['id'])):?>
		<p class="text-left"><a class="delete btn btn-danger" href="<?= site_url("admincontroller/deletePage/employee/{$employee['id']}/false/true") ?>">Удалить</a></p>
		<?php endif; ?>
	</div>
	<div class="col-lg-4">
		<?php if (isset($employee['id'])): ?>
		<p class="text-center"><a class="btn btn-primary" href="<?= site_url("admincontroller/employee/add") ?>">Добавить новую</a></p>
		<?php endif; ?>
	</div>
	<div class="col-lg-4 text-right">
		<input form="employee" class="btn btn-primary" type="submit" value="Изменить" />
	</div>
</div>

<div class="row" id="return">
	<p><a href="<?= base_url("team/") ?>">Посмотреть на сайте</a></p>
</div>