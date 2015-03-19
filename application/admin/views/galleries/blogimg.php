<script>
$(function(){
	$('.pagination a').on('click', function(e){
		e=e||window.event;
		e.preventDefault();
		var urlloc=$(this).attr('href');
		$('#bloggallitems').load(urlloc);
	});
});
</script>
<table class="table table-striped">
	<tr>
<?php
		$path=base_url($this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_blog_path')).'/';
		$i=0;
		foreach ($blogimg as $item):
			$i++;
?>
				<td class="col-lg-15" id="blogimgid_<?php echo $item['id']?>">
					<div class="thumbnail">
						<img src="<?php echo $path.$item['path']?>" alt="<?php echo $item['name']?>" name="<?php echo $item['name']?>" width="100%" height="auto">
						<div class="caption">
							<p class="text-center">
								<span class="imgwidth label label-default"><?php echo $item['width']?></span>
								<span>&times;</span>
								<span class="imgheight label label-default"><?php echo $item['height']?></span>
							</p>
							<p class="text-center">
								<a class="tinyInsert btn btn-default btn-xs" href="#">Вставить</a>
								<a class="bloggalldelete btn btn-danger btn-xs" data-name="<?php echo $item['path']?>" href="<?= site_url("admincontroller/deletePage/blogimg/{$item['id']}/true") ?>">Удалить</a>
							</p>
						</div>
					</div>
				</td>
<?php
			if($i%5==0) echo '</tr><tr>';
		endforeach;
?>
	</tr>
</table>
<?=$this->pagination->create_links();?>