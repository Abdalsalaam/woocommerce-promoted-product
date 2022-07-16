<?php
class promoted_product{
	function __construct(){
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
					'id'                => '_download_expiry',
					'value'             => get_post_meta( get_the_ID(), '_wcpp_title', true ),
					'label'             => __( 'Custom title', 'WCPP' ),
					'description'       => __( 'If empty the product title will displayed.', 'woocommerce' )
				)
			);
			echo '</div>';
		} );
	}
}