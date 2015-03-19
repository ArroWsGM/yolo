<!--[if lt IE 10]>
<script>
$(function(){
	$('[placeholder]').focus(function() {
	  var input = $(this);
	  if (input.val() == input.attr('placeholder')) {
		input.val('');
		input.removeClass('placeholder');
	  }
	}).blur(function() {
	  var input = $(this);
	  if (input.val() == '' || input.val() == input.attr('placeholder')) {
		input.addClass('placeholder');
		input.val(input.attr('placeholder'));
	  }
	}).blur();
})
</script>
<![endif]-->
<script>
$(function(){
	if($('#phone').exists()){
		
		$('#phone').each(function(){
			$(this).mask("(999) 999-99-99");
		});
	
	}
})
</script>
	<?php if(validation_errors()):?>
	<div id="validerror">
	<?php else:?>
	<div id="validerror" style="display: none">
	<?php endif;?>
		<div class="text-center">
			<?php echo validation_errors(); ?>
			<button class="btn btn-yolo">ОК</button>
		</div>
	</div>
	<div id="righthead">
		<span>Форма обратной связи</span>
	</div>
<?php 
	$attributes = array('class' => 'form checkout', 'style' => 'height: 100%; margin-top: 1%;');
	echo form_open(site_url('page/checkout/feedback'), $attributes) ?>
		
		<!--<input type="hidden" name="refer_from" value="<?php echo current_url(); ?>" />-->
	
		<div class="form-group col-sm-12" style="height: 10%;">
			<div class="input-group col-sm-4" style="float: left;">
				<div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
				<input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name'); ?>" placeholder="Имя">
			</div>
			<div class="input-group col-sm-4" style="float: left; padding-left: 5px;">
				<div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
				<input type="text" class="form-control" id="email" name="email" value="<?php echo set_value('email'); ?>" placeholder="e-Mail">
			</div>
			<div class="input-group col-sm-4 phone" style="float: left; padding-left: 5px;">
				<div class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></div>
				<input type="text" class="form-control rfield" id="phone" name="phone" value="<?php echo set_value('phone'); ?>" placeholder="(___) ___ __ __">
			</div>
		</div>
		<div class="form-group col-sm-12 clearfix" style="height: 60%;">
				<textarea class="form-control" id="text" name="text" rows="5"><?php echo set_value('text'); ?></textarea>
		</div>
		<div class="form-group col-sm-12" style="height: 10%;">
			<div class="col-sm-2  col-sm-offset-5">
				<button class="btn btn-yolo btn-lg">Отправить&nbsp;&nbsp;<span class="glyphicon glyphicon-ok"></span></button>
			</div>
		</div>
	
	</form>