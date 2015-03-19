<tbody class="cert">
<?php
	foreach ($certificates as $item):
?>
		<tr id="pageid_<?php echo $item['id']?>">
			<td class="col-lg-1">
				<?php if (!empty($item['photo'])):?>
					<img src="<?php echo $path.$item['id'].'/'.$item['photo'].'?'.random_string('alnum', 4);?>" width="100%" height="auto">
				<?php else:?>
					<img src="<?=base_url('img/nophoto.jpg') ?>" width="100%" height="auto">
				<?php endif;?>
			</td>
			<td class="col-lg-6"><?php echo $item['name']?></td>
			<td class="col-lg-3"><?php echo $item['price'] ?></td>
			<td class="col-lg-1 text-center"><input class="mcheck" form="delBatch" name="checkid_<?php echo $item['id']?>" type="checkbox" value="<?php echo $item['id']?>"></td>
			<td class="col-lg-1 tmiddle">
				<p class="text-center"><a class="btn btn-primary" href="<?= site_url("admincontroller/certrecord/add") ?>">Добавить запись</a></p>
				<p class="text-center"><a class="btn btn-default" href="<?= site_url("admincontroller/certrecord/edit/{$item['id']}") ?>">Изменить</a></p>
				<hr>
				<p class="text-center"><a class="delete btn btn-danger" href="<?= site_url("admincontroller/deletePage/certificates/{$item['id']}/false/true") ?>">Удалить</a></p>
			</td>
		</tr>
<?php
	endforeach;
?>
</tbody>