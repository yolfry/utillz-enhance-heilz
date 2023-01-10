<?php

namespace UtillzEnhance\Inc\Src\Admin\Http\Endpoints;

use \UtillzCore\Inc\Src\Request\Request;
use \UtillzCore\Inc\Src\Listing\Listing;
use \UtillzCore\Inc\Src\Wallet;
use \UtillzEnhance\Inc\Src\Woocommerce\Packages\Download_Plan;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Endpoint_Action_Download extends Endpoint {

	public $action = 'utillz-action-download';

    public function action() {

		$response = [
			'success' => false
		];

		$data = (object) Ucore()->sanitize( $_POST );
		$request = Request::instance();

		if( ! $data->listing_id ) {
			return;
		}

		// no woocommerce
		if ( ! class_exists('woocommerce') ) {
			wp_send_json( array_merge( $response, [
				'message' => esc_html__( 'Please install WooCommerce in order to enable this action type', 'utillz-enhance' )
			]));
		}

		// security check
		if ( ! isset( $data->security ) || ! wp_verify_nonce( $data->security, 'ajax-nonce' ) ) {
			wp_send_json( array_merge( $response, [
				'message' => esc_html__( 'Security check not passed', 'utillz-enhance' )
			]));
		}

		$listing = new Listing( $data->listing_id );

		if( ! $listing->id ) {
			return;
		}

		/*
		 * already unlocked
		 * or one of your items
		 *
		 */
		if( Uhance()->is_unlock_download( $listing->id ) || $listing->post->post_author == get_current_user_id() ) {

			// push download
			wp_send_json( $this->download( $listing ) );

		}

		if( ! $request->get('plan') ) {
			wp_send_json( array_merge( $response, [
				'message' => esc_html__( 'Please select a plan', 'utillz-enhance' )
			]));
		}

		$products = $listing->get_action_product('download');
		$product = $products[ $request->get('plan') ];
		$price = floatval( $product->get_price() );
		$plan = new Download_Plan( $request->get('plan') );

		// action type product
		if( ! $products || ! array_key_exists( $request->get('plan'), $products ) ) {
			wp_send_json( array_merge( $response, [
				'message' => esc_html__( 'Action type product is missing. Please edit the action type and select a WooCommerce product pf type `listing purchase`.', 'utillz-enhance' )
			]));
		}

		/*
		 * freebie
		 *
		 */
		if( $plan->is_freebie() ) {
			// push download
			wp_send_json( $this->download( $listing ) );
		}

		// check if user
		if ( ! is_user_logged_in() ) {
			wp_send_json( array_merge( $response, [
				'message' => esc_html__( 'Please signin to process the download', 'utillz-enhance' )
			]));
		}

		if( $plan->is_limit_reached() ) {
			wp_send_json( array_merge( $response, [
				'message' => esc_html__( 'The plan limit has been reached', 'utillz-enhance' )
			]));
		}

		/*
		 * has existing plan
		 * or freebie ( with limitation )
		 *
		 */
		if( $plan->availability() || $price == 0 ) {

			// add free plan
			if( ! $plan->availability() ) {
				$plan->create();
			}

			// generate download
			$download = $this->download( $listing );

			// download is successfull
			if( $download['success'] ) {

				// add earnings
				$earnings = $plan->get_earnings();
				if( $earnings > 0 ) {
					$wallet = new Wallet( $listing->post->post_author );
					$wallet->add_to_balance( $earnings );
				}

				// unlock item
				Uhance()->unlock_download( $listing->id );

				// set plan count
				$plan->sum_download_count();

				// send notification
				utillz_core()->notify->distribute( 'new-download', [
					'user_id' => $listing->post->post_author,
					'meta' => [
						'listing_id' => $listing->id,
						'from_user_id' => get_current_user_id(),
					],
				]);

			}

			// push download
			wp_send_json( $download );

		}

		/*
		 * premium plan
		 * add to cart
		 *
		 */
		else{

			if( apply_filters('utillz/cart/empty_cart', true) ) {
				WC()->cart->empty_cart();
			}

			WC()->cart->add_to_cart( $product->get_id(), 1, '', '', [
	            // 'listing_id' => [ $listing->id ],
	            'request_user_id' => get_current_user_id(),
				'price' => $price,
	        ]);

			// go send user to pay
			wp_send_json([
				'success' => true,
				'redirect_url' => wc_get_checkout_url()
			]);

		}

	}

	public function does_url_exists( $remove_file ) {

		if( $remove_file !== '' && $remove_file !== null ) {
			$remote = wp_remote_head( $remove_file, [
				'timeout' => 3,
				'sslverify' => false,
			]);
		    $accepted_status_codes = [
				200,
				301,
				302
			];
		    return ! is_wp_error( $remote ) && in_array( wp_remote_retrieve_response_code( $remote ), $accepted_status_codes );

		}
		return;
	}

	public function generate_download_url( $listing ) {

		$zip = new \ZipArchive();
		$generate_file_name = sprintf( 'download-%s', Ucore()->random() );

		// create the directory
		if( ! file_exists( UTILLZ_CORE_UPLOAD_PATH . 'utilities-temp-downloads/' ) ) {
			wp_mkdir_p( UTILLZ_CORE_UPLOAD_PATH . 'utilities-temp-downloads/' );
		}

		if( $zip->open( sprintf( UTILLZ_CORE_UPLOAD_PATH . 'utilities-temp-downloads/%s.zip', $generate_file_name ), \ZipArchive::CREATE ) !== true ) {
			return null;
		}

		$action = $listing->type->get_action('download');

		// extra bundle
		if( $extra_bundle = $action->get_field('extra_bundle') ) {
			if( is_array( $extra_bundle ) ) {
				foreach( $extra_bundle as $extra ) {
					$extra_attached_file = get_attached_file( $extra->id );
					if( $extra_attached_file && file_exists( $extra_attached_file ) ) {
						$zip->addFile( $extra_attached_file, basename( $extra_attached_file ) );
					}
				}
			}
		}

		$downloads = Ucore()->json_decode( $listing->get('ulz_download') );
		if( is_array( $downloads ) ) {

			foreach( $downloads as $download ) {
				$attached_file = get_attached_file( $download->id );
				$zip->addFile( $attached_file, basename( $attached_file ) );
			}
		}

		$zip->close();

		// bundle
		$generated_bundle = sprintf( UTILLZ_CORE_UPLOAD_URI . 'utilities-temp-downloads/%s.zip', $generate_file_name );

		if( $this->does_url_exists( $generated_bundle ) ) {
			return $generated_bundle;
		}

		return null;

	}

	public function download( $listing ) {

		if( ! $download_url = $this->generate_download_url( $listing ) ) {
			return [
				'success' => false,
				'message' => esc_html__( 'Can\'t find any download file', 'utillz-enhance' )
			];
		}

		return [
			'success' => true,
			'download_url' => $this->generate_download_url( $listing ),
			'message' => esc_html__( 'Downloaded successfully', 'utillz-enhance' )
		];

	}

}
