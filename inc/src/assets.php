<?php

namespace UtillzEnhance\Inc\Src;

class Assets {

    use \UtillzEnhance\Inc\Src\Traits\Singleton;

    function __construct() {

        // scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

    }

    public function get_vars() {

        global $ulz_explore, $utilities_download_data;

        $vars = [
            'version' => UTILLZ_ENH_VERSION
        ];

        $utilities_download_data = \UtillzEnhance\Inc\Src\Listing\Download::get_download_data();
        $vars['action_download_data'] = $utilities_download_data;

        return $vars;

    }

    public function enqueue_scripts() {

        /*
         * main
         *
         */

        // css
        wp_enqueue_style( 'utillz-enhance-style', UTILLZ_ENH_URI . 'assets/dist/css/enhance.css', [], UTILLZ_ENH_VERSION );

        // js
        wp_register_script( 'utilities-enhance-script', UTILLZ_ENH_URI . 'assets/dist/js/enhance.js', ['jquery'], UTILLZ_ENH_VERSION );
        wp_localize_script( 'utilities-enhance-script', 'utillz_enhance_vars', $this->get_vars() );
        wp_enqueue_script( 'utilities-enhance-script' );

    }

}
