<?php
$path=base_url().$this->Page_model->getConParam('img_base_path').$this->Page_model->getConParam('img_certificates_path');
//asort($spec, SORT_NATURAL);
//var_dump($spec);
?>
<div id="mainframe">
	<div id="leftblock">
		<div id="lefthead" class="col-md-7 row-same-height" style="padding: 0">
			<div class="col-md-8 col-md-height col-middle">
				<span>Сертификаты</span>
			</div>
			<div class="col-md-4 col-md-height col-middle highlight">
				
				<a href="#" id="dropdownMenu" data-toggle="dropdown" aria-expanded="true" style="width: 100%" class="row-same-height">
					<span class="col-md-11 col-md-height col-middle">Фильтр</span><span class="glyphicon glyphicon-filter col-md-1 col-md-height col-middle" style="float: right;"></span>
				</a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
					<li role="presentation"><a class="filter cert" role="menuitem" tabindex="-1" href="<?= site_url('page/cert/all') ?>" data-target="#leftblock">Все</a></li>
					<?php
						foreach($cf as $val):
							//var_dump($val);
					?>
					<li role="presentation"><a class="filter cert" role="menuitem" tabindex="-1" href="<?= site_url('page/cert/'.$val['id'])?>" data-target="#leftblock" data-min="<?=$val['min']?>" data-max="<?=$val['max']?>"><?= $val['name'] ?></a></li>
					<?php
						endforeach;
					?>
				</ul>
				
				
			</div>
		</div>
		<div id="leftbody90" class="customscroll" style="overflow-y: auto">
			<?php
				if(empty($cert)):
			?>
				<span>Нет ни одной записи</span>
			<?php
				else:
					$i=0;
					foreach($cert as $item):
					?>
					<div class="cert row">
						<div class="row-same-height highlight">
							<div class="col-md-2 col-md-height col-middle">
								<?php if (!empty($item['photo'])):?>
									<a class="getblog" href="<?= site_url('page/certtext/'.$item['id'])?>"><img class="img-circle" src="<?php echo $path.$item['id'].'/'.$item['photo'];?>" width="100%" height="auto"></a>
								<?php else:?>
									<a class="getblog" href="<?= site_url('page/certtext/'.$item['id'])?>"><img class="img-circle" src="<?=base_url('img/nophoto.png') ?>" width="100%" height="auto"></a>
								<?php endif;?>
							</div>
							<div class="col-md-10 col-md-height col-middle">
								<a class="getblog" href="<?= site_url('page/certtext/'.$item['id'])?>"><span class="subhead"><?php echo $item['name'];?></span><br>
								<span><?php echo $item['price'];?></span></a>
							</div>
						</div>
					</div>
			<?php
						$i++;
					endforeach;
				endif;
			?>
		</div>
	</div>
	<div id="gallery">
		<div id="righthead" style="line-height: 1;">
			<span><?= $cert[0]['name'];?></span><br>
			<span style="font-size: 1vw">Стоимость: <?= $cert[0]['price'];?> грн.</span>
		</div>
		<div class="col-md-12" style="margin-top: 3%">
			<p><?php echo $cert[0]['text'];?></p>
		</div>
		<img class="aboutimg" src="<?=base_url('img/cert.jpg') ?>" width="100%" height="auto">
	</div>
</div>