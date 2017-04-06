<?php
/*
Plugin Name: Wishdd Jobs Listing
Plugin URI: http://wishdd.com/
Description: Wishdd Job Listing.
Version: 1.0
Author: Waqas Yousaf / Tehmina Aslam
Author URI: http://wishdd.com/
Author Email: support@wishdd.com
License: GPLv2
*/

// Exit if not logged-in
if (!defined('ABSPATH')) {
	exit;
}

// Load Custom Post Type (CPT) Module 
require_once ( plugin_dir_path(__FILE__) . "wishdd-cpt.php");

// Load Custom Meta Fields 
require_once ( plugin_dir_path(__FILE__) . "wishdd-custom-fields.php");

// Load Settings Page
require_once ( plugin_dir_path(__FILE__) . "wishdd-settings.php");



//Adding Resouces
function wishdd_add_resources()
{
	global $pagenow, $typenow;

	//If pagenow is post.php or post-new.php or post type is job
	
	if ($typenow =="job")
	 {
		// Enqueue Admin CSS
		wp_enqueue_style("wishdd_admin_css", plugins_url('css/admin.css', __FILE__));

	}

	if( (($pagenow == "post.php") || ($pagenow == "post-new.php")) && $typenow =="job" )
	{
		
		// Enqueue JQuery CSS
		wp_enqueue_style("wishdd_jquery_style", plugins_url('css/jquery-ui.css', __FILE__));
		
		// Enqueue Admin JS with depandency such as JQuery and jquery-ui-picker
		wp_enqueue_script("wishdd_admin_js", plugins_url('js/admin.js', __FILE__), array('jquery', 'jquery-ui-datepicker'), '20170403', true );

		// Enqueue Quick Tages JS with depandency quicktags
		wp_enqueue_script( 'wishdd-custom-quicktags', plugins_url( 'js/wishdd-quicktags.js', __FILE__ ), array( 'quicktags' ), '20170403', true );
	}

	if($pagenow == "edit.php" && $typenow == "job")
	{
		wp_enqueue_script( 'wishdd-ajax', plugins_url( 'js/wishdd-ajax.js', __FILE__ ), array( 'jquery', 'jquery-ui-sortable' ), '20170317', true );
		
		$wp_localize_array = [	'security'		=> wp_create_nonce('wp_settings_order'),
								'siteUrl'		=> get_bloginfo('url'),
								'success_msg'	=> __( 'Jobs order saved.' ),
								'fail_msg'		=> __( 'Error Saving Job Order' )
							];

		wp_localize_script( 'wishdd-ajax', 'wishdd_localize', $wp_localize_array );	
	}

}

add_action('admin_enqueue_scripts' , 'wishdd_add_resources');





