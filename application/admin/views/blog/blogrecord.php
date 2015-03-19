<script>
$(function(){
	tinyHeight=$('#blogeditdiv').height()*.5;
	loadGallery();
	$('#bloggallshow').on('click', function(){
		if($(this).css('right')=='0px'){
			$('.bloggallshow').animate({
				right: '+='+'50%',
			});
		}
		else{
			$('.bloggallshow').animate({
				right: '-='+'50%',
			});
		}
	});
})
</script>
<?php
$path=$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_blog_path');
$attributes = array('role' => 'form', 'id' => 'blogedit');
echo form_open_multipart(site_url('admincontroller/editBlog/edit'), $attributes); ?>
</form>
<?php echo validation_errors('<p style="color: red;">', '</p><br>'); ?>
<div id="blogeditdiv" class="row">
	<div class="col-lg-7" style="height: 100%">
		<input form="blogedit" type="hidden" name="refer_from" value="<?php echo current_url(); ?>" />
		<input form="blogedit" type="hidden" name="id" value="<?php if (isset($blog)) echo $blog['id'] ?>" />
		<div class="form-group">
			<label for="name" class="control-label">Имя статьи</label>
				<input form="blogedit" type="text" class="form-control" id="name" name="name" value="<?php if (isset($blog)) echo $blog['name'] ?>">
		</div>
		<div id="tinyCont" class="form-group">
			<label for="text" class="control-label">Текст</label>
			<textarea form="blogedit" id="text" name="text"><?php if (isset($blog)) echo $blog['text'] ?></textarea>
		</div>
	</div>
	<div class="col-lg-5" style="height: 100%">
		<div class="form-group">
			<label for="name" class="control-label">Фото</label>
			<div style="width: <?=$this->Admin_model->getConParam('img_thumb_width')?>px; height: <?=$this->Admin_model->getConParam('img_thumb_height')?>px;">
				<?php if(!empty($blog['photo'])):?>
					<img class="img-rounded" src="<?=base_url().$path.$blog['id'].'/'.$blog['photo'].'?'.random_string('alnum', 4); ?>" width="<?=$this->Admin_model->getConParam('img_thumb_width')?>" height="<?=$this->Admin_model->getConParam('img_thumb_height')?>">
				<?php else:?>
					<img src="<?=base_url('img/nophoto.jpg') ?>" width="auto" height="100%">
				<?php endif;?>
			</div>
		</div>
		<div class="form-group">
			<label for="photo" class="col-sm-4 control-label">Добавить/изменить</label>
			<div class="col-sm-8">
				<input form="blogedit" type="file" class="form-control" id="photo" name="photo">
			</div>
		</div>
	</div>
</div>
<div id="bloggallshow" class="bg-primary bloggallshow"></div>
<div id="bloggall" class="col-lg-6 bloggallshow"></div>
<div class="row">
<hr>
	<div class="col-lg-4">
		<?php if (isset($blog)): ?>
		<p class="text-left"><a class="delete btn btn-danger" href="<?= site_url("admincontroller/deletePage/blog/{$blog['id']}") ?>">Удалить</a></p>
		<?php endif; ?>
	</div>
	<div class="col-lg-4">
		<?php if (isset($blog)): ?>
		<p class="text-center"><a class="btn btn-primary" href="<?= site_url("admincontroller/editBlog/add") ?>">Добавить новую</a></p>
		<?php endif; ?>
	</div>
	<div class="col-lg-4 text-right">
		<input form="blogedit" class="btn btn-primary" type="submit" value="Изменить" />
	</div>
</div>

<div class="row" id="return">
	<p><a href="<?= base_url("blog/") ?>">Посмотреть на сайте</a></p>
</div>