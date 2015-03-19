<script>
$(function(){
	path='./'+'<?php echo $this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_mansclub_path')?>';
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
<div class="row">
	<div class="col-lg-12" style="height: 100%">
		<div id="loadanimation">
			<div class="progress">
				<div class="bar"></div>
				<div class="percent">0%</div>
			</div>
		</div>
		<h2 class="text-center text-muted">Галерея Men's Club</h2>
		<div id="bloggall" class="bloggall">
			<?php
				$path=$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_mansclub_path');
				//var_dump($mensclubgallery);
				if(empty($mensclubgallery)):
			?>
				<div>
					<h3 class="text-center text-warning"><span>У Вас еще нет ни одной фотографии</span></h3>
				</div>
			<?php
				else:
			?>
			<script>
				$(function(){
					$('#bloggallitems').load(url+'getBlogGalleryItems/mensclubgallery/');
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
			$attributes = array('class' => 'form-horizontal', 'style' => 'display: none', 'id' => 'addimageform', 'data-table' => 'mensclubgallery', 'data-view' => 'mensclubgallery');
			echo form_open_multipart(site_url('admincontroller/getBlogGallery/true/mensclubgallery/alt/mc_'), $attributes);
		?>
				<input type="hidden" class="form-control" id="path" name="path" value="<?php echo './'.$path; ?>">
				<input type="hidden" class="form-control" id="thumbs" name="thumbs" value="thumbs">
				<div class="form-group">
					<label for="mensclubgallery" class="col-sm-3 control-label">Изображение для блога</label>
					<div class="col-sm-6">
						<input type="file" class="form-control" id="blogimg" name="mensclubgallery[]" multiple>
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
	</div>
		<hr>
	<div id="return">
		<p><a href="<?= base_url("index.php/page/mensclub") ?>">Посмотреть на сайте</a></p>
	</div>
</div>