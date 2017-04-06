<?php
// Adding setting Sub-menu
function wishdd_settings_menu()
{

add_submenu_page(
				  'edit.php?post_type=job', // Parent Slug
				  'Job Listing Settings',	// Page Title
				  'Settings',				// Menu Title
    			  'manage_options',			// 	Capability
    			  'wishdd_settings',		// Slug
    			  'wishdd_settings_page');  // Call back Function
}

add_action('admin_menu', 'wishdd_settings_menu');
	


// Call Back Function
function wishdd_settings_page()
{
	$args = [	'post_type' 			 => 'job',			// Page_Type = job 
				'orderby'			   	 => 'menu_order',	// Order By
				'order'					 => 'ASC',			// Ascending
				'post_status'			 => 'publish',		// Status = published
				'no_found_rows' 		 => true,
				'update_post_term_cache' => false,
				'post_per_post' 		 => 50
			];

	$listing = new WP_Query($args);

?>
	<div class="wrap" id="job-sort">
	<!--	<div id="icon-job-admin" class="icon32"> -->
			<h2><?php _e('Sort Job Positions' , 'wp-job-listing') ?>
				<img src="<?= esc_url( admin_url() . '/images/loading.gif' ); ?>" id="loading-icon">
			</h2>	
			<?php 
				if ($listing->have_posts()): ?>
				<p><strong>NOTE:</strong> BLAH BLAH BLAH</p>
				
				<ul id="custom-type-list">
					<?php 
						while ($listing->have_posts() ): $listing->the_post();	
					 ?>
					<li id="<?php esc_attr(the_id());?>"> <?php esc_html(the_title()); ?></li>
					<?php endwhile;	 ?>
				 </ul>
			<?php else: ?>
				<p>No Jobs to Sort!</p>
			<?php endif ?>
		<!--</div> -->
	</div>


<?php

}


function wishdd_save_settings()
{
	 /* First param is nonce we declared in wp-job-listing.php 2nd
	 	is variable security we defined over wishdd-ajax.js.
	 	Confusing? lol
	 */

	if(! check_ajax_referer('wp_settings_order','security') )
	{
		wp_send_json_error('Invalid Security Token'); //wp builtin funcion to send json data. 
	}
	if (! current_user_can('manage_options') )
	{
		wp_send_json_error('Hold on a sec, Cow Boy!'); //wp builtin funcion to send json data. 
	}

	$order_list = $_POST['order'];

	$count = 0;

	foreach($order_list as $order_item)
	{
		
		$content = [	'ID' 		=> (int)$order_item,
				 		'menu_order'=> $count
					];
		wp_update_post($content);
		
		$count++;
	}

	wp_send_json_success('Order Saved.');
	
}
add_action('wp_ajax_save_settings', 'wishdd_save_settings');

/*
	Action with Dynamic wordpress ajax Hook ---- first hook is from wishdd -ajax.js  " action : 'save_settings' " so
	it becomes wp_ajax_save_settings
*/ 