<?php
$path=base_url().$this->Page_model->getConParam('img_base_path').$this->Page_model->getConParam('img_employee_path');
asort($spec, SORT_NATURAL);
//var_dump($spec);
?>

		<div id="lefthead" class="col-md-7 row-same-height" style="padding: 0">
			<div class="col-md-8 col-md-height col-middle">
				<span><?= $currspec ?></span>
			</div>
			<div class="col-md-4 col-md-height col-middle highlight">
				
				<a href="#" id="dropdownMenu" data-toggle="dropdown" aria-expanded="true" style="width: 100%" class="row-same-height">
					<span class="col-md-11 col-md-height col-middle">Фильтр</span><span class="glyphicon glyphicon-filter col-md-1 col-md-height col-middle" style="float: right;"></span>
				</a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
					<li role="presentation"><a class="filter" role="menuitem" tabindex="-1" href="<?= site_url('page/team/all') ?>" data-target="#leftblock">Все</a></li>
					<?php
						foreach($spec as $key=>$val):
					?>
					<li role="presentation"><a class="filter" role="menuitem" tabindex="-1" href="<?= site_url('page/team/'.$key)?>" data-target="#leftblock"><?= $val ?></a></li>
					<?php
						endforeach;
					?>
				</ul>
				
				
			</div>
		</div>
		<div id="leftbody90" class="customscroll">
			<?php
				if(empty($employee)):
			?>
				<span>Нет ни одной записи</span>
			<?php
				else:
					$i=0;
					foreach($employee as $item):
					?>
					<div class="employee row">
						<div class="row-same-height highlight">
							<div class="col-md-2 col-md-height col-middle">
								<?php if (!empty($item['photo'])):?>
									<a class="getblog" href="<?= site_url('page/employee/'.$item['id'])?>"><img class="img-circle" src="<?php echo $path.$item['id'].'/'.$item['photo'];?>" width="100%" height="auto"></a>
								<?php else:?>
									<a class="getblog" href="<?= site_url('page/employee/'.$item['id'])?>"><img class="img-circle" src="<?=base_url('img/nophoto.jpg') ?>" width="100%" height="auto"></a>
								<?php endif;?>
							</div>
							<div class="col-md-10 col-md-height col-middle">
								<a class="getblog" href="<?= site_url('page/employee/'.$item['id'])?>"><span class="subhead"><?php echo $item['name'];?></span><br>
								<span><?php echo $spec[$item['id']];?></span></a>
							</div>
						</div>
					</div>
			<?php
						$i++;
					endforeach;
				endif;
			?>
		</div>
