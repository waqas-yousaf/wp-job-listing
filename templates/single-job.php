<?php
		get_header();
?>

<div id="primary" class="content-area" style="width:100% !important;">
<main id="main" class="site-main" role="main">
<?php

		print "Wishdd's Job SINGLE PAGE";
		
		global $post;
		$wishdd_stored_meta = get_post_meta($post->ID);
		print get_the_title($post );
		print "<pre>";
		print_r($wishdd_stored_meta);


?>		

	</main><!-- .site-main -->


</div><!-- .content-area -->

<?php get_footer(); ?>