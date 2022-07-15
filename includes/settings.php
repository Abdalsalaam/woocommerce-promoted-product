<?php
/**
 * Create the section beneath the products tab
 **/
add_filter( 'woocommerce_get_sections_products', 'wcpp_add_section' );
function wcpp_add_section( $sections ) {
	$sections['wcpp'] = __( 'Promoted Product', 'WCPP' );
	return $sections;
}

/**
 * Add settings to the WCPP section
 **/
add_filter( 'woocommerce_get_settings_products', 'wcpp_settings', 10, 2 );
function wcpp_settings( $settings, $current_section ) {
	/**
	 * Check the current section is what we want
	 **/
	if ( $current_section == 'wcpp' ) {
		$seller_settings = array();

		// Add Title to the Settings
		$seller_settings[] = array(
			'name' => __( 'Promoted Product Settings :', 'WCPP' ),
			'type' => 'title',
			'desc' => __( '#', 'WCPP' ),
			'id' => 'wcpp_settings'
		);

		/*
		 * Promoted product label
		 */
		$seller_settings[] = array(
			'name'     => __( 'Promoted label', 'WCPP' ),
			'type'     => 'text',
			'id'       => 'wcpp_settings_title'
		);

		/*
		 * Promoted product colors
		 */
		$seller_settings[] = array(
			'name'     => __( 'Background color', 'WCPP' ),
			'type'     => 'text',
			'id'       => 'wcpp_settings_bg_color',
			'class'    => 'wcpp-settings-color',
		);

		$seller_settings[] = array(
			'name'     => __( 'Text color', 'WCPP' ),
			'type'     => 'text',
			'id'       => 'wcpp_settings_text_color',
			'class'    => 'wcpp-settings-color',
		);

		$seller_settings[] = array(
			'type' => 'sectionend',
			'id' => 'wcpp_settings'
		);

		return $seller_settings;
	} else {
		return $settings;
	}
}

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