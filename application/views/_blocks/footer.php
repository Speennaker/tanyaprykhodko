<!-- scripts -->
<?= js('jquery/jquery.js')?>
<?= js('../css/bootstrap/dist/js/bootstrap.min.js')?>
<?= js('uploadify/jquery.uploadify.min.js')?>
<script type="text/javascript"> var base_url = '<?=base_url()?>';</script>
<?= js('blockScroll.js')?>
<?= js('main.js')?>
<?php foreach($custom_js as $r):?>
	<?= js($r)?>
<?php endforeach;?>
</body>
</html>
