<?php
/**
 * Enqueue Color Picker Scripts
 */
add_action( 'admin_enqueue_scripts', 'wcpp_add_color_picker' );

/**
 * Add assets to admin.
 *
 * @param string $hook Hook name.
 *
 * @return void
 */
function wcpp_add_color_picker( $hook ) {
	if ( 'post-new.php' === $hook || 'post.php' === $hook ) {
		global $post;
		if ( 'product' !== $post->post_type ) {
			return;
		}


		/*
		* flatpickr.
		*/
		wp_enqueue_style( 'flatpickr', plugin_dir_url( __FILE__ ) . 'css/flatpickr.min.css', array(), '4.6.13', false );
		wp_enqueue_script( 'flatpickr', plugin_dir_url( __FILE__ ) . 'js/flatpickr.js', array( 'jquery' ), '4.6.13', false );

		/*
		* custom script.
		*/
		wp_enqueue_script( 'wcpp-script', plugins_url( '/js/wcpp.js', __FILE__ ), array(), '0.1.0', true );
	}
}

/**
 * Save Promoted Product fields
 */
add_action( 'woocommerce_process_product_meta', 'wcpp_save_fields', 10 );

/**
 * Save Promoted Product fields
 *
 * @param int $post_id Product id.
 *
 * @return void
 */
function wcpp_save_fields( $post_id ) {
	// is Promoted?
	if ( isset( $_POST['_wcpp_promoted'] ) && 'yes' === $_POST['_wcpp_promoted'] ) {
		// First delete all previews promoted products.
		global $wpdb;
		$wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_wcpp_promoted'" );
		update_post_meta( $post_id, '_wcpp_promoted', 'yes' );
	} else {
		delete_post_meta( $post_id, '_wcpp_promoted' );
	}

	// Product custom title.
	if ( isset( $_POST['_wcpp_title'] ) && '' !== $_POST['_wcpp_title'] ) {
		update_post_meta( $post_id, '_wcpp_title', sanitize_text_field( $_POST['_wcpp_title'] ) );
	} else {
		delete_post_meta( $post_id, '_wcpp_title' );
	}

	// Product custom title.
	if ( isset( $_POST['_wcpp_expire_date'] ) ) {
		update_post_meta( $post_id, '_wcpp_expire_date', sanitize_text_field( $_POST['_wcpp_expire_date'] ) );
	}
}
