<?php

use \UtillzEnhance\Inc\Utils;

/*
 * register utilities
 *
 */
if( ! function_exists('utillz_enhance') ) {
    function utillz_enhance() {
        return Utils\Register::instance();
    }
}

if( ! function_exists('Uhance') ) {
    function Uhance() {
    	return utillz_enhance()->helper();
    }
    utillz_enhance()->register( 'helper', Utils\Helper::instance() );
}
