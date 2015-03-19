<script>
$(function(){
	$(document).on('change', '#certfilter', function(){
		//echo('<?= site_url("admincontroller/cert") ?>'+'/'+$(this).val());
		window.location='<?= site_url("admincontroller/orders") ?>'+'/'+$(this).val();
	});
	$(document).on('click', '.email', function(){
		echo($(this).text());
		$('#email').val($(this).text());
		$('#subject').val('На Ваш заказ #'+$(this).data('id'));
	});
	$(document).on('submit', '#mailform', function(e){
		e=e||window.event;
		e.stopImmediatePropagation();
		e.preventDefault();
		
		$(this).ajaxSubmit({
			clearForm: true,
			success: function(html){
				$('#response').html(html);
			},
		});
	});
})
</script>



<div class="modal fade bs-example-modal-lg" id="adddescPopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" id="modalSpec">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрити</span></button>
				<h4 class="modal-title" id="myModalLabel">Отправить письмо</h4>
			</div>
			
			<div class="modal-body">
			
				<?php
					$attributes = array('class' => 'form-horizontal', 'style' => 'display: block', 'id' => 'mailform');
						echo form_open(site_url('admincontroller/mail'), $attributes);
				?>
						<input type="hidden" class="form-control" id="email" name="email" value="">
						<div class="form-group">
							<label for="text" class="col-sm-1 control-label">Тема</label>
							<div class="col-sm-11">
								<input type="text" class="form-control" id="subject" name="subject" value="">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<textarea class="form-control" id="text" name="text" rows="10"><?php if(isset($text['text'])) echo $text['text']; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<p class="text-center">
								<input class="btn btn-primary btn-sm" type="submit" value="Отправить" />
							</p>
						</div>
					</form>
					<div class="form-group">
						<div id="response" class="col-sm-12">
						</div>
					</div>
				
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
			</div>
				
				
		</div>
	</div>
</div>




<?php
if(isset($sesconfig)) echo '<p style="color: green;">Конфигурация успешно изменена</p>';
$path='/'.$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_certificates_path');
$segment=($this->uri->segment(3))?$this->uri->segment(3):'all';
//var_dump($path);
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th class="col-lg-1" id="title"><a href="<?= site_url("admincontroller/orders/$segment/date") ?>">Дата</a></th>
			<th class="col-lg-3"><a href="<?= site_url("admincontroller/orders/$segment/name") ?>">Имя</a></th>
			<th class="col-lg-2">Email</th>
			<th class="col-lg-2">Телефон</th>
			<th class="col-lg-1">Заметки</th>
			<th class="col-lg-1">
				<select class="form-control" id="certfilter" name="certfilter">
						<option value="all" <?php if ($segment=='all') echo 'selected="selected"'; ?>>Все</option>
						<?php if (count($status)):
							foreach($status as $val):
								$color[$val['id']]=$val['color'];?>
								<option value="<?php echo $val['id'] ?>" <?php if ($segment==$val['id']) echo 'selected="selected"'; ?>><?php echo $val['name'] ?></option>
						<?php endforeach;
							  endif;?>
				</select>
			</th>
			<th class="col-lg-1" id="checkbox" class="text-center"><button type="button" class="btn btn-primary btn-sm" id="checker" data-target=".mcheck">Выбрать все</button></th>
			<th class="col-lg-1" id="manage">Управление</th>
		</tr>
	</thead>
	<tbody class="cert">
<?php
	if($total<1):
?>
	<tr>
		<td colspan="8"><h3 class="text-center text-warning"><span>Нет ни одного заказа</span></h3></td>
	</tr>
<?php
	else:
		foreach ($orders as $item):
?>
			<tr id="pageid_<?php echo $item['id']?>" class="highlight" style="background-color: <?php echo $color[$item['status_id']]?>;">
				<td class="col-lg-1">
					<?php echo $item['date']?>
				</td>
				<td class="col-lg-2"><?php echo $item['name']?></td>
				<td class="col-lg-2"><button type="button" class="btn btn-primary email" data-id="<?= $item['id'] ?>" data-toggle="modal" data-target="#adddescPopup"><?= $item['email'] ?></button></td>
				<td class="col-lg-2"><?php echo $item['phone'] ?></td>
				<td class="col-lg-2"><textarea class="ordernotes" data-table="order" data-id="<?= $item['id'] ?>"><?php echo $item['notes'] ?></textarea>
				</td>
				<td class="col-lg-2">
					<select class="form-control orderstatus" name="orderstatus">
						<?php if (count($status)):
							foreach($status as $val):?>
								<option data-color="<?= $color[$val['id']] ?>" data-target="#pageid_<?= $item['id'] ?>" value="<?= $val['id'] ?>" <?php if ($item['status_id']==$val['id']) echo 'selected="selected"'; ?>><?= $val['name'] ?></option>
						<?php endforeach;
							  endif;?>
					</select>
				</td>
				<td class="col-lg-1 text-center"><input class="mcheck" form="delBatch" name="checkid_<?php echo $item['id']?>" type="checkbox" value="<?php echo $item['id']?>"></td>
				<td class="col-lg-1 tmiddle">
					<p class="text-center"><a class="btn btn-default" href="<?= site_url("admincontroller/order/edit/{$item['id']}") ?>">Изменить</a></p>
					<hr>
					<p class="text-center"><a class="delete btn btn-danger" href="<?= site_url("admincontroller/deletePage/order/{$item['id']}") ?>">Удалить</a></p>
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
	echo form_open(site_url('admincontroller/deleteBatch/order'), $attributes);
?>
</form>
	<div class="form-group clearfix">
		<div class="col-sm-2  col-sm-offset-10 text-center">
			<input class="delete btn btn-danger" form="delBatch" type="submit" value="Удалить выбранные" />
		</div>
	</div>
<?php
	endif;
?>
	<hr>
	<?=$this->pagination->create_links();?>