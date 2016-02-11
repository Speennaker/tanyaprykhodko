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
  <?= js('blockScroll.js')?>
  <?= js('jquery.custom-scrollbar.min.js')?>
	<?= js('jquery/jquery.validate.min.js')?>
  <?= $this->current_language_short != 'en' ? ('jquery/localization/messages_'.$this->current_language_short.'.js') : ''?>
  <script type="text/javascript"> var base_url = '<?=base_url()?>'; var language = '<?=$this->current_language_short?>'; isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);</script>
  <?= js('main.js')?>
	<?php foreach($custom_js as $r):?>
	<?= js($r)?>
	<?php endforeach;?>
	<?= css('../css/bootstrap/dist/css/bootstrap.min.css')?>
	<?= css('../js/uploadify/uploadify.css')?>
	<link rel="stylesheet" href="https://cdn.rawgit.com/daneden/animate.css/master/animate.css">
	<?= css('blockScroll.css')?>
	<?= css('jquery.custom-scrollbar.css')?>
	<?= css('main.css')?>
	<?= css('common.css')?>
	<!-- fonts -->
	<link href='https://fonts.googleapis.com/css?family=Exo+2:400,300,100,200,500,600,700,300italic,500italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
</head>
<body>
