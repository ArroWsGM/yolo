<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title ?></title>
	<link href="<?= base_url() ?>bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url() ?>css/admin.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="<?= base_url() ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>js/jquery.form.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>js/script.js"></script>
	<script type="text/javascript">
		$(function(){
			url='<?= site_url('admincontroller') ?>'+'/';
		})
		
	</script>

</head>

<body>
<div class="container">
