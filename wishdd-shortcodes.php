<?php
	
	function wishdd_locations_list($atts, $content = null)
	{
		$atts = shortcode_atts(['title' => 'Jobs Openings Availible at '

								], $atts);

		$title = esc_html__($atts['title']);
	
		$locations = get_terms('Location');
	
		if(!empty($locations) && !is_wp_error($locations))
		{
			$output  = "<div id='job-location-list'>";
			$output .= "<h4>". $title ."</h4> <ul>";

			foreach($locations as $location)
			{
				$name  = esc_html__($location->name);
				$url   = esc_url(get_term_link($location));
		
				$output .= "<li id='job-location'><a href='" .$url. "'>";
				$output .= $name . "</a></li>";
			}

			$output .= "</ul> </div>";

			return $output;
			//print_r($locations);
		}
	}

add_shortcode("wishdd_locations_list", "wishdd_locations_list");


function wishdd_job_by_location($atts, $content = null)
{
	if(! isset($atts['location']))
		return '<p class="job-error">Please set a location</p>';

		$atts = shortcode_atts(['title' 		=> 'Jobs Openings Availible at ',
								'count' 		=> 5 ,
								'location'		=> '',
								'pagination'	=> false
								], $atts);

		$paged = get_query_var('paged') ? get_query_var('paged') : 1;

		$args = [	'post_type'				 => 'job',
					'post_status'			 => 'publish',
					'orderby'			   	 => 'menu_order',	// Order By
					'order'					 => 'ASC',			// Ascending
					'no_found_rows' 		 => $atts['pagination'],
					'posts_per_page' 		 => $atts['count'],
					'paged'					 => $paged,
					'tax_query'				 => ['taxonony' => 'location',
												 'field' => 'slug',
												 'terms' => $atts['location']
												]

				];

		$jobs_locations = new WP_Query($args);


		$location = str_replace ('-', ' ', $atts['location']);
		$title 	  = esc_html__($atts['title']);
		$location = esc_html__($atts['location']);
		
		if( $jobs_locations-> have_posts())
		{
			$output  = "<div id='job-location-list'>";
			$output .= "<h4>".$title."  " .$location." </h4> <ul>";

			while ($jobs_locations-> have_posts()) : $jobs_locations-> the_post();

			global $post;

			$deadline	= esc_html__(get_post_meta( get_the_id() , 'deadline', true ));
			$title		= get_the_title();
			$url		= esc_url( get_permalink() );
			
			$output .= "<li id='job-location'><a href='" .$url. "'>";
			$output .= $title."</a>";
			$output .= " // <span>".$deadline. "</span></li>";

			endwhile;
			
			$output .= "</ul> </div>";

		}

		wp_reset_postdata();
		return $output;

}

add_shortcode("wishdd_job_by_location", "wishdd_job_by_location");


