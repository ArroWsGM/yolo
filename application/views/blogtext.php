	<h3><?php echo $blog['name'];?></h3>
	<h5><?php echo locMonth(mdate("%d %F %Y", mysql_to_unix($blog['date'])));?></h5>
<?php
	echo $blog['text'];
?>