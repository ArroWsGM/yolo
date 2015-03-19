<script>
$(function(){
	path='./'+'<?php echo $this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_blog_path')?>';
})
</script>
<div id="loadanimation">
	<div class="progress">
		<div class="bar"></div>
		<div class="percent">0%</div>
	</div>
</div>
<div id="error" class="alert alert-danger" role="alert">
	<div></div>
	<div id="errorMessage"></div>
</div>
<?php
if(isset($sesconfig)) echo '<p style="color: green;">Конфигурация успешно изменена</p>';
//var_dump($path);
?>

<?php
	if(empty($blogimg)):
?>
	<div>
		<h3 class="text-center text-warning"><span>У Вас еще нет ни одной фотографии</span></h3>
	</div>
<?php
	else:
?>
<div id="bloggallitems"></div>
<?php
	endif;
?>
<p class="text-center"><a id="showform" class="btn btn-primary" href="#addimageform">Добавить фото</a></p>
<?php
	$attributes = array('class' => 'form-horizontal', 'style' => 'display: none', 'id' => 'addimageform');
	echo form_open_multipart(site_url('admincontroller/getBlogGallery/true'), $attributes);
?>		
			<div class="form-group">
				<label for="blogimg" class="col-sm-3 control-label">Изображение для блога</label>
				<div class="col-sm-6">
					<input type="file" class="form-control" id="blogimg" name="blogimg[]" multiple>
				</div>
				<div class="col-sm-2">
					<span id="blogimgerror" class="text-danger">Файл не выбран</span>
				</div>
			</div>
			<div class="form-group">
				<label for="name" class="col-sm-3 control-label">Описание</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name'); ?>">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2 col-sm-offset-5">
					<input class="btn btn-primary btn-sm" type="submit" value="Добавить" />
				</div>
			</div>
		
		</form>