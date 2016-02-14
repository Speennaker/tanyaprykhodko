<?php

?>
<style type="text/css">
	.b_page-nav{
		background: rgb(26, 26, 26) none repeat scroll 0% 0%;		
	}
</style>
<!-- portfolio header -->
<header class="portfolio-page_header">
	<div class="container-fluid">
	  <div class="col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 text-center">
		  <a href="/">
		    <img src="assets/images/logo_on-dark.png" alt="">		  	
		  </a>
	  </div>
	</div>
</header>
<!-- / portfolio header -->


<!-- portfloio grid -->
<section>
	<div class="gallery_grid clearfix">
		<!-- portfolio item  -->
		<figure class="gallery_grid_item is-2x">
			<!-- link -->
      <a href="#">
	      <!-- image -->
        <img src="https://unsplash.it/700/500?image=11" alt="Image description" itemprop="thumbnail">
      </a>
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
    </figure>
		<!-- / portfolio item  -->


	</div>
</section>
<!-- / portfloio grid -->

<!-- navigation -->
<?=$this->load->view('_blocks/nav_panel', [], true);?>
<!-- /navigation -->

<!-- remove context menu  -->
<script type="text/javascript">
	document.body.oncontextmenu = function(){return false};
</script>