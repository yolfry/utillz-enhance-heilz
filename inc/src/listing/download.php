<?php

namespace UtillzEnhance\Inc\Src\Listing;

use \UtillzEnhance\Inc\Src\Woocommerce\Packages\Download_Plan;

class Download {

    public static function get_download_data() {

        if( class_exists('woocommerce') ) {

            $page_object = get_queried_object();

            if(
                is_main_query() &&
                isset( $page_object->post_type ) &&
                $page_object->post_type == 'ulz_listing'
            ) {
                return self::get_listing_download_data(
                    new \UtillzCore\Inc\Src\Listing\Listing( $page_object->ID )
                );
            }
        }

        return [];

    }

    public static function get_listing_download_data( $listing ) {

        $utilities_download_data = [];

        if( ! function_exists('wc_get_product') ) {
            return $utilities_download_data;
        }

        $action_download = $listing->get_action('download');

        if( $action_download->action ) {
            if(
                isset( $action_download->action->fields->action_type_product ) &&
                is_array( $action_download->action->fields->action_type_product )
            ) {
                foreach( array_filter( $action_download->action->fields->action_type_product ) as $product_id ) {

                    $product = wc_get_product( $product_id );

                    if( ! $product ) {
                        return $utilities_download_data;
                    }

                    if( $product->get_status() !== 'publish' ) {
                        continue;
                    }

                    $plan = new Download_Plan( $product_id );

                    $available = $plan->get_available();
                    $left = null;
                    if( isset( $available[0] ) ) {

                        // count limit
                        foreach( $available as $pln ) {
                            $pln_available = (int) $pln->lim - (int) $pln->cnt;
                            if( $pln_available > 0 ) {
                                $left += $pln_available;
                            }
                        }

                        // set first available
                        $available = $available[0];

                    }

                    $utilities_download_data[ $product_id ] = [
                        'type' => $product->get_type(),
                        'title' => $product->get_title(),
                        'description' => wpautop( wp_kses_post( $product->get_description() ) ),
                        'limit' => $plan->get_limit(),
                        'is_one_time_obtainable' => $plan->is_one_time_obtainable(),
                        'is_limit_reached' => $plan->is_limit_reached(),
                        'is_freebie' => $plan->is_freebie(),
                        'available' => $available,
                        'available_left' => $left,
                        'price' => floatval( $product->get_price() ),
                        'price_html' => $product->get_price() ? wp_kses_post( $product->get_price_html() ) : esc_html__('Free', 'utillz-enhance'),
                    ];
                }
            }
        }

        return $utilities_download_data;

    }
}
