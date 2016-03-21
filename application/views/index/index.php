<script type="text/javascript"> var contacts = '<?=$contacts;?>'</script>
<div id="loader-wrapper">
	<div id="loader"></div><div class="loader-section section-left"></div><div class="loader-section section-right"></div>
</div>
<a href="<?=base_url('portfolio')?>" class="b_portfolio-label"><span><?= lang('portfolio')?></span></a>
<!-- [ wrapper -->
<div class="b_page-wrap">
	<div class="b_sections-container">
		<!-- intro screen -->
		<section class="b_section-wrap is-intro" data-id="1">
			<div class="ps-table">
				<div class="toAnimate" data-animtype="fadeInDown" data-animdyration="400">
					<div class="row">
						<div class="col-lg-10 avatar_wrap col-lg-offset-1 col-md-10 col-md-offset-1">
							<p><img src="<?=asset_url()?>/images/logo_on-dark.png" alt="Tania Prykhodko"></p>
						</div>
					</div>
				</div>
			</div>
			<!-- vertical align logo -->
			<script>
				(function(){
					verticalAlignLogo();
					window.addEventListener('resize', verticalAlignLogo, false);
					function verticalAlignLogo(){
						var il = document.querySelector('.ps-table');
						var ilPar = il.parentNode;
						il.style.marginTop = (ilPar.clientHeight/2) - (il.clientHeight/2) - 60 + 'px';
					}
				})();
			</script>
			<div class="scoll-down_ani">
				<svg class="scoll-down_ani_arrows"><path class="a1" d="M0 0 L30 32 L60 0"></path><path class="a2" d="M0 20 L30 52 L60 20"></path><path class="a3" d="M0 40 L30 72 L60 40"></path></svg>
			</div>
		</section>
		<!-- / intro screen -->

		<!-- 1 -->
		<section class="b_section-wrap blurred is-1 blurred" data-id="2">
			<div class="toAnimate" data-animtype="slideInLeft" data-animdyration="400">
				<p class="b_section_title is-white">Beauty</p>
			</div>
		</section>
		<!-- / 1 -->

		<!-- 2 -->
		<section class="b_section-wrap b_section_contacts blurred is-13 color-light" data-id="3">
			<div class="toAnimate" data-animtype="slideInDown" data-animdyration="400">
				<p class="b_section_title is-white">Desire</p>
			</div>
		</section>

		<!-- /2 -->


		<!-- 3 -->
		<section class="b_section-wrap blurred is-3" data-id="4">
			<div class="toAnimate" data-animtype="slideInDown" data-animdyration="400">
				<p class="b_section_title is-white">Elegance</p>
			</div>
		</section>
		<!-- /3 -->


		<!-- 4 -->
		<section class="b_section-wrap is-6 blurred" data-id="5">
			<div class="toAnimate" data-animtype="slideInDown" data-animdyration="400">
				<p class="b_section_title is-white">Infinity</p>
			</div>
		</section>
		<!-- /4 -->


		<!-- 5 -->
		<section class="b_section-wrap is-10 blurred" data-id="6">
			<p class="b_section_title is-white text-left">Tenderness</p>
		</section>
		<!-- /5 -->

		<!-- 6 -->
		<section class="b_section-wrap is-11 blurred" data-id="7">
			<div class="toAnimate" data-animtype="slideInDown" data-animdyration="400">
				<p class="b_section_title is-white">Royalty</p>
			</div>
		</section>
		<!-- /6 -->


		<!-- 7 -->
		<section class="b_section-wrap is-12 blurred" data-id="8">
			<span class="b_section_title is-white">Dream</span>
		</section>
		<!-- /7 -->

		<!-- 8 -->
		<section class="b_section-wrap b_section_contacts blurred is-7 color-light" data-id="9">
			<div class="toAnimate" data-animtype="slideInDown" data-animdyration="400">
				<p class="b_section_title is-white">Sophistication</p>
			</div>
		</section>
		<!-- /8 -->

		<!-- 9 -->
		<section class="b_section-wrap is-8 blurred" data-id="10">
			<div class="toAnimate" data-animtype="slideInDown" data-animdyration="400">
				<p class="b_section_title is-white">Emotions</p>
			</div>
		</section>
		<!-- /9 -->
		
		<!-- contact section -->
		<section class="b_section-wrap b_section_contacts blurred page_about-me" data-id="11" id="contacts">
			<div class="toAnimate" data-animtype="sliadeInLeft" data-animdyration="400">
				<div class="b_section_content_wrap">				
						<div class="row">
							<div class="b_section_content">
								<div class="col-md-3 col-sm-4 contacts-table_wrap">
									<table class="contacts-table">
										<tr>
											<td><span class='i-entypo'>&#xe724;</span></td>
											<td><?=lang('dubai')?></td>
										</tr>

										<tr>
											<td><span class='i-entypo'>&#x2709;</span></td>
											<td><a target="_blank" href="mailto:info@tanyaprykhodko.com">info@tanyaprykhodko.com</a></td>
										</tr>
										<tr>
											<td><span class='i-entypo'>&#x1f4de;</span></td>
											<td>+971553288414</td>
										</tr>
									</table>
								</div>
								<div class="col-md-9 col-sm-8">
									<div class="default-skin" id="contact_ov">
										<p class="b_section_title is-without_line"><?= lang('contacts')?>:</p>
										<br>
										<p><?= lang('contact_form_title')?></p>
										<div class="feedback_form">
											<form id="contact_form" method="post">
												<div class="form-group">
													<label for="name" class="control-label"><?= lang('contact_form_name')?> (<?= lang('required')?>)</label>
													<input type="text" class="form-control for_send" required="required" name="name">
												</div>
												<div class="form-group">
													<label for="email" class="control-label"><?= lang('contact_form_email')?> (<?= lang('required')?>)</label>
													<input type="email" required="required" class="form-control for_send" name="email">
												</div>
												<div class="form-group">
													<label for="subject" class="control-label"><?= lang('contact_form_subject')?></label>
													<input type="text" class="form-control for_send" name="subject">
												</div>
												<div class="form-group">
													<label for="date" class="control-label"><?= lang('contact_form_date')?></label>
													<input type="date" class="form-control datepicker for_send" name="date">
												</div>
												<div class="form-group">
													<label for="message" class="control-label"><?= lang('contact_form_message')?> (<?= lang('required')?>)</label>
													<textarea class="form-control for_send" name="message" required="required" id="" cols="30" rows="6"></textarea>
												</div>
												<div class="form-group">
													<button type="button" id="send_form" class="btn btn-default bnt-lg"><?= lang('send')?></button>
												</div>
											</form>

										</div>

										<div class="feedback_form" id="success_sent" hidden="hidden">
												<h1><?=lang('form_sent')?>!</h1>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- / end contact section -->

			<!-- page arrows -->
			<nav class="page-arrows">
				<span class="arrow" id="block-up-arrow"></span>
				<span class="arrow arrow-next" id="block-down-arrow"></span>
			</nav>
			<!-- / end arrows -->

			<!-- vertical dots -->
			<div class="vertical-dots-nav"><ul></ul></div>
			<!-- / vertical dots -->


			<!-- navigation -->
			<?=$this->load->view('_blocks/nav_panel', [], true);?>
			<!-- /navigation -->

			<script>
			(function(){
				function setHeiightForForm(){
					var el = document.querySelector('#contact_ov.default-skin');
					var innerHeight = 
							window.innerWidth < 767 ? 
							(document.querySelector('.contacts-table_wrap').clientHeight + document.querySelector('.b_page-nav_wrapper').clientHeight) :
							50 ;
					el.style.height = (window.innerHeight - innerHeight)+'px';
				};
				setHeiightForForm();
				window.addEventListener('resize', setHeiightForForm, false);

			})();
			</script>
	</div>
</div>
<!-- wrapper ] -->