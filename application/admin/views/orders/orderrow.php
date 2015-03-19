<td class="col-lg-1">
	<?php echo $orders['date']?>
</td>
<td class="col-lg-2"><?php echo $orders['name']?></td>
<td class="col-lg-2"><button type="button" class="btn btn-primary email" data-id="<?= $orders['id'] ?>" data-toggle="modal" data-target="#adddescPopup"><?= $orders['email'] ?></button></td>
<td class="col-lg-2"><?php echo $orders['phone'] ?></td>
<td class="col-lg-2"><textarea class="ordernotes" data-table="order" data-id="<?= $orders['id'] ?>"><?php echo $orders['notes'] ?></textarea>
</td>
<td class="col-lg-2">
	<select class="form-control orderstatus" name="orderstatus">
		<?php if (count($status)):
			foreach($status as $val):?>
				<option data-color="<?= $val['color'] ?>" data-target="#pageid_<?= $orders['id'] ?>" value="<?= $val['id'] ?>" <?php if ($orders['status_id']==$val['id']) echo 'selected="selected"'; ?>><?= $val['name'] ?></option>
		<?php endforeach;
			  endif;?>
	</select>
</td>
<td class="col-lg-1 text-center"><input class="mcheck" form="delBatch" name="checkid_<?php echo $orders['id']?>" type="checkbox" value="<?php echo $orders['id']?>"></td>
<td class="col-lg-1 tmiddle">
	<p class="text-center"><a class="btn btn-default" href="<?= site_url("admincontroller/order/edit/{$orders['id']}") ?>">Изменить</a></p>
	<hr>
	<p class="text-center"><a class="delete btn btn-danger" href="<?= site_url("admincontroller/deletePage/order/{$orders['id']}/false/true") ?>">Удалить</a></p>
</td>