<?php

	// WP SHORT CODES EXAMPLE 
	// Using [wishdd_first title="ABCD"] on a page

	function wishdd_first_shortcode($attributes, $content = null)
	{
		
		$attributes = shortcode_atts(["title" => "Default Title", "src" => "http://google.com"] , $attributes); //default values for shortcode parameters

		return 	"<h3>".$attributes["title"]."</h3>".
				"<a href='".$attributes["src"]."'> Link </a> <br />".
				$content;
	}

	add_shortcode("wishdd_first", "wishdd_first_shortcode");
	
	// write [wishdd_first] anywhere on some page, it would show simply "My First Short Code" 
	// Try not using print or echo for output because it would simple showup before post content. Use return instead
	// If you use [wishdd_first] blah blah blah [/wishdd_first] blah blah blah will be passed on as $content