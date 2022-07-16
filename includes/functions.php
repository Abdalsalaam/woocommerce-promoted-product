<?php
/**
 * Enqueue Color Picker Scripts
 */
add_action( 'admin_enqueue_scripts', 'wcpp_add_color_picker' );
function wcpp_add_color_picker( $hook ) {
	if( is_admin() ) {
		// Add the color picker css file
		wp_enqueue_style( 'wp-color-picker' );
		// Include our custom jQuery file with WordPress Color Picker dependency
		wp_enqueue_script( 'wcpp-script', plugins_url( '/js/wcpp.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
	}
}

/**
 * Save Promoted Product fields
 */
add_action( 'woocommerce_process_product_meta', 'wcpp_save_fields', 10, 2 );
function wcpp_save_fields( $id ){
	// is Promoted?
	if(isset($_POST['_wcpp_promoted']) && $_POST['_wcpp_promoted'] == 'yes'){
		//First delete all previews promoted products
		global $wpdb;
		$wpdb->query( "DELETE FROM ".$wpdb->postmeta." WHERE meta_key = '_wcpp_promoted'" );
		update_post_meta( $id, '_wcpp_promoted', sanitize_text_field($_POST['_wcpp_promoted']));
	} else {
		delete_post_meta( $id, '_wcpp_promoted' );
	}

	//Product custom title
	if(isset($_POST['_wcpp_title']) && $_POST['_wcpp_title'] != ''){
		update_post_meta( $id, '_wcpp_title', sanitize_text_field($_POST['_wcpp_title']));
	} else {
		delete_post_meta( $id, '_wcpp_title' );
	}
}