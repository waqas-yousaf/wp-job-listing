<?php
	
	function wishdd_job_taxonomy_list($atts, $content = null)
	{
		$atts = shortcode_atts(['title' => 'Jobs Openings Availible at '

								], $atts);

		$locations = get_terms('Location');

		if(!empty($locations) && !is_wp_error($locations))
		{
			$output  = "<div id='job-location-list'>";
			$output .= "<h4>".esc_html__($atts['title'])."</h4> <ul>";

			foreach($locations as $location)
			{
				$output .= "<li id='job-location'><a href='" .esc_url(get_term_link($location)). "'>";
				$output .= esc_html__($location->name). "</a></li>";
			}

			$output .= "</ul> </div>";

			return $output;
			//print_r($locations);
		}
	}

	add_shortcode("wishdd_jobs_list", "wishdd_job_taxonomy_list");