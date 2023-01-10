<?php

namespace UtillzEnhance\Inc\Src;

class Shortcodes {

    use \UtillzEnhance\Inc\Src\Traits\Singleton;

    function __construct() {

        add_action( 'init', [ $this, 'register_shortcodes' ] );

    }

    public function register_shortcodes() {

        // social icons
        add_shortcode( 'utillz-social-icons', [ $this, 'shortcode_social_icons' ] );

    }

    public function shortcode_social_icons() {
        return Uhance()->get_template('globals/social-icons');
    }

}
