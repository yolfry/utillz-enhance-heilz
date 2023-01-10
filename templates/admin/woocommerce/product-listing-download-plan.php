<?php global $post; ?>

<div class="options_group show_if_listing_download_plan show_if_listing_subscription_download_plan">

	<?php

		woocommerce_wp_text_input([
			'id' => '_ulz_download_limit',
			'label' => __( 'Number of downloads', 'utillz-enhance' ),
			'description' => __( 'The total number of downloads available with this product. 0 = Unlimited', 'utillz-enhance' ),
			'placeholder' => __( '0 = Unlimited', 'utillz-enhance' ),
			'value' => get_post_meta( $post->ID, '_ulz_download_limit', true ),
			'desc_tip' => true,
			'type' => 'number',
			'custom_attributes' => [
				'min' => 0,
				'step' => 1,
			],
		]);

		woocommerce_wp_text_input([
			'id' => '_ulz_download_earnings',
			'label' => __( 'Download earnings', 'utillz-enhance' ),
			'description' => __( 'Set the earning amount that will be collected by the listing owner', 'utillz-enhance' ),
			'placeholder' => __( '0 = No earnings', 'utillz-enhance' ),
			'value' => get_post_meta( $post->ID, '_ulz_download_earnings', true ),
			'desc_tip' => true,
			'type' => 'number',
			'custom_attributes' => [
				'min' => 0,
				'step' => 0.01,
			],
		]);

    	woocommerce_wp_checkbox([
    		'id' => '_ulz_download_disable_repeat_purchase',
    		'label' => __( 'One time obtainable?', 'utillz-enhance' ),
    		'description' => __( 'Use for free downloads, so customers cannot have more than one of these.', 'utillz-enhance' ),
    		'value' => get_post_meta( $post->ID, '_ulz_download_disable_repeat_purchase', true ),
    	]);

    ?>

	<script type="text/javascript">
		jQuery(function(){
			jQuery('#product-type').change( function() {
				jQuery('#woocommerce-product-data').removeClass(function(i, classNames) {
					var classNames = classNames.match(/is\_[a-zA-Z\_]+/g);
					if ( ! classNames ) {
						return '';
					}
					return classNames.join(' ');
				});
				jQuery('#woocommerce-product-data').addClass( 'is_' + jQuery(this).val() );
			} );
			jQuery('.pricing').addClass( 'show_if_listing_download_plan' );
			jQuery('.subscription_pricing').addClass( 'show_if_listing_subscription_download_plan' );
			jQuery('#product-type').change();
		});
	</script>

</div>
