<?php

namespace UtillzEnhance\Inc\Src\Woocommerce\Products;

use \UtillzEnhance\Inc\Src\Traits\Singleton;
use \UtillzEnhance\Inc\Src\Listing\Listing;
use \UtillzEnhance\Inc\Src\Woocommerce\Packages\Plan;

class Subscription {

    use Singleton;

    function __construct() {

        add_action( 'woocommerce_process_product_meta_listing_subscription_download_plan', array( $this, 'save_listing_subscription_download_plan_data' ) );

        // subscription synchronisation.
		// activate sync ( process meta ) for listing package
        if( class_exists( 'WC_Subscriptions_Admin' ) && method_exists( 'WC_Subscriptions_Admin', 'save_subscription_meta' ) ) {
            add_action( 'woocommerce_process_product_meta_listing_subscription_download_plan', 'WC_Subscriptions_Synchroniser::save_subscription_meta', 10 );
		}

        // add product to valid subscription type
        add_filter( 'woocommerce_is_subscription', [ $this, 'woocommerce_is_subscription' ], 10, 2 );
        add_filter( 'woocommerce_subscription_product_types', [ $this, 'subscription_product_types' ] );

        // subscription starts
        add_action( 'woocommerce_subscription_status_active', [ $this, 'subscription_activated' ] );

        // subscription renewal
        add_action( 'woocommerce_subscription_renewal_payment_complete', [ $this, 'subscription_renewed' ] );

        // subscription end
		add_action( 'woocommerce_subscription_status_on-hold', [ $this, 'subscription_ended' ] );
		add_action( 'woocommerce_subscription_status_expired', [ $this, 'subscription_ended' ] );
		add_action( 'woocommerce_subscription_status_cancelled', [ $this, 'subscription_ended' ] );

    }

    public function save_listing_subscription_download_plan_data( $post_id ) {

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

    public function woocommerce_is_subscription( $is_subscription, $product_id ) {
		$product = wc_get_product( $product_id );
		if ( $product && $product->is_type(['listing_subscription_download_plan']) ) {
			$is_subscription = true;
		}
		return $is_subscription;
	}

    public function subscription_product_types( $name ) {
        $types[] = 'listing_subscription_download_plan';
		return $types;
    }

    public function subscription_activated( $subscription ) {

        // prevent duplication
        if( get_post_meta( $subscription->get_id(), 'utillz_subscription_plan_processed', true ) ) {
			return;
		}

        // ..

        update_post_meta( $subscription->get_id(), 'utillz_subscription_plan_processed', true );

    }

    public function subscription_renewed( $subscription ) {

        // ..
    }

    public function subscription_ended( $subscription ) {

        // ..

        delete_post_meta( $subscription->get_id(), 'utillz_subscription_plan_processed' );

    }

}
