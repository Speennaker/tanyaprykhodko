<?php

?>
<?=$this->load->view('_blocks/portfolio_header', [], true);?>


<!-- portfloio grid -->
<section>
	<div class="gallery_grid clearfix">
		<?php foreach($albums as $album):?>

			<!-- portfolio item  -->
			<figure class="gallery_grid_item is-2x">
				<!-- link -->
				<a href="<?=base_url('portfolio/'.$album['breadcrumb'])?>">
					<div class="img-wrap">
						<!-- image -->
						<img src="<?=$album['cover']?>" alt="<?=$album['title']?>" itemprop="thumbnail">
					</div>
					<!-- info -->
					<div class="gallery_grid_item_desc">
						<table>
							<tr>
								<td>
									<!-- name -->
									<p><?=$album['title']?></p>
									<!-- description -->
									<p><?=$album['description']?></p>
								</td>
							</tr>
						</table>
					</div>
				</a>
			</figure>
			<!-- / portfolio item  -->
		<?php endforeach;?>


	</div>
</section>
<!-- / portfloio grid -->

<!-- navigation -->
<?=$this->load->view('_blocks/nav_panel', [], true);?>
<!-- /navigation -->