<?php
/**
 * Plugin Name: WooCommerce Promoted Product
 * Plugin URI: https://github.com/Abdalsalaam/woocommerce-promoted-product
 * Description:
 * Version: 0.1.0
 * Author: Abdalsalaam Halawa
 * Author URI: https://github.com/Abdalsalaam
 * Text Domain: WCPP
 * Domain Path: /languages/
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Test to see if WooCommerce is active (including network activated).
$woocommerce_path = trailingslashit( WP_PLUGIN_DIR ) . 'woocommerce/woocommerce.php';
if ( in_array( $woocommerce_path, wp_get_active_and_valid_plugins(), true ) || in_array( $woocommerce_path, wp_get_active_network_plugins(), true ) ) {
	/*
	 * Create settings tab.
	 */
	include_once untrailingslashit( dirname( __FILE__ ) ) . '/includes/settings.php';

	/*
	 * Functions and actions
	 */
	include_once untrailingslashit( dirname( __FILE__ ) ) . '/includes/functions.php';

	/*
	 * Load the plugin.
	 */
	include_once untrailingslashit( dirname( __FILE__ ) ) . '/includes/promoted_product.php';

	$promoted_product = new Promoted_Product();
}
