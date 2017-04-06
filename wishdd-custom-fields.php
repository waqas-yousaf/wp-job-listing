<?php

	function wishdd_custom_metabox()
	{
		add_meta_box(	'wishdd_meta',
						__('Job Listing'),
						'wishdd_meta_callback',
						'job',
						'normal',
						'high');
	}

	add_action('add_meta_boxes', 'wishdd_custom_metabox');


	function wishdd_meta_callback($post)
	{
		wp_nonce_field(basename(__FILE__), 'wishdd_jobs_nonce'); //Nonce is used to ensure data isnt submitted from any other source

		$wishdd_stored_meta = get_post_meta($post->ID);
		
		//print "<pre>";
		//print_r($wishdd_stored_meta);
		//die();

		$job_id 		= !empty($wishdd_stored_meta['job_id']) ? $wishdd_stored_meta['job_id'][0] : "" ;
		$date_listed 	= !empty($wishdd_stored_meta['date_listed']) ? $wishdd_stored_meta['date_listed'][0] : "" ;
		$deadline 		= !empty($wishdd_stored_meta['deadline']) ? $wishdd_stored_meta['deadline'][0] : "" ;
		$min_req 		= !empty($wishdd_stored_meta['min_req']) ? esc_attr($wishdd_stored_meta['min_req'][0]) : "" ;
		$pre_req 		= !empty($wishdd_stored_meta['pre_req']) ? esc_attr($wishdd_stored_meta['pre_req'][0]) : "" ;
		$relocation 	= !empty($wishdd_stored_meta['relocation']) ? $wishdd_stored_meta['relocation'][0] : ""; 


// ----- Add Job Listing Form

?>
		<div>
			<div class='meta-row'>
				<div class='meta-th'>
					<label for='job-id' class='row-title'><?php _e("Job ID","wishdd_localize") ?></label>	
				</div>
				<div class='meta-td'>
					<input type='text' name='job_id' id='job_id' value='<?= $job_id ?>'>
				</div>
			</div>
			
			<div class='meta-row'>
				<div class='meta-th'>
					<label for='date_listed' class='row-title'><?php _e( 'Date Listed', 'wishdd_localize' ) ?></label>	
				</div>
				<div class='meta-td'>
					<input type='text' name='date_listed' id='date_listed' class='date-picker' value='<?= $date_listed ?>'>
				</div>
			</div>
		
			<div class='meta-row'>
				<div class='meta-th'>
					<label for='deadline' class='row-title'><?php _e( 'Application Deadline', 'wishdd_localize' ) ?></label>	
				</div>
				<div class='meta-td'>
					<input type='text' name='deadline' id='deadline' class='date-picker' value='<?= $deadline ?>'>
				</div>
			</div>

		<div class='meta-row'>
			<div class='meta-th'>
				<span><?php _e( 'Principle Duties', 'wishdd_localize' ) ?></span>
			</div>
		</div>
		<div class="meta-editor">
<?php
				$content  = get_post_meta($post->ID, 'principle_duties', true);
				$editor   = 'principle_duties';
				$settings = ['textarea_rows'=> 7, 'media_buttons'=> false];

				wp_editor($content, $editor, $settings);	
?>			
		</div>
		<div class="meta-row">
	        <div class="meta-th">
	          <label for="minimum-requirements" class="wishdd-row-title"><?php _e( 'Minimum Requirements', 'wishdd_localize' ) ?></label>
	        </div>
	        <div class="meta-td">
	          <textarea name="min_req" class="wishdd-textarea" id="minimum-requirements"><?= $min_req ?></textarea>
	        </div>
	    </div>
	    <div class="meta-row">
        	<div class="meta-th">
	          <label for="preferred-requirements" class="wishdd-row-title"><?php _e( 'Preferred Requirements', 'wishdd_localize' ) ?></label>
	        </div>
	        <div class="meta-td">
	          <textarea name="pre_req" class="wishdd-textarea" id="preferred-requirements"><?= $pre_req ?></textarea>
	        </div>
	    </div>
	    <div class="meta-row">
	        <div class="meta-th">
	          <label for="relocation-assistance" class="wishdd-row-title"><?php _e( 'Relocation Assistance', 'wishdd_localize' ) ?></label>
	        </div>
	        <div class="meta-td">
	          <select name="relocation" id="relocation-assistance">
		          
		          <option value="Yes" <?php selected( $relocation , 'Yes' ); ?> >
		          	<?php _e( 'Yes', 'wishdd_localize' )?>
		          </option>
		          
		          <option value="No" <?php  selected( $relocation , 'No' ); ?> >
		          	<?php _e( 'No', 'wishdd_localize' )?>
		          
		          </option>
	          </select>
	    </div> 

	</div>

<?php	


	}





// ------- Saving Function -------

function wishdd_meta_save($post_id)
{
	if(isset($_POST['wishdd_jobs_nonce']))
		$wishdd_nonce 	= $_POST[ 'wishdd_jobs_nonce' ];
	
	$is_autosave 	= wp_is_post_autosave( $post_id );
    $is_revision 	= wp_is_post_revision( $post_id );
   	$is_valid_nonce = (	isset(  $wishdd_nonce ) && wp_verify_nonce( $wishdd_nonce , basename( __FILE__ ) ) )? true : false;

     if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    if(isset($_POST['job_id']))
    	update_post_meta($post_id, 'job_id', sanitize_text_field($_POST['job_id']) );
 
    if(isset($_POST['date_listed']))
    	update_post_meta($post_id, 'date_listed', sanitize_text_field($_POST['date_listed']) );
 
    if(isset($_POST['deadline']))
    	update_post_meta($post_id, 'deadline', sanitize_text_field($_POST['deadline']) );
 
    if(isset($_POST['principle_duties']))
    	update_post_meta($post_id, 'principle_duties', sanitize_text_field($_POST['principle_duties']) );
 
    if(isset($_POST['min_req']))
    	update_post_meta($post_id, 'min_req', sanitize_text_field($_POST['min_req']) );
 
    if(isset($_POST['pre_req']))
    	update_post_meta($post_id, 'pre_req', sanitize_text_field($_POST['pre_req']) );
 
    if(isset($_POST['relocation']))
    	update_post_meta($post_id, 'relocation', sanitize_text_field($_POST['relocation']) );
 
}

add_action("save_post", "wishdd_meta_save");