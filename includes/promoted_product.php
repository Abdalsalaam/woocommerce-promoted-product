<?php
class promoted_product{
	function __construct(){
		/*
		 * Product general fields tab.
		 */
		add_action( 'woocommerce_product_options_general_product_data', function (){
			echo '<div class="options_group">';
			// is Promoted?
			woocommerce_wp_checkbox( array(
				'id' => '_wcpp_promoted',
				'label' => __( 'Promote this product', 'WCPP' ),
				'description' => __( 'Check this box if this product is promoted.', 'WCPP' ),
				'value'   => get_post_meta( get_the_ID(), '_wcpp_promoted', true )
			) );

			// Custom title
			woocommerce_wp_text_input(
				array(
					'id'                => '_wcpp_title',
					'value'             => get_post_meta( get_the_ID(), '_wcpp_title', true ),
					'label'             => __( 'Custom title', 'WCPP' ),
					'description'       => __( 'If empty the product title will displayed.', 'woocommerce' )
				)
			);
			echo '</div>';
		} );

		/*
		 * Display promoted product above header
		 */
		add_action( 'wp_body_open', function (){
			$promoted_product_data = $this->get_data();
			if(!is_null($promoted_product_data)){
				echo '<div style="text-align: center; background: '.$promoted_product_data['bg_color'].';"><a style="color : '.$promoted_product_data['label'].' ;" href="'.$promoted_product_data['link'].'">'.$promoted_product_data['title'].' : '.$promoted_product_data['title'].'</a></div>';
			}
		});
	}

	/**
	 * Get current promoted product
	 * @return false|int
	 */
	public function get_id(){
		global $wpdb;
		$promoted_product = $wpdb->get_results( "SELECT post_id FROM ".$wpdb->postmeta." WHERE meta_key = '_wcpp_promoted' AND meta_value = 'yes'",ARRAY_A);
		if(!empty($promoted_product)){
			return $promoted_product[0]['post_id'];
		} else {
			return false;
		}
	}

	//get promoted product title
	private function get_title( $product_id ){
		$title = get_post_meta( $product_id, '_wcpp_title', true );
		if($title && $title != '')
			return $title;
		else
			return get_the_title( $product_id );
	}

	/**
	 * Get promoted product data
	 * @return array|null
	 */
	public function get_data(){
		$product_id = $this->get_id();
		if ($product_id)
			return array(
				'id'    => $product_id,
				'title' => $this->get_title( $product_id ),
				'label' => get_option( 'wcpp_settings_title' ),
				'bg_color'   => get_option( 'wcpp_settings_bg_color' ),
				'text_color' => get_option( 'wcpp_settings_text_color' ),
				'link' => get_permalink( $product_id )
			);
		else
			return null;
	}
}