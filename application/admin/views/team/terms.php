<script>
$(function(){
	$('.modal-content').on('click', 'textarea', function(){
		tinymce.remove('.modal-content textarea');
		//tinymce.execCommand('mceRemoveControl', true, 'textarea');
		tinyShortInit($(this).attr('id'));
	});
})
</script>
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрити</span></button>
			<h4 class="modal-title" id="myModalLabel">Дополнительно</h4>
		</div>
		
		<div class="modal-body">
		
		
			<?php
				if(empty($terms)):
			?>
				<div>
					<h3 class="text-center text-warning"><span>У Вас еще нет ни одной записи</span></h3>
				</div>
			<?php
				else:
			?>
			<table class="table table-striped">
			<?php
					foreach ($terms as $item):
			?>
						<tr>
							<td class="col-lg-10"><textarea class="form-control" id="termsid_<?php echo $item['id']?>" name="term_text" rows="4"><?php echo $item['term_text']?></textarea></td>
							<td class="col-lg-1 tmiddle">
								<p class="text-center"><a class="btn btn-default btn-sm teamspec" data-id="#termsid_<?php echo $item['id']?>" data-field="term_text" href="<?= site_url("admincontroller/terms/update/{$item['id']}/{$employee}") ?>">Обновить</a></p>
							</td>
							<td class="col-lg-1 tmiddle">
								<p class="text-center"><a class="delete btn btn-danger btn-sm teamspec" href="<?= site_url("admincontroller/terms/delete/{$item['id']}/{$employee}") ?>">Удалить</a></p>
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
				$attributes = array('role' => 'form', 'id' => 'addSpec', 'data-url' => site_url("admincontroller/terms/null/null/{$employee}"));
				echo form_open(site_url("admincontroller/terms/add/null/{$employee}"), $attributes);
			?>

					<div class="row">
						<input type="hidden" class="form-control" id="eployee_id" name="eployee_id" value="<?php echo $employee; ?>">
						<div class="col-lg-9">
							<textarea class="form-control" id="specname" name="term_text" rows="4"><?php echo set_value('term_text'); ?></textarea>
						</div>
						<div class="col-lg-1">
							<span id="addSpecerror" class="text-danger error">Заполните поле</span>
						</div>
						<div class="col-lg-2 text-right">
							<input class="btn btn-primary btn-sm" type="submit" value="Добавить" />
						</div>
					</div>

			</form>
			
		</div>
		
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
		</div>
			
			
	</div>
