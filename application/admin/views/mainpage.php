<div id="loadanimation"></div>

<?php
	if(empty($mainpage)):
?>
	<div><span>У Вас еще нет ни одной страницы</span></div>
<?php
	else:
?>
<table class="table table-striped">
<?php
		foreach ($mainpage as $item):
?>
			<tr id="pageid_<?php echo $item['id']?>">
				<td class="col-lg-4"><img src="<?= $path.$item['id'].'/'.$item['img_bg_name'] ?>" width="100%" height="auto"></td>
				<td class="col-lg-7"><textarea class="form-control" rows="8"><?php echo $item['text']; ?></textarea>
				<br>
				<p class="text-center"><a class="change btn btn-default btn-sm" href="#">Изменить описание</a></p></td>
				<td class="col-lg-1 tmiddle"><p class="text-center"><a class="delete btn btn-danger" href="<?= site_url("admincontroller/deletePage/mainpage/{$item['id']}/false/true") ?>">Удалить</a></p></td>
			</tr>
<?php
		endforeach;
?>
</table>
<?php
	endif;
?>
		<?php echo validation_errors('<p style="color: red;">', '</p>'); ?>
<hr>
		<?php 
		$attributes = array('class' => 'form-horizontal');
		echo form_open_multipart(site_url('admincontroller/mainpage'), $attributes) ?>
			
			<input type="hidden" name="refer_from" value="<?php echo current_url(); ?>" />
		
			<div class="form-group">
				<label for="img_bg_name" class="col-sm-4 control-label">Изображение для главной страницы</label>
				<div class="col-sm-8">
					<input type="file" class="form-control" id="img_bg_name" name="img_bg_name" value="<?php echo set_value('text'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="text" class="col-sm-4 control-label">Текст для главной страницы</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="text" name="text" rows="5"><?php echo set_value('text'); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2  col-sm-offset-5">
					<input class="btn btn-primary btn-lg" type="submit" value="Добавить" />
				</div>
			</div>
		
		</form>
	<hr>
	<div id="return">
		<p><a href="<?= base_url(); ?>">Посмотреть на сайте</a></p>
	</div>
	<?=$pagination?>