jQuery(document).ready(function($) {

	var sortList = $( 'ul#custom-type-list' );  
	var animation = $( '#loading-icon' );
	var pageTitle = $( 'div h2' );

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
									action : 'save_post',
									order : sortList.sortable('toArray').toString(),
									security : wishdd_localize.security
								   },
				
					success		: function(response)
									{
										$('div#message').remove();
										animation.hide();
										pageTitle.after("<div id='message' class='updated below-h2'><p>" + wishdd_localize.success_msg + "</p></div>");
										//console.log("success");
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