<?php
/**
 * Create the section beneath the products tab
 **/

add_filter( 'woocommerce_get_sections_products', 'wcpp_add_section' );

/**
 * Add Custom subsection to WooCommerce Products settings section.
 *
 * @param array $sections WooCommerce Products settings subsections.
 * @return array
 */
function wcpp_add_section( $sections ) {
	$sections['wcpp'] = __( 'Promoted Product', 'WCPP' );
	return $sections;
}

/**
 * Add settings to the WCPP section
 */
add_filter( 'woocommerce_get_settings_products', 'wcpp_settings', 10, 2 );

/**
 * Add WCPP settings to WooCommerce Settings.
 *
 * @param array  $settings WooCommerce Product Settings.
 * @param string $current_section Current section slug.
 *
 * @return array
 */
function wcpp_settings( $settings, $current_section ) {

	/**
	 * Early exit if not on the WCPP section.
	*/
	if ( 'wcpp' !== $current_section ) {
		return $settings;
	}

	// Add the color picker css file.
	wp_enqueue_style( 'wp-color-picker' );
	// Include our custom jQuery file with WordPress Color Picker dependency.
	wp_enqueue_script( 'wcpp-script', plugins_url( '/js/wcpp.js', __FILE__ ), array( 'wp-color-picker' ), '0.1.0', true );

	$settings = array();
	// Add Title to the Settings.
	$promoted_product      = new Promoted_Product();
	$promoted_product_data = $promoted_product->get_data();
	if ( ! is_null( $promoted_product_data ) ) {
		$current_product = '<a href="' . admin_url( 'post.php?post=' . $promoted_product_data['id'] . '&action=edit' ) . '">' . $promoted_product_data['title'] . '</a>';
	} else {
		$current_product = 'No active promoted product.';
	}

	$settings[] = array(
		'name' => __( 'Promoted Product Settings', 'WCPP' ),
		'type' => 'title',
		'desc' => $current_product,
		'id'   => 'wcpp_settings',
	);

	/*
		* Promoted product label
		*/
	$settings[] = array(
		'name' => __( 'Promoted label', 'WCPP' ),
		'type' => 'text',
		'id'   => 'wcpp_settings_title',
	);

	/*
		* Promoted product colors
		*/
	$settings[] = array(
		'name'  => __( 'Background color', 'WCPP' ),
		'type'  => 'text',
		'id'    => 'wcpp_settings_bg_color',
		'class' => 'wcpp-settings-color',
	);

	$settings[] = array(
		'name'  => __( 'Text color', 'WCPP' ),
		'type'  => 'text',
		'id'    => 'wcpp_settings_text_color',
		'class' => 'wcpp-settings-color',
	);

	$settings[] = array(
		'type' => 'sectionend',
		'id'   => 'wcpp_settings',
	);

	return $settings;
}
