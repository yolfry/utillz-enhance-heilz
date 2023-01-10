<?php

namespace UtillzEnhance\Inc\Src;

use \UtillzEnhance\Inc\Src\Traits\Singleton;

class Schedule {

    use Singleton;

    function __construct() {

        add_action('utilities_clear_temp_downloads', [ $this, 'clear_temp_downloads' ]);

    }

    public function clear_temp_downloads() {

        foreach( glob( UTILLZ_CORE_UPLOAD_PATH . 'utilities-temp-downloads/*' ) as $file ) {
            if( is_file( $file ) ) {
                wp_delete_file( $file );
            }
        }

	}

}
