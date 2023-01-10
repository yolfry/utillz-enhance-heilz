<?php

class Utillz_Elementor {

    function __construct() {

        add_action( 'init', [ $this, 'init_widgets' ] );

    }

    public function init_widgets() {

        if( ! function_exists('Ucore') || ! function_exists('Utheme') ) {
            return;
        }

        add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'preview_enqueue_scripts' ] );

        add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

        add_action( 'elementor/elements/categories_registered', [ $this, 'create_custom_categories' ] );

    }

    public function preview_enqueue_scripts() {

        wp_enqueue_style( 'utillz-elementor', UTILLZ_ENH_URI . 'assets/dist/css/elementor-panel.css', [], UTILLZ_ENH_VERSION );

    }

    public function register_widgets() {

        $this->include_widgets_files();

        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Utillz_Elementor_Search() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Utillz_Elementor_Heading() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Utillz_Elementor_Button_Stack() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Utillz_Elementor_Board() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Utillz_Elementor_Boxes() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Utillz_Elementor_Listings() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Utillz_Elementor_Product_Table() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Utillz_Elementor_Articles() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Utillz_Elementor_Faq() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Utillz_Elementor_Collections() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Utillz_Elementor_Toggle() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Utillz_Elementor_Point() );

    }

    public function include_widgets_files() {

        require UTILLZ_ENH_PATH . 'inc/lib/elementor/class.elementor.search.php';
        require UTILLZ_ENH_PATH . 'inc/lib/elementor/class.elementor.heading.php';
        require UTILLZ_ENH_PATH . 'inc/lib/elementor/class.elementor.button-stack.php';
        require UTILLZ_ENH_PATH . 'inc/lib/elementor/class.elementor.board.php';
        require UTILLZ_ENH_PATH . 'inc/lib/elementor/class.elementor.adaptive-grid.php';
        require UTILLZ_ENH_PATH . 'inc/lib/elementor/class.elementor.listings.php';
        require UTILLZ_ENH_PATH . 'inc/lib/elementor/class.elementor.product-table.php';
        require UTILLZ_ENH_PATH . 'inc/lib/elementor/class.elementor.articles.php';
        require UTILLZ_ENH_PATH . 'inc/lib/elementor/class.elementor.faq.php';
        require UTILLZ_ENH_PATH . 'inc/lib/elementor/class.elementor.collections.php';
        require UTILLZ_ENH_PATH . 'inc/lib/elementor/class.elementor.toggle.php';
        require UTILLZ_ENH_PATH . 'inc/lib/elementor/class.elementor.point.php';

    }

    public function create_custom_categories( $elements_manager ) {

        $category_prefix = 'utillz';

        $elements_manager->add_category(
            $category_prefix,
            [
                'title' => __( 'Utillz', 'utillz-enhance' ),
                'icon' => 'fas fa-location-arrow',
            ]
        );

        $reorder_cats = function() use( $category_prefix ) {
            uksort( $this->categories, function( $key_one, $key_two ) use( $category_prefix ) {
                if( substr( $key_one, 0, strlen( $category_prefix ) ) == $category_prefix ) {
                    return -1;
                }
                if( substr( $key_two, 0, strlen( $category_prefix ) ) == $category_prefix ) {
                    return 1;
                }
                return 0;
            });

        };

        $reorder_cats->call( $elements_manager );

    }

}

new Utillz_Elementor();
