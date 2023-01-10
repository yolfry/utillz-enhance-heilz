<?php

namespace UtillzEnhance\Inc\Src\Woocommerce;

use \UtillzEnhance\Inc\Src\Traits\Singleton;

class Init {

    use Singleton;

    function __construct() {

        Products\Init::instance();
        Products\Subscription::instance();
        Post_Types::instance();
        Order::instance();

    }

}
