<!DOCTYPE html>
<html lang="en">
<head>
	<!-- meta -->
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1" name="viewport">
 	<title><?=$page_title?></title>
	<?= js('jquery/jquery.js')?>
	<?= js('../css/bootstrap/dist/js/bootstrap.min.js')?>
	<?= js('uploadify/jquery.uploadify.min.js')?>
	<?= js('jquery/jquery.confirm.min.js')?>
	<?= js('jquery/jquery.validate.min.js')?>
	<?= $this->current_language_short != 'en' ? ('jquery/localization/messages_'.$this->current_language_short.'.js') : ''?>
    <?= js('blockScroll.js')?>
    <script type="text/javascript"> var base_url = '<?=base_url()?>'; var language = '<?=$this->current_language_short?>'</script>
    <?= js('main.js')?>
	<?php foreach($custom_js as $r):?>
		<?= js($r)?>
	<?php endforeach;?>
	<?= css('../css/bootstrap/dist/css/bootstrap.min.css')?>
	<?= css('../js/uploadify/uploadify.css')?>
	<?= css('../js/jquery_validate/demo/css/cmxform.css')?>
	<?= css('blockScroll.css')?>
	<?= css('main.css')?>
	<?= css('common.css')?>
	<!-- fonts -->
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
</head>
<body>
