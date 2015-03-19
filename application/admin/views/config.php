


<?php
if(isset($sesconfig)) echo '<p style="color: green;">Конфигурация успешно изменена</p>';
	var_dump($config);
?>
		<?php $this->form_validation->set_error_delimiters('<p style="color: red; padding-top: 7px;">', '</p>'); ?>

		<?php 
		$attributes = array('class' => 'form-horizontal');
		echo form_open(site_url('admincontroller/config'), $attributes) ?>
		
			<div class="form-group">
				<label for="img_base_path" class="col-sm-3 control-label">Основная папка изображений</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="img_base_path" name="img_base_path" value="<?php echo $config['img_base_path']; ?>">
				</div>
				<div class="col-sm-3 text-left">
					<?php echo form_error('img_base_path'); ?>
				</div>
			</div>
			<div class="form-group">
				<label for="img_mainpage_path" class="col-sm-3 control-label">Папка изображений главной страницы</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="img_mainpage_path" name="img_mainpage_path" value="<?php echo $config['img_mainpage_path']; ?>">
				</div>
				<div class="col-sm-3 text-left">
					<?php echo form_error('img_mainpage_path'); ?>
				</div>
			</div>
			<div class="form-group">
				<label for="img_mansclub_path" class="col-sm-3 control-label">Папка изображений Man's Club</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="img_mansclub_path" name="img_mansclub_path" value="<?php echo $config['img_mansclub_path']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="img_blog_path" class="col-sm-3 control-label">Папка изображений для блога</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="img_blog_path" name="img_blog_path" value="<?php echo $config['img_blog_path']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="img_employee_path" class="col-sm-3 control-label">Папка изображений для сотрудников</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="img_employee_path" name="img_employee_path" value="<?php echo $config['img_employee_path']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="img_certificates_path" class="col-sm-3 control-label">Папка изображений для сертификатов</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="img_certificates_path" name="img_certificates_path" value="<?php echo $config['img_certificates_path']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="img_per_page_portfolio" class="col-sm-3 control-label">Превьюшек в портфолио на страницу</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="img_per_page_portfolio" name="img_per_page_portfolio" value="<?php echo $config['img_per_page_portfolio']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="img_per_page_mensclub" class="col-sm-3 control-label">Превьюшек в Men's Club на страницу</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="img_per_page_mensclub" name="img_per_page_mensclub" value="<?php echo $config['img_per_page_mensclub']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="img_thumb_width" class="col-sm-3 control-label">Максимальный размер превью, ширина</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="img_thumb_width" name="img_thumb_width" value="<?php echo $config['img_thumb_width']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="img_thumb_height" class="col-sm-3 control-label">Максимальный размер превью, высота</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="img_thumb_height" name="img_thumb_height" value="<?php echo $config['img_thumb_height']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="img_employee_size" class="col-sm-3 control-label">Размер фото сотрудников</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="img_employee_size" name="img_employee_size" value="<?php echo $config['img_employee_size']; ?>">
				</div>
			</div>
			<div class="col-sm-12"><hr></div>
			<div class="form-group">
				<label for="admin_item_per_page" class="col-sm-3 control-label">Элементов на страницу в админ-панели</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="admin_item_per_page" name="admin_item_per_page" value="<?php echo $config['admin_item_per_page']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="front_item_per_page" class="col-sm-3 control-label">Элементов на страницу на сайте</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="front_item_per_page" name="front_item_per_page" value="<?php echo $config['front_item_per_page']; ?>">
				</div>
			</div>
			<div class="col-sm-12"><hr></div>
			<div class="form-group">
				<label for="order_send_confirm" class="col-sm-3 control-label">Оповещать о принятии заказа?</label>
				<div class="col-sm-8 text-left">
					<input type="checkbox" class="checkbox" id="order_send_confirm" name="order_send_confirm" 
						<?php
							if ($config['order_send_confirm']=='1') echo ' checked';
						?>
					>
				</div>
			</div>
			<div class="form-group">
				<label for="order_send_confirm_text" class="col-sm-3 control-label">Текст оповещения о принятии заказа</label>
				<div class="col-sm-6">
					<textarea class="form-control" id="order_send_confirm_text" name="order_send_confirm_text" rows="5"><?php echo $config['order_send_confirm_text']; ?></textarea>
				</div>
			</div>
			<div class="col-sm-12"><hr></div>
			<div class="form-group">
				<label for="changeadmin" class="col-sm-3 control-label">Изменить имя пользователя и/или пароль?</label>
				<div class="col-sm-8 text-left">
					<input type="checkbox" class="checkbox" id="changeadmin" name="changeadmin">
				</div>
			</div>
			<div id="userdata">
				<div class="form-group">
					<label for="admin" class="col-sm-3 control-label">Имя пользователя</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="admin" name="admin" value="<?php echo $config['admin']; ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="adminpass" class="col-sm-3 control-label">Пароль</label>
					<div class="col-sm-6">
						<input type="password" class="form-control" id="adminpass" name="adminpass" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="adminpassc" class="col-sm-3 control-label">Повторите пароль</label>
					<div class="col-sm-6">
						<input type="password" class="form-control" id="adminpassc" name="adminpassc" disabled>
					</div>
				</div>
			</div>
			<input type="submit" name="submit" value="Сохранить" />

		</form>
		<div id="return">
			<p><a href="<?= base_url(); ?>">Вернуться к покупкам</a></p>
		</div>
		<div class="row">
			<?= phpinfo(); ?>
		</div>