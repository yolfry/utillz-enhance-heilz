<?php

namespace UtillzEnhance\Inc\Utils;

class Register {

    use \UtillzEnhance\Inc\Src\Traits\Singleton;

    function __construct() {
        // ..
    }

    public function register( $name, $inst = false ) {

		$this->$name = $inst;

	}

    public function __call( $method, $params ) {

        if ( isset( $this->$method ) ) {
            return $this->$method;
        }

        return;

    }

}
