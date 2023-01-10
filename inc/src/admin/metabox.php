<?php

namespace UtillzEnhance\Inc\Src\Admin;

class Metabox {

    use \UtillzEnhance\Inc\Src\Traits\Singleton;

    function __construct() {

        // metabox
        add_action( 'add_meta_boxes' , [ $this, 'register_meta_boxes' ] );

    }

    function register_meta_boxes() {

        // plans
        add_meta_box(
            'ulz-download-plan-options',
            _x( 'Download Plan', 'Download Plan options in wp-admin', 'utillz-enhance' ),
            [ $this, 'meta_boxes_download_plan' ],
            'ulz_download_plan'
        );

    }

    static function meta_boxes_download_plan( $post ) {
        Uhance()->the_template('admin/metabox/download-plan');
    }

}
