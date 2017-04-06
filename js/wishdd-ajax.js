jQuery(document).ready(function($) {

	var sortList	= $( 'ul#custom-type-list' );  
	var animation	= $( '#loading-icon' );
	var pageTitle	= $( 'div h2' );

	sortList.sortable({
			update: function (event , UI)
			{
				animation.show();
				
				$.ajax(
				{
					url 		: ajaxurl,
					type 		: 'POST',
					dataType 	: 'json',
					data 		: {
									action : 'save_settings', // will be used as a dynamic hook in wishdd-settings.php
									order : sortList.sortable('toArray'), 
									security : wishdd_localize.security	// check out wishdd-job-listing wp_localize_script to understand this
								   },
				
					success		: function(response)
									{
										$('div#message').remove();
										animation.hide();
										if(response.success == true)
										{
											pageTitle.after("<div id='message' class='updated below-h2'><p>" + wishdd_localize.success_msg + "</p></div>");
											//console.log('done');
										}
										else
										{
											pageTitle.after("<div id='message' class='error below-h2'><p>" + wishdd_localize.fail_msg + " </p></div>");
										}
									},
					
					error		: function(error)
									{
										$('div#message').remove();
										animation.hide();
										pageTitle.after("<div id='message' class='error below-h2'><p>" + wishdd_localize.fail_msg + " </p></div>");
										//console.log("error");
									} 
				})
			}
	});

});