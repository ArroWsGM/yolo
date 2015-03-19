<script>
$(function(){
	$(document).on('click', '#modalSpecPopupBut', function(){
		$('#modalSpec').load(url+'teamspec');
	})
})
</script>
<?php
if(isset($sesconfig)) echo '<p style="color: green;">Конфигурация успешно изменена</p>';
$path='/'.$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_employee_path');
//var_dump($path);
?>
<!-- Широка модаль -->
<button type="button" class="btn btn-primary" id="modalSpecPopupBut" data-toggle="modal" data-target="#modalSpecPopup">Добавить специальность</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#adddescPopup">Добавить/изменить текст "О нас"</button>
<br>
<br>
<div class="modal fade bs-example-modal-lg" id="modalSpecPopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" id="modalSpec"></div>
</div>

<div class="modal fade bs-example-modal-lg" id="adddescPopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" id="modalSpec">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрити</span></button>
				<h4 class="modal-title" id="myModalLabel">Текст "О нас"</h4>
			</div>
			
			<div class="modal-body">
			
				<?php
					$attributes = array('class' => 'form-horizontal', 'style' => 'display: block', 'id' => 'adddesc');
					if(isset($text['id']))
						echo form_open_multipart(site_url('admincontroller/changeField/team/text').'/'.$text['id'], $attributes);
					else
						echo form_open_multipart(site_url('admincontroller/changeField/team'), $attributes);
				?>
						<div class="form-group">
							<label for="text" class="col-sm-3 control-label">Описание</label>
							<div class="col-sm-6">
								<textarea type="text" class="form-control" id="text" name="text" rows="10"><?php if(isset($text['text'])) echo $text['text']; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<p class="text-center">
								<input class="btn btn-primary btn-sm" type="submit" value="Добавить/изменить" />
							</p>
						</div>
					</form>
				
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
			</div>
				
				
		</div>
	</div>
</div>
<!-- Широка модаль -->
<?php
	if(empty($blog)):
?>
	<div>
		<h3 class="text-center text-warning"><span>У Вас еще нет ни одного сотрудника</span></h3>
		<p class="text-center"><a class="btn btn-primary" href="<?= site_url("admincontroller/employee/add") ?>">Добавить запись</a></p>
	</div>
<?php
	else:
?>
<table class="table table-striped">
	<tr>
		<th id="title">Photo</th>
		<th id="title"><a href="<?= site_url("admincontroller/team/name") ?>">Name</a></th>
		<th id="title"><a href="<?= site_url("admincontroller/team/name") ?>">Spec</a></th>
		<th id="checkbox" class="text-center"><button type="button" class="btn btn-primary btn-sm" id="checker" data-target=".mcheck">Выбрать все</button></th>
		<th id="manage">Manage</th>
	</tr>
<?php
		foreach ($blog as $item):
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
				<td class="col-lg-3"><?php echo $spec[$item['spec_id']] ?></td>
				<td class="col-lg-1 text-center"><input class="mcheck" form="delBatch" name="checkid_<?php echo $item['id']?>" type="checkbox" value="<?php echo $item['id']?>"></td>
				<td class="col-lg-1 tmiddle">
					<p class="text-center"><a class="btn btn-primary" href="<?= site_url("admincontroller/employee/add") ?>">Добавить запись</a></p>
					<p class="text-center"><a class="btn btn-default" href="<?= site_url("admincontroller/employee/edit/{$item['id']}") ?>">Изменить</a></p>
					<hr>
					<p class="text-center"><a class="delete btn btn-danger" href="<?= site_url("admincontroller/deletePage/employee/{$item['id']}/false/true") ?>">Удалить</a></p>
				</td>
			</tr>
<?php
		endforeach;
?>
</table>
	<hr>
<?php
	$attributes = array('role' => 'form', 'id' => 'delBatch');
	echo form_open(site_url('admincontroller/deleteBatchEmpl/employee'), $attributes);
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
		<p><a href="<?= base_url("index.php/page/team/") ?>">Посмотреть на сайте</a></p>
	</div>
	<?=$this->pagination->create_links();?>