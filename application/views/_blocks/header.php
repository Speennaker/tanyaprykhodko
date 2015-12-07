<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1" name="viewport">
 	<title><?=lang($menu_item.'_page_title')?></title>
	<?= js('jquery/jquery.js')?>
	<?= js('../css/bootstrap/dist/js/bootstrap.min.js')?>
	<?= js('uploadify/jquery.uploadify.min.js')?>
    <script type="text/javascript"> var base_url = '<?=base_url()?>';</script>
    <?= js('main.js')?>
	<?php foreach($custom_js as $r):?>
		<?= js($r)?>
	<?php endforeach;?>
	<?= css('../css/bootstrap/dist/css/bootstrap.min.css')?>
	<?= css('../js/uploadify/uploadify.css')?>
	<?= css('main.css')?>

</head>
<body>




