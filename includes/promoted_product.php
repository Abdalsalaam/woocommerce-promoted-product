<?php
class Promoted_Product {

	public function __construct() {
		/*
		 * Product general fields tab.
		 */
		add_action(
			'woocommerce_product_options_general_product_data',
			function() {
				echo '<div class="options_group">';

				// is Promoted?
				woocommerce_wp_checkbox(
					array(
						'id'          => '_wcpp_promoted',
						'label'       => __( 'Promote this product', 'WCPP' ),
						'description' => __( 'Check this box if this product is promoted.', 'WCPP' ),
						'value'       => get_post_meta( get_the_ID(), '_wcpp_promoted', true ),
					)
				);

				// Custom title.
				woocommerce_wp_text_input(
					array(
						'id'          => '_wcpp_title',
						'label'       => __( 'Custom title', 'WCPP' ),
						'description' => __( 'If empty the product title will displayed.', 'woocommerce' ),
						'value'       => get_post_meta( get_the_ID(), '_wcpp_title', true ),
					)
				);

				// Expire date.
				woocommerce_wp_text_input(
					array(
						'id'    => '_wcpp_expire_date',
						'label' => __( 'Expire date', 'WCPP' ),
						'value' => get_post_meta( get_the_ID(), '_wcpp_expire_date', true ),
					)
				);
				echo '</div>';
			}
		);

		/*
		 * Display promoted product above header
		 */
		add_action(
			'wp_body_open',
			function() {
				$promoted_product_data = $this->get_data();
				if ( ! is_null( $promoted_product_data ) ) {
					echo '<div style="text-align: center; background: ' . esc_attr( $promoted_product_data['bg_color'] ) . ';"><a style="color : ' . esc_attr( $promoted_product_data['text_color'] ) . ' ;" href="' . esc_url( $promoted_product_data['link'] ) . '">' . esc_html( $promoted_product_data['label'] ) . ' ' . esc_html( $promoted_product_data['title'] ) . '</a></div>';
				}
			}
		);
	}

	/**
	 * Get current promoted product
	 *
	 * @return int|false
	 */
	public function get_id() {
		/**
		 * WordPress database object.
		 *
		 * @var wpdb $wpdb
		 */
		global $wpdb;

		$promoted_product = $wpdb->get_row( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wcpp_promoted' AND meta_value = 'yes'", ARRAY_A );

		if ( empty( $promoted_product ) || ! isset( $promoted_product['post_id'] ) ) {
			return false;
		}

		$post_id = intval( $promoted_product['post_id'] );

		if ( ! $this->check_date( $post_id ) ) {
			return false;
		}

		return $post_id;
	}

	/**
	 * Get promoted product title.
	 *
	 * @param int $product_id WooCommerce product id.
	 * @return string
	 */
	private function get_title( $product_id ) {
		$title = get_post_meta( $product_id, '_wcpp_title', true );
		if ( $title && '' !== $title ) {
			return $title;
		} else {
			return get_the_title( $product_id );
		}
	}

	/**
	 * Check if promoted product valid.
	 *
	 * @param int $product_id WooCommerce product id.
	 * @return bool
	 */
	private function check_date( $product_id ) {
		$expire_date  = get_post_meta( $product_id, '_wcpp_expire_date', true );
		$current_date = wp_date( 'Y-m-d H:i' );

		if ( $expire_date <= $current_date ) {
			// Delete promotion.
			delete_post_meta( $product_id, '_wcpp_promoted' );
			return false; // expired.
		} else {
			return true; // valid.
		}
	}


	/**
	 * Get promoted product data.
	 *
	 * @return array|null
	 */
	public function get_data() {
		$product_id = $this->get_id();
		if ( $product_id ) {
			return array(
				'id'         => $product_id,
				'title'      => $this->get_title( $product_id ),
				'label'      => get_option( 'wcpp_settings_title' ),
				'bg_color'   => get_option( 'wcpp_settings_bg_color' ),
				'text_color' => get_option( 'wcpp_settings_text_color' ),
				'link'       => get_permalink( $product_id ),
			);
		} else {
			return null;
		}
	}
}
