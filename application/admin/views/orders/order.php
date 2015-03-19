<script>
$(function(){
})
</script>
<?php
//var_dump (isset($employee));
$attributes = array('role' => 'form', 'id' => 'certrecord');
echo form_open(site_url('admincontroller/order/update/'.$order['id']), $attributes); ?>
</form>
<div id="blogeditdiv" class="row">
	<div id="hm" class="col-lg-5" style="height: 100%">
		<input form="certrecord" type="hidden" name="id" value="<?php echo $order['id'] ?>" />
		<div class="form-group">
			<label for="name" class="control-label">Имя</label>
			<input form="certrecord" type="text" class="form-control" id="name" name="name" value="<?php echo $order['name'] ?>" disabled>
		</div>
		<div class="form-group">
			<label for="email" class="control-label">E-Mail</label>
			<input form="certrecord" type="text" class="form-control" id="email" name="email" value="<?php echo $order['email'] ?>" disabled>
		</div>
		<div class="form-group">
			<label for="phone" class="control-label">Телефон</label>
			<input form="certrecord" type="text" class="form-control" id="phone" name="phone" value="<?php echo $order['phone'] ?>" disabled>
		</div>
		<div class="form-group">
			<label for="text" class="control-label">Заказ</label>
			<textarea form="certrecord" class="form-control" id="text" name="text" rows="15" disabled><?php echo $order['text'] ?></textarea>
		</div>
	</div>
	<div class="col-lg-1" style="height: 100%">
	</div>
	<div class="col-lg-5" style="height: 100%">
		<div class="form-group">
			<label for="status_id" class="control-label">Статус заказа</label>
			<select form="certrecord" class="form-control" id="status_id" name="status_id">
				<?php if (count($status)):
					foreach($status as $val):?>
						<option value="<?= $val['id'] ?>" <?php if ($order['status_id']==$val['id']) echo 'selected="selected"'; ?>><?= $val['name'] ?></option>
				<?php endforeach;
					  endif;?>
			</select>
		</div>
		<div class="form-group">
			<label for="notes" class="control-label">Заметки оператора<?php echo ' '.form_error('notes', '<span class="text-danger">', '</span>'); ?></label><br>
			<textarea form="certrecord" class="form-control" id="notes" name="notes" rows="22"><?php if (set_value('notes')!='') echo set_value('notes'); else echo $order['notes']; ?></textarea>
		</div>
	</div>
</div>

<div class="row">
<hr>
	<div class="col-lg-4">
		<?php if (isset($order['id'])):?>
		<p class="text-left"><a class="delete btn btn-danger" href="<?= site_url("admincontroller/deletePage/order/{$order['id']}") ?>">Удалить</a></p>
		<?php endif; ?>
	</div>
	<div class="col-lg-4 col-lg-offset-4 text-right">
		<input form="certrecord" class="btn btn-primary" type="submit" value="Изменить" />
	</div>
</div>