<?php

namespace UtillzEnhance\Inc\Src\Admin\Http;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Xhr {

	use \UtillzEnhance\Inc\Src\Traits\Singleton;

    public function __construct() {

		if( wp_doing_ajax() && isset( $_REQUEST['action'] ) ) {

			$this->display_errors();
            $this->init_endpoints();

        }

	}

    function init_endpoints() {

		foreach( glob( UTILLZ_ENH_PATH . 'inc/src/admin/http/endpoints/*.php') as $file ) {
			$endpoint_classname = sprintf( '\UtillzEnhance\Inc\Src\Admin\Http\Endpoints\%s', basename( str_replace( '-', '_', $file ), '.php' ) );
			new $endpoint_classname;
		}

	}

    function display_errors() {

		if( defined( 'WP_DEBUG' ) && WP_DEBUG === true ) {
			@ini_set( 'display_errors', 1 );
		}

    }
}
