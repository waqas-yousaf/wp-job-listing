<?php

// Register Posttype 'job'
function wishdd_register_job(){
	
	$singular 	= 'Job Listing';
	$plural 	= 'Job Listings';

	// ----- Labels
	$labels = [	"name" 				=> $plural,
				"singular_name" 	=> $singular,
				"add_name"			=> 'Add New',
				"add_new_item"		=> 'Add New '.$singular,
				'edit'		      	=> 'Edit',
				'edit_item'	        => 'Edit ' . $singular,
				'new_item'	      	=> 'New ' . $singular,
				'view' 				=> 'View ' . $singular,
				'view_item' 		=> 'View ' . $singular,
				'search_term'   	=> 'Search ' . $plural,
				'parent' 			=> 'Parent ' . $singular,
				'not_found' 		=> 'No ' . $plural .' found',
				'not_found_in_trash' => 'No ' . $plural .' in Trash'
				 ];


	// ----- Post Type Parameters 
	$args = [	'labels'			 => $labels,
				'public'             => true,
		        'publicly_queryable' => true,
		        'show_ui'            => true,
		        'show_in_menu'       => true,
		        'show_in_nav_menus'  => true,
		        'show_in_admin_bar'  => true,
		        'exclude_from_search'=> false,
		        'menu_position'  	 => 10,
		        'menu_icon'          => 'dashicons-businessman',
		        'can_export'  		 => true,
		        'delete_with_user'	 => false,
		        'query_var'          => true,
		        'capability_type'    => 'page',
		        'has_archive'        => true,
		        'map_meta_cap'		 => true,
		        'hierarchical'       => false,
		        'menu_position'      => 10,
		        'rewrite'            => ['slug' => 'job', 'with_front' => true, 'pages' => true, 'feeds' => false ],
		        'supports'           => ['title']
	       //    'supports'           => ['title', 'editor', 'author', 'custom-fields' ]
	       
	        ];

	//register new post type called 'job'
	register_post_type('job', $args);

}

//Initialize Post regiter function
add_action('init', 'wishdd_register_job');








// --- Create Taxonomy Function
function wishdd_taxonomy_location()
{
	$singular 	= 'Location';
	$plural 	= 'Locations';
	$slug 		= str_replace( ' ', '_', strtolower( $singular ) );

$labels = [	'name'                       => $plural,
	        'singular_name'              => $singular,
	        'search_items'               => 'Search ' . $plural,
	        'popular_items'              => 'Popular ' . $plural,
	        'all_items'                  => 'All ' . $plural,
	        'parent_item'                => null,
	        'parent_item_colon'          => null,
	        'edit_item'                  => 'Edit ' . $singular,
	        'update_item'                => 'Update ' . $singular,
	        'add_new_item'               => 'Add New ' . $singular,
	        'new_item_name'              => 'New ' . $singular . ' Name',
	        'separate_items_with_commas' => 'Separate ' . $plural . ' with commas',
	        'add_or_remove_items'        => 'Add or remove ' . $plural,
	        'choose_from_most_used'      => 'Choose from the most used ' . $plural,
	        'not_found'                  => 'No ' . $plural . ' found.',
	        'menu_name'                  => $plural];


	$args = [	'hierarchical'       	=> true,
            	'labels'                => $labels,
            	'show_ui'               => true,
            	'show_admin_column'     => true,
            	'update_count_callback' => '_update_post_term_count',
            	'query_var'             => true,
            	'rewrite'               => [ 'slug' => $slug ]
            ];

	register_taxonomy('Location', 'job', $args);

}


// --- Register Taxonomy Function
add_action('init', 'wishdd_taxonomy_location');