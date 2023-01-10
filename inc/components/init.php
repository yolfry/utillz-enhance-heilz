<?php

namespace UtillzEnhance\Inc\Components;

use \UtillzEnhance\Inc\Src\Traits\Singleton;

class Init {

    use Singleton;

    function __construct() {

        add_filter('utillz/modules/listing/action', [$this, 'modules_listing_action']);

    }

    public function modules_listing_action() {

        return [
            'download' => [
                'name' => esc_html__('Download', 'utillz-enhance'),
                'fields' => [
                    'action_type_product' => [
                        'type' => 'wc_products',
                        'name' => esc_html__( 'Select Products', 'utillz-enhance' ),
                        'description' => esc_html__('The WooCommerce products of type `Listing download plan` that will be used to create the order', 'utillz-enhance'),
                        'product_type' => [
                            'listing_download_plan',
                            'listing_subscription_download_plan',
                        ],
                        'choice' => 'checklist',
                        'error_message' => esc_html__('There are no available products of type `Listing download plan`, please create one by going to Products > Add New', 'utillz-enhance' ),
                    ],
                    'extra_bundle' => [
                        'type' => 'upload',
                        'upload_type' => 'file',
                        'multiple_upload' => true,
                        'name' => esc_html__( 'Additional files to bundle (optional)', 'utillz-enhance' ),
                        'description' => esc_html__( 'Here you can add additional files that will be included in the download package. It could be a license, read me file or anything else', 'utillz-enhance' ),
                    ],
                    'title' => [
                        'type' => 'text',
                        'name' => esc_html__( 'Title (optional)', 'utillz-enhance' ),
                    ],
                    'summary' => [
                        'type' => 'textarea',
                        'name' => esc_html__( 'Summary (optional)', 'utillz-enhance' ),
                    ],
                ]
            ],
        ];

    }

}
