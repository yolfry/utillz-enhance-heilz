<?php

namespace UtillzEnhance\Inc\Src\Listing;

use \UtillzCore\Inc\Src\Form\Component as Form;

class Related_Collections {

    public $posts_per_page;

    function __construct( $id = null ) {

        if( ! $id ) { $id = get_the_ID(); }

        $this->id = $id;
        $this->taxonomy = 'ulz_listing_tag';
        $this->terms = Ucore()->get( Ucore()->prefix( $this->taxonomy ), $id, false );

    }

    public function set_posts_per_page( $num ) {
        $this->posts_per_page = (int) $num;
    }

    public function query() {

        global $ulz_nearby_post_ids;

        $args = [
            'post_type' => 'ulz_collection',
            'post_status' => 'publish',
            'posts_per_page' => $this->posts_per_page,
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => $this->taxonomy,
                    'value' => $this->terms,
                    'compare' => 'IN',
                ]
            ]
        ];

        $query = new \WP_Query( $args );

        return $query;

    }

}
