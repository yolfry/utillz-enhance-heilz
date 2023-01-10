<?php

namespace UtillzEnhance\Inc\Src;

use \UtillzCore\Inc\Src\Admin\Panel;

class Settings {

    use \UtillzEnhance\Inc\Src\Traits\Singleton;

    function __construct() {

        add_action('utillz/settings/listing-type/related', [ $this, 'listing_type_related' ]);

        // image
        add_action('utillz/upload', [ $this, 'watermark' ]);

        // pricing
        add_filter('utillz/listing/get-pricing', [ $this, 'get_pricing' ], 10, 3);

        // listing product
        add_filter('utillz/listing-product-types', [ $this, 'listing_product_types' ], 10, 3);

        // add iframe to wp post kses
        add_filter('wp_kses_allowed_html', [ $this, 'wpkses_post_tags' ], 10, 2);

        // disable elementor fonts
        add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );

    }

    public function listing_type_related() {

        $panel = Panel::instance();
        $panel->form->set( $panel->form::Storage_Meta );

        $panel->form->render([
            'type' => 'separator',
        ]);

        $panel->form->render([
            'type' => 'checkbox',
            'id' => 'enable_related_collections',
            'name' => esc_html__('Enable related collections', 'utillz-enhance'),
        ]);

        $panel->form->render([
            'type' => 'number',
            'id' => 'related_collections_posts_per_page',
            'name' => esc_html__('Related collections — number of posts', 'utillz-core'),
            'input_type' => 'stepper',
            'style' => 'v2',
            'min' => 1,
            'max' => 50,
            'value' => 6,
            'dependency' => [
                'id' => 'enable_related_collections',
                'compare' => '=',
                'value' => 1,
                'style' => 'ulz-opacity-30',
            ],
        ]);

    }

    public function watermark( $attachment_id ) {

        if( class_exists('\EasyWatermark\Watermark\Handler') ) {
            $easy_watermark = new \EasyWatermark\Watermark\Handler();

            $watermarks = $easy_watermark->get_watermarks();
            foreach( $watermarks as $watermark ) {
                $easy_watermark->apply_single_watermark( $attachment_id, $watermark->ID );
            }
        }

    }

    public function get_pricing( $output, $listing ) {

        $download = [
            'plans' => [],
            'price' => [
                'low' => 0
            ],
        ];

        $plans = $listing->get_action_product('download');
        if( $plans ) {
            foreach( $plans as $plan ) {
                $price = floatval( $plan->get_price() );
                $download['plans'][ $plan->get_id() ] = $price;
                if( $download['price']['low'] == 0 || ( $price > 0 && $price < $download['price']['low'] ) ) {
                    $download['price']['low'] = $price;
                }
            }
        }

        return array_merge( $output, [
            'download' => (object) $download,
        ]);
    }

    public function listing_product_types( $types ) {

        return array_merge( $types, [
            'listing_download_plan'
        ]);

    }

    public function wpkses_post_tags( $tags, $context ) {
    	if( 'post' === $context ) {
    		$tags['iframe'] = [
    			'src'             => true,
    			'height'          => true,
    			'width'           => true,
    			'frameborder'     => true,
    			'allowfullscreen' => true,
    		];
    	}
    	return $tags;
    }

}
