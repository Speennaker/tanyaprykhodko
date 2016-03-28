<!DOCTYPE html>
<html lang="en">
<head>
	<!-- meta -->
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1, user-scalable=no" name="viewport">
 	<title><?=$page_title?></title>
	<?= js('jquery/jquery.js')?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<?= js('../css/bootstrap/dist/js/bootstrap.min.js')?>
	<?= js('uploadify/jquery.uploadify.min.js')?>
	<?= js('jquery/jquery.confirm.min.js')?>
	<?= js('jquery/jquery.datePicker.js')?>
  <?= js('blockScroll.js')?>
  <?= js('jquery.custom-scrollbar.min.js')?>
	<?= js('jquery/jquery.validate.min.js')?>
  <?= $this->current_language_short != 'en' ? js('jquery/localization/messages_'.$this->current_language_short.'.js') : ''?>
	<?= js('jquery/localization/datepicker-'.$this->current_language_short.'.js')?>
  <script type="text/javascript"> var base_url = '<?=base_url()?>'; var language = '<?=$this->current_language_short?>'; isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);</script>
  <?= js('main.js')?>
	<?= js('common.js')?>
	<?php foreach($custom_js as $r):?>
	<?= js($r)?>
	<?php endforeach;?>
	<?= css('../css/bootstrap/dist/css/bootstrap.min.css')?>
	<?= css('../js/uploadify/uploadify.css')?>
	<link rel="stylesheet" href="https://cdn.rawgit.com/daneden/animate.css/master/animate.css">
	<?= css('blockScroll.css')?>
	<?= css('jquery.custom-scrollbar.css')?>
	<?= css('photoswipe.css')?>
	<?= css('photoswipe_default-skin/default-skin.css')?>
	
	<?= css('main.css')?>
	<?= css('common.css')?>
	<script type="text/javascript"> var contacts = '<?=isset($contacts) ? $contacts : 0;?>'</script>
	<!-- fonts -->
	<link href='https://fonts.googleapis.com/css?family=Exo+2:400,300,100,200,500,600,700,300italic,500italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
</head>
<body class="<?=$this->custom_body_class?>">
<div class="body-wrap">