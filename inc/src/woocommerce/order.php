<?php

namespace UtillzEnhance\Inc\Src\Woocommerce;

use \UtillzEnhance\Inc\Src\Traits\Singleton;
use \UtillzEnhance\Inc\Src\Woocommerce\Packages\Download_Plan;

use \UtillzCore\Inc\Src\Request\Request;
use \UtillzCore\Inc\Src\Listing\Listing;
use \UtillzCore\Inc\Src\Wallet;

class Order {

    use Singleton;

    function __construct() {

        add_action( 'woocommerce_order_status_completed', [ $this, 'download_plan_order_completed' ] );

    }

    public function download_plan_order_completed( $order_id ) {

		$order = wc_get_order( $order_id );
        $user_id = $order->get_customer_id();

        if( ! $user_id ) {
            return;
        }

        // prevent duplication
        if( get_post_meta( $order_id, 'utillz_payment_download_plan_processed', true ) ) {
			return;
		}

		foreach( $order->get_items() as $item ) {
			$product = wc_get_product( $item['product_id'] );

            // plan
            if(
                $product->is_type( 'listing_download_plan' ) ||
                $product->is_type( 'listing_subscription_download_plan' )
            ) {

                $plan = new Download_Plan( $product->get_id() );

                // inser user plan post
                $order = wc_get_order( $order_id );
                $user_plan_id = $plan->create( $order_id, $order->get_user_id() );

            }
		}

		update_post_meta( $order_id, 'utillz_payment_download_plan_processed', true );

	}

}
