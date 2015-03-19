<script>
$(function(){
	$('#modalSpecPopup').on('hidden.bs.modal', function () {
		location.reload();
	});
})
</script>
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрити</span></button>
			<h4 class="modal-title" id="myModalLabel">Фильтр</h4>
		</div>
		
		<div class="modal-body">
		
		
			<?php
				if(empty($certfilter)):
			?>
				<div>
					<h3 class="text-center text-warning"><span>У Вас еще нет ни одной настройки</span></h3>
				</div>
			<?php
				else:
			?>
			<table class="table table-striped">
			<?php
					foreach ($certfilter as $item):
			?>
						<tr>
							<td class="col-lg-1"><input type="text" class="form-control cfid_<?php echo $item['id']?>" name="min" value="<?php echo $item['min']?>"></td>
							<td class="col-lg-1"><input type="text" class="form-control cfid_<?php echo $item['id']?>" name="max" value="<?php echo $item['max']?>"></td>
							<td class="col-lg-4"><input type="text" class="form-control cfid_<?php echo $item['id']?>" name="name" value="<?php echo $item['name']?>"></td>
							<td class="col-lg-1 tmiddle">
								<p class="text-center"><a class="btn btn-default btn-sm teamspec" data-id="multi" data-field=".cfid_<?php echo $item['id']?>" href="<?= site_url("admincontroller/certfilter/update/{$item['id']}") ?>">Обновить</a></p>
							</td>
							<td class="col-lg-1 tmiddle">
								<p class="text-center"><a class="delete btn btn-danger btn-sm teamspec" href="<?= site_url("admincontroller/certfilter/delete/{$item['id']}") ?>">Удалить</a></p>
							</td>
						</tr>
			<?php
					endforeach;
			?>
			</table>
			<?php
				endif;
			?>
			<hr>
			<?php
				$attributes = array('role' => 'form', 'id' => 'addSpec', 'class' => 'form-horizontal', 'data-url' => site_url('admincontroller/certfilter'));
				echo form_open(site_url('admincontroller/certfilter/add'), $attributes);
			?>

					<div class="row form-group">
						<label for="name" class="col-sm-1 control-label">Название</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="cfname" name="name" value="<?php echo set_value('name'); ?>">
						</div>
						<div class="col-sm-2">
							<span id="addNameerror" class="text-danger error">Укажите название</span>
						</div>
					</div>
					<div class="row form-group">
						<label for="min" class="col-sm-1 control-label">От</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="cfmin" name="min" value="<?php echo set_value('min'); ?>">
						</div>
						<div class="col-sm-3">
							<span id="addMinerror" class="text-danger error">Укажите значение</span>
						</div>
						<label for="max" class="col-sm-1 control-label">До</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="max" value="<?php echo set_value('min'); ?>">
						</div>
						<div class="col-sm-3">
							<span id="addSpecerror" class="text-danger error">Укажите значение</span>
						</div>
					</div>
					<div class="row form-group">
						<div class="text-center">
							<input class="btn btn-primary btn-sm" type="submit" value="Добавить" />
						</div>
					</div>

			</form>
			
		</div>
		
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
		</div>
			
			
	</div>
