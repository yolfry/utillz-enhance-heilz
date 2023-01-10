<?php

namespace UtillzEnhance\Inc\Src\Admin\Http\Endpoints;

use \UtillzCore\Inc\Src\Request\Request;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Endpoint_Example extends Endpoint {

	public $action = 'utillz-example';

    public function action() {

		$request = Request::instance();
		$data = (object) Ucore()->sanitize( $_POST );

		$validation = new \UtillzCore\Inc\Src\Validation();
		$response = $validation->validate( $data, $terms );

		if( $response->success ) {

		}

		wp_send_json([
			'success' => true
		]);

	}

}
