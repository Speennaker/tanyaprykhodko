<script type="text/javascript">
	(function(){
		var body = document.querySelector('body'),
				className = 'about-me_page';
		body.classList.add(className);
	}());
</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-3 col-sm-4">
			<br>
			<table class="contacts-table">
				<tr>
					<td><span class='i-entypo'>&#xe724;</span></td>
					<td><?=lang('dubai')?></td>
				</tr>
				<tr>
					<td><span class='i-entypo'>&#x2709;</span></td>
					<td><a target="_blank" href="mailto:info@tanyaprikhodko.com">info@tanyaprikhodko.com</a></td>
				</tr>
				<tr>
					<td><span class='i-entypo'>&#x1f4de;</span></td>
					<td>+971553288414</td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="wrapper">
							<a href="https://www.facebook.com/TanyaPrykhodkoPhotography/?fref=ts" target="_blank"><div class="social">&#62220;</div></a>
							<a href="https://500px.com/tanyaprykhodko" target="_blank"><div class="social entypo-infinity"></div></a>
							<a href="https://www.instagram.com/tanyas_angels_be_like/" target="_blank"><div class="social">&#xf32d;</div></a>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="col-md-9 col-sm-8 about-me_article">
			<div class="default-skin" style="height:500px;">
				<br>
				<p class="about-me_article_title"><?=lang('about_me')?></p>
				<div class="row">
					<div class="col-xs-12">
						<img src="<?=asset_url()?>/images/tan.jpg" class="pull-left main-img"  alt="">
						<?=lang('about_me_text')?>
						<br>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- navigation -->
	<?=$this->load->view('_blocks/nav_panel', [], true);?>
	<!-- /navigation -->
</div>

<script>
(function(){
	var el = document.querySelector('.default-skin'),
			footerHeight = document.querySelector('.b_page-nav_wrapper').clientHeight,
			h = window.innerHeight - footerHeight;
	el.style.height = h +'px';
})();
</script>