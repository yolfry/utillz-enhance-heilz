<?php

if ( ! defined('ABSPATH') ) {
	exit;
}

/*
 * human readable dump
 *
 */
if( ! function_exists('dd') ) {
    function dd( $what = '' ) {
        print '<pre class="ulz-dump">';
        print_r( $what );
        print '</pre>';
    }
}

/*
 * autoloader
 *
 */
spl_autoload_register( function( $class ) {

    if ( strpos( $class, 'UtillzEnhance' ) === false ) { return; }

    $file_parts = explode( '\\', $class );

    $namespace = '';
    for( $i = count( $file_parts ) - 1; $i > 0; $i-- ) {

        $current = strtolower( $file_parts[ $i ] );
        $current = str_ireplace( '_', '-', $current );

        if( count( $file_parts ) - 1 === $i ) {
            $file_name = "{$current}.php";
        }else{
            $namespace = '/' . $current . $namespace;
        }
    }

    $filepath  = trailingslashit( dirname( dirname( __FILE__ ) ) . $namespace );
    $filepath .= $file_name;

    if( file_exists( $filepath ) ) {
        include_once( $filepath );
    }

});

// register utilities
include UTILLZ_ENH_PATH . 'inc/utils/utils.php';

// init
UtillzEnhance\Inc\Init::instance();
