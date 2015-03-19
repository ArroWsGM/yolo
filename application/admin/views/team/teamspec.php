
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрити</span></button>
			<h4 class="modal-title" id="myModalLabel">Специальности</h4>
		</div>
		
		<div class="modal-body">
		
		
			<?php
				if(empty($spec)):
			?>
				<div>
					<h3 class="text-center text-warning"><span>У Вас еще нет ни одной специальности</span></h3>
				</div>
			<?php
				else:
			?>
			<table class="table table-striped">
			<?php
					foreach ($spec as $item):
			?>
						<tr>
							<td class="col-lg-10"><input type="text" class="form-control" id="specid_<?php echo $item['id']?>" name="name" value="<?php echo $item['name']?>"></td>
							<td class="col-lg-1 tmiddle">
								<p class="text-center"><a class="btn btn-default btn-sm teamspec" data-id="#specid_<?php echo $item['id']?>" data-field="name" href="<?= site_url("admincontroller/teamspec/update/{$item['id']}") ?>">Обновить</a></p>
							</td>
							<td class="col-lg-1 tmiddle">
								<p class="text-center"><a class="delete btn btn-danger btn-sm teamspec" href="<?= site_url("admincontroller/teamspec/delete/{$item['id']}") ?>">Удалить</a></p>
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
				$attributes = array('role' => 'form', 'id' => 'addSpec');
				echo form_open(site_url('admincontroller/teamspec/add'), $attributes);
			?>

					<div class="row">
						<label for="name" class="col-sm-2 control-label">Специальность</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="specname" name="name" value="<?php echo set_value('name'); ?>">
						</div>
						<div class="col-sm-3">
							<span id="addSpecerror" class="text-danger error">Укажите специальность</span>
						</div>
						<div class="col-sm-2 text-right">
							<input class="btn btn-primary btn-sm" type="submit" value="Добавить" />
						</div>
					</div>

			</form>
			
		</div>
		
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
		</div>
			
			
	</div>
