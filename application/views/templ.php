<script>
	$(function(){
		$('#gallery').load(url+'portfolio/<?= $employee['id'] ?>');
		
		setTerms();
		
	})
</script>
<?php
$path=base_url().$this->Page_model->getConParam('img_base_path').$this->Page_model->getConParam('img_employee_path');
if(!empty($employee['term_text']))
	$terms=explode('%|%', $employee['term_text']);
else $terms=null;
?>


		<div id="lefthead" class="col-md-7 row-same-height" style="padding: 0">
			<div class="col-md-3 col-md-height col-middle highlight">
				<a href="<?= site_url('page/team') ?>"><span class="glyphicon glyphicon-arrow-left"></span>  Назад</a>
			</div>
			<div class="col-md-3 col-md-height col-middle">
			</div>
			<div class="col-md-6 col-md-height col-middle text-right highlight">
				<a href="#" id="checkout" data-target="<?=site_url('page/checkout')?>">Оформить заказ  <span class="glyphicon glyphicon-ok"></span></a>
			</div>
		</div>
		<div id="leftbody90">
			<div class="employee emsingle row-same-height">
				<div class="col-md-4 col-md-height col-middle">
					<img class="img-circle" src="<?php echo $path.$employee['id'].'/'.$employee['photo'];?>" width="100%" height="auto">
				</div>
				<div class="col-md-8 col-md-height col-middle">
					<div>
						<span class="subhead"><?= $employee['name'] ?></span><br>
						<span><?= $employee['specname'] ?></span>
					</div>
					<div style="margin-top: 15px">
						<?= $employee['qualification'] ?>
					</div>
				</div>
			</div>
			<hr>
			<a class="controlcar prev" data-target="#terms" href="#"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
			<a class="controlcar next" data-target="#terms" href="#"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
			<div id="terms" class="emsingle">
				<?php
				if($terms):
					foreach($terms as $term):
				?>
				<div class="row-same-height">
					<div class="col-md-height col-middle">
					<?= $term ?>
					</div>
				</div>
				<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
