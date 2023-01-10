<?php

namespace UtillzEnhance\Inc\Src\Woocommerce\Packages;

use \UtillzCore\Inc\Src\Woocommerce\Packages\Plan;

class Download_Plan extends Plan {

    public $slug = 'ulz_download_plan';

    public function get_duration() {
        return null;
    }

    public function get_limit() {
        return (int) $this->product->get_meta('_ulz_download_limit');
    }

    public function get_priority() {
        return null;
    }

    public function is_one_time_obtainable() {
        return $this->product->get_meta('_ulz_download_disable_repeat_purchase') == 'yes';
    }

    public function get_earnings() {
        return floatval( $this->product->get_meta('_ulz_download_earnings') );
    }

    public function get_count() {
        return isset( $this->post ) ? (int) get_post_meta( $this->post->ID, 'ulz_count', true ) : 0;
    }

    public function create( $order_id = null, $user_id = null ) {

        if( ! $user_id ) {
            $user_id = get_current_user_id();
        }

        // create download plan
        $post_id = wp_insert_post([
			'post_title' => '',
			'post_status' => 'publish',
			'post_type' => $this->slug,
			'post_author' => $user_id,
            'meta_input'  => [
				'ulz_product_id' => $this->id,
				'ulz_duration' => $this->get_duration(),
				'ulz_limit' => $this->get_limit(),
				'ulz_priority' => $this->get_priority(),
            ]
		]);

        // set title
        $userdata = get_userdata( $user_id );

        wp_update_post([
            'ID' => $post_id,
            'post_title' => $userdata->display_name
        ]);

        $this->post = get_post( $post_id );

        // set order
        if( $order_id ) {
            add_post_meta( $post_id, 'ulz_order_id', $order_id );
        }

        return $post_id;

    }

    public function is_freebie() {
        return ( $this->get_limit() == 0 && $this->product->get_price() == 0 );
    }

    public function is_limit_reached() {

        // freebie
        if( $this->is_freebie() ) {
            return;
        }

        // not free
        if( $this->is_one_time_obtainable() ) {
            return ! empty( $this->get_available('used') );
        }

        return;

    }

    public function sum_download_count() {
        update_post_meta( $this->post->ID, 'ulz_count', (int) get_post_meta( $this->post->ID, 'ulz_count', true ) + 1 );
    }

}
