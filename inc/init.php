<?php

namespace UtillzEnhance\Inc;

use \UtillzEnhance\Inc\Src\Traits\Singleton;

class Init {

    use Singleton;

    function __construct() {

        Src\Admin::instance();
        Src\Assets::instance();
        Src\Install::instance();
        Src\Schedule::instance();
        Src\Settings::instance();
        Src\Shortcodes::instance();
        Src\Woocommerce\Init::instance();
        Components\Init::instance();

    }

}
