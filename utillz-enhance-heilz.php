<?php

/*
 * The plugin bootstrap file
 *
 * Plugin Name:       Utillz Enhance — Heilz
 * Plugin URI:        n/a
 * Description:       A WordPress plugin to enhance the experience of our themes
 * Version:           1.0.0.7.1
 * Author:            Utillz
 * Author URI:        https://utillz.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       utillz-enhance
 * Domain Path:       /languages
 *
 */

if( ! defined( 'ABSPATH' ) ) {
    return;
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
 * textdomain
 *
 */
if( ! function_exists('utillz_enhance_load_textdomain') ) {
    function utillz_enhance_load_textdomain() {
    	load_plugin_textdomain( 'utillz-enhance', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }
    add_action( 'init', 'utillz_enhance_load_textdomain' );
}

define('UTILLZ_ENH_PLUGIN', __FILE__ );
define('UTILLZ_ENH_PATH', wp_normalize_path( plugin_dir_path( __FILE__ ) . DIRECTORY_SEPARATOR ));
define('UTILLZ_ENH_URI', plugin_dir_url( __FILE__ ));
define('UTILLZ_ENH_VERSION', '1.0.0.7.1');

// autoloader
include UTILLZ_ENH_PATH . 'inc/autoloader.php';

// elementor widgets
include UTILLZ_ENH_PATH . 'inc/lib/elementor/class.elementor.php';
