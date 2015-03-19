<?php
$path=base_url().$this->Page_model->getConParam('img_base_path').$this->Page_model->getConParam('img_blog_path');
if(empty($id)) $maxid=$this->Page_model->selectMax('blog', 'id');
?>
		<div id="lefthead">
			<span>Записи в Блоге</span>
		</div>
		<div id="leftbody" class="customscroll">
				<?php
					$i=0;
					foreach($blog as $item):
						if(empty($id) && $maxid==$item['id']):
				?>
						<div class="bloghead row active">
					<?php
						elseif(empty($id)):
					?>
						<div class="bloghead row">
						<?php
						else:
							if(!empty($id) && $id==$item['id']):
						?>
							<div class="bloghead row active">
							<?php
							else:
							?>
							<div class="bloghead row">
							<?php
							endif;
							?>
						<?php
						endif;
						?>
						<div class="row-same-height highlight">
							<div class="col-md-2 col-md-height col-middle">
								<?php if (!empty($item['photo'])):?>
									<a class="getblog" href="<?= site_url('page/blog/'.$item['id'])?>"><img src="<?php echo $path.$item['id'].'/'.$item['photo'];?>" width="100%" height="auto"></a>
								<?php else:?>
									<a class="getblog" href="<?= site_url('page/blog/'.$item['id'])?>"><img src="<?=base_url('img/nophoto.jpg') ?>" width="100%" height="auto"></a>
								<?php endif;?>
							</div>
							<div class="col-md-10 col-md-height col-middle">
								<a class="getblog" href="<?= site_url('page/blog/'.$item['id'])?>"><span class="subhead"><?php echo $item['name'];?></span><br>
								<span><?php echo mdate("%d %F %Y", mysql_to_unix($item['date']));?></span></a>
							</div>
						</div>
					</div>
			<?php
						$i++;
					endforeach;
			?>
		</div>
		<div id="pagination" class="text-center" data-target="#leftblock">
			<?php
				echo $this->pagination->create_links();
				$curr=$this->pagination->cur_page;
				$total=ceil ($this->pagination->total_rows/$this->pagination->per_page);
				echo "$curr/$total";
				//echo $this->pagination->next_tag_open.$this->pagination->next_link.$this->pagination->next_tag_close;
			?>
		</div>