<?php
$path=$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_blog_path');
if(isset($sesconfig)) echo '<p style="color: green;">Конфигурация успешно изменена</p>';
//var_dump($path);
?>

<?php
	if(empty($blog)):
?>
	<div>
		<h3 class="text-center text-warning"><span>У Вас еще нет ни одной записи в блоге</span></h3>
		<p class="text-center"><a class="btn btn-primary" href="<?= site_url("admincontroller/editBlog/add") ?>">Добавить запись</a></p>
	</div>
<?php
	else:
?>
<table class="table table-striped">
	<tr>
		<th class="col-lg-1" id="title">Photo</th>
		<th class="col-lg-5" id="title"><a href="<?= site_url("admincontroller/blog/name") ?>">Title</a></th>
		<th class="col-lg-4" id="date"><a href="<?= site_url("admincontroller/blog/date") ?>">Date</a></th>
		<th class="col-lg-1" id="checkbox" class="text-center"><button type="button" class="btn btn-primary btn-sm" id="checker" data-target=".mcheck">Выбрать все</button></th>
		<th class="col-lg-1" id="manage">Manage</th>
	</tr>
<?php
		foreach ($blog as $item):
?>
			<tr id="pageid_<?php echo $item['id']?>">
				<td class="col-lg-1">
					<?php if (!empty($item['photo'])):?>
						<img src="<?php echo base_url().$path.$item['id'].'/'.$item['photo'].'?'.random_string('alnum', 4);?>" width="100%" height="auto">
					<?php else:?>
						<img src="<?=base_url('img/nophoto.jpg') ?>" width="100%" height="auto">
					<?php endif;?>
				</td>
				<td class="col-lg-5"><?php echo $item['name']?></td>
				<td class="col-lg-4"><?php //echo mdate('%j.%m.%Y, %H:%i:%s', $item['date'])
											echo $item['date']
											?></td>
				<td class="col-lg-1 text-center"><input class="mcheck" form="delBatch" name="checkid_<?php echo $item['id']?>" type="checkbox" value="<?php echo $item['id']?>"></td>
				<td class="col-lg-1 tmiddle">
					<p class="text-center"><a class="btn btn-primary" href="<?= site_url("admincontroller/editBlog/add") ?>">Добавить запись</a></p>
					<p class="text-center"><a class="btn btn-default" href="<?= site_url("admincontroller/editBlog/edit/{$item['id']}") ?>">Изменить</a></p>
					<hr>
					<p class="text-center"><a class="delete btn btn-danger" href="<?= site_url("admincontroller/deletePage/blog/{$item['id']}") ?>">Удалить</a></p>
				</td>
			</tr>
<?php
		endforeach;
?>
</table>
	<hr>
<?php
	$attributes = array('role' => 'form', 'id' => 'delBatch');
	echo form_open(site_url('admincontroller/deleteBatch/blog'), $attributes);
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
		<p><a href="<?= base_url("index.php/page/blog") ?>">Посмотреть на сайте</a></p>
	</div>
	<?=$this->pagination->create_links();?>