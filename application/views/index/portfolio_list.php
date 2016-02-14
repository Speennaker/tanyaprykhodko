<?php

?>
<?=$this->load->view('_blocks/portfolio_header', [], true);?>


<!-- portfloio grid -->
<section>
	<div class="gallery_grid clearfix">
		<!-- portfolio item  -->
		<figure class="gallery_grid_item is-2x">
			<!-- link -->
			<a href="portfolio/portfolio_Id">
	      <div class="img-wrap">
		      <!-- image -->
	        <img src="https://unsplash.it/700/500?image=11" alt="Image description" itemprop="thumbnail">
	      </div>
	      <!-- info -->
	      <div class="gallery_grid_item_desc">
	      	<table>
	      		<tr>
	      			<td>
		      			<!-- name -->
	      				<p>Album Name</p>
	      				<!-- description -->
			        	<p>Shot Album Description</p>
	      			</td>
	      		</tr>
	      	</table>
	      </div>
			</a>
    </figure>
		<!-- / portfolio item  -->


	</div>
</section>
<!-- / portfloio grid -->

<!-- navigation -->
<?=$this->load->view('_blocks/nav_panel', [], true);?>
<!-- /navigation -->