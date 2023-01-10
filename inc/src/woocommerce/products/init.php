<?php

namespace UtillzEnhance\Inc\Src\Woocommerce\Products;

use \UtillzEnhance\Inc\Src\Traits\Singleton;

class Init {

    use Singleton;

    function __construct() {

        add_action( 'init', [ $this, 'register_packages' ] );

        // wc register products types
        add_filter( 'product_type_selector', [ $this, 'add_type' ] );

        // wc product meta template
        add_action( 'woocommerce_product_options_general_product_data', array( $this, 'product_data' ) );

        // wc save product data
        add_action( 'woocommerce_process_product_meta_listing_download_plan', array( $this, 'save_listing_download_plan_data' ) );

    }

    public function register_packages() {

        if( class_exists('WC_Product') ) {
            require UTILLZ_ENH_PATH . 'inc/src/woocommerce/products/wc-product-listing-download-plan.php';
        }

        if( class_exists('WC_Product_Subscription') ) {
            require UTILLZ_ENH_PATH . 'inc/src/woocommerce/products/wc-product-listing-subscription-download-plan.php';
        }

    }

    public function add_type( $types ) {

        $types['listing_download_plan'] = esc_html__( 'Listing Download Plan', 'utillz-enhance' );

        if( class_exists('WC_Product_Subscription') ) {
            $types['listing_subscription_download_plan'] = esc_html__( 'Listing Subscription Download Plan', 'utillz-enhance' );
        }

        return $types;

    }

    public function product_data() {

        Uhance()->the_template('admin/woocommerce/product-listing-download-plan');

        // if( class_exists('WC_Product_Subscription') ) {
        //     Uhance()->the_template('admin/woocommerce/product-listing-download-subscription-plan');
        // }

	}

    public function save_listing_download_plan_data( $post_id ) {

        global $wpdb;

		$meta_save = [
			'_ulz_download_limit',
			'_ulz_download_disable_repeat_purchase',
			'_ulz_download_earnings',
		];

        $data = (object) Ucore()->sanitize( $_POST );

		foreach( $meta_save as $meta_key ) {
			update_post_meta( $post_id, $meta_key, isset( $data->{$meta_key} ) ? $data->{$meta_key} : '' );
		}

	}

}
