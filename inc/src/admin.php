<?php

namespace UtillzEnhance\Inc\Src;

class Admin {

    use \UtillzEnhance\Inc\Src\Traits\Singleton;

    function __construct() {

        if( is_admin() ) {

            Admin\Http\Xhr::instance();

            $this->columns();

            if( function_exists('Ucore') ) {

                // metabox
                add_action('add_meta_boxes' , [ $this, 'register_meta_boxes' ]);

                // author wonership fix dropdown bug
                add_filter('wp_dropdown_users', [ $this, 'author_override' ]);

                // theme settings
                add_action('utillz/settings/tab-main', [ $this, 'theme_settings_tab_main' ]);
                add_action('utillz/settings/tab-sub', [ $this, 'theme_settings_tab_sub' ]);
                add_action('utillz/settings/sections', [ $this, 'theme_settings_sections' ]);

                // listing filter
                add_action( 'restrict_manage_posts', [ $this, 'admin_listing_filter' ]);
                add_filter( 'parse_query', [ $this, 'posts_filter' ]);

            }

        }

    }

    protected function columns() {

        Admin\Metabox::instance();
        Admin\Columns\Download_Plan::instance();

    }

    public function register_meta_boxes() {

        if( ! function_exists('Uhance') || ! function_exists('Utheme') ) {
            return;
        }

        // page
        add_meta_box(
            'ulz-page-options',
            _x( 'Page', 'Pages options in wp-admin', 'utillz-enhance' ),
            [ $this, 'meta_boxes_page' ],
            'page'
        );

        // post
        add_meta_box(
            'ulz-post-options',
            _x( 'Post', 'Post options in wp-admin', 'utillz-enhance' ),
            [ $this, 'meta_boxes_post' ],
            'post'
        );

    }

    public function author_override( $output ) {

    	global $post, $user_ID;

    	// return if this isn't the theme author override dropdown
    	if( ! preg_match('/post_author_override/', $output) ) {
            return $output;
        }

    	// return if we've already replaced the list (end recursion)
    	if( preg_match( '/post_author_override_replaced/', $output ) ) {
            return $output;
        }

    	// replacement call to wp_dropdown_users
    	$output = wp_dropdown_users([
    		'echo' => 0,
    		'name' => 'post_author_override_replaced',
    		'selected' => empty( $post->ID ) ? $user_ID : $post->post_author,
    		'include_selected' => true
    	]);

    	// put the original name back
    	$output = preg_replace( '/post_author_override_replaced/', 'post_author_override', $output );

    	return $output;

    }

    public function meta_boxes_page() {
        Uhance()->the_template('admin/metabox/page');
    }

    public function meta_boxes_post() {
        Uhance()->the_template('admin/metabox/post');
    }

    public function theme_settings_tab_main() {
        Uhance()->the_template('admin/theme-settings/tab-main');
    }

    public function theme_settings_tab_sub() {
        Uhance()->the_template('admin/theme-settings/tab-sub');
    }

    public function theme_settings_sections() {
        Uhance()->the_template('admin/theme-settings/sections');
    }

    public function admin_listing_filter() {
        if( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'ulz_listing' ) {

            $listing_types = [];
            $post_types = get_posts([
                'post_type' => 'ulz_listing_type',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'meta_query' => []
            ]);

            foreach( $post_types as $post_type ) {
                $listing_types[ $post_type->ID ] = $post_type->post_title;
            }

            ?>
            <select name="ulz_filter_listing_type">
                <option value=""><?php esc_html_e('All listing types', 'utillz-enhance'); ?></option>
                <?php
                    $current_v = isset( $_GET['ulz_filter_listing_type'] ) ? $_GET['ulz_filter_listing_type'] : '';
                    foreach( $listing_types as $listing_type_id => $listing_type_name ) {
                        printf('<option value="%s"%s>%s</option>',
                            $listing_type_id,
                            $listing_type_id == $current_v ? ' selected="selected"' : '',
                            $listing_type_name
                        );
                    }
                ?>
            </select>
            <?php

        }

    }

    public function posts_filter( $query ) {
        global $pagenow;

        $type = 'ulz_listing';

        if( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'ulz_listing' ) {
            if( is_admin() && $pagenow == 'edit.php' && isset( $_GET['ulz_filter_listing_type'] ) && $_GET['ulz_filter_listing_type'] !== '' && $query->is_main_query() ) {
                $query->query_vars['meta_key'] = 'ulz_listing_type';
                $query->query_vars['meta_value'] = (int) $_GET['ulz_filter_listing_type'];
            }
        }
    }

}
