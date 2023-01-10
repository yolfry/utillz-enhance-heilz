<?php

namespace UtillzEnhance\Inc\Src\Admin\Columns;

use \UtillzEnhance\Inc\Src\Traits\Singleton;

class Download_Plan {

    use Singleton;

    function __construct() {

        add_filter( 'manage_edit-ulz_download_plan_columns', [ $this, 'columns' ] );
        add_action( 'manage_ulz_download_plan_posts_custom_column', [ $this, 'custom_columns' ], 10, 2 );
        add_filter( 'manage_edit-ulz_download_plan_sortable_columns', [ $this, 'sortable_columns' ] );

    }

    public function columns( $columns ) {

        if ( ! is_array( $columns ) ) {
            $columns = [];
        }

        unset(
            $columns['title'],
            $columns['date'],
            $columns['author'],
            $columns['comments']
        );

        $columns['ulz_image'] = '&nbsp;';
        $columns['ulz_title'] = esc_html__( 'Title', 'utillz-enhance' );
        $columns['ulz_status'] = esc_html__( 'Status', 'utillz-enhance' );
        $columns['ulz_owner_image'] = '&nbsp;';
        $columns['ulz_owner'] = esc_html__( 'Owner', 'utillz-enhance' );
        $columns['ulz_usage'] = esc_html__( 'Usage', 'utillz-enhance' );
        $columns['ulz_product'] = esc_html__( 'Product', 'utillz-enhance' );
        $columns['ulz_order'] = esc_html__( 'Order', 'utillz-enhance' );
        $columns['ulz_posted'] = esc_html__( 'Posted', 'utillz-enhance' );
        $columns['ulz_actions'] = esc_html__( 'Actions', 'utillz-enhance' );

        return $columns;

    }

    public function custom_columns( $column, $post_id ) {

        global $post;

        switch ( $column ) {

            case 'ulz_image':

                $order_post = get_post( Ucore()->get( 'ulz_order_id' ) ); ?>

                <div class="ulz-column-image">
                    <div class="ulz-dummy-image">
                        <?php echo utillz_core()->icon->get( ( $order_post && $order_post->post_type == 'shop_subscription' ) ? 'hourglass_bottom' : 'home_repair_service', 'material-icons' ); ?>
                    </div>
                </div><?php

                break;

            case 'ulz_owner_image': ?>

                <div class="ulz-column-image">
                    <div class="ulz-dummy-image">
                        <?php echo utillz_core()->icon->get( 'person', 'material-icons' ); ?>
                    </div>
                </div><?php

                break;

            case 'ulz_owner':

                echo '<a href="' . get_edit_user_link( $post->post_author ) . '">' . get_the_author_meta( 'display_name', $post->post_author ) . '</a>';

                break;

            case 'ulz_usage':

                $limit = Ucore()->get('ulz_limit');
                echo sprintf( esc_html__( '%s posted of %s', 'utillz-enhance' ), (int) Ucore()->get('ulz_count'), $limit == 0 ? esc_html__( 'unlimited', 'utillz-enhance' ) : $limit );
                break;

            case 'ulz_product':

                echo '<a href="' . esc_url( get_edit_post_link( Ucore()->get( 'ulz_product_id' ) ) ) . '">' . get_the_title( Ucore()->get( 'ulz_product_id' ) ) . '</a>';

                break;

            case 'ulz_order':

                $order_id = Ucore()->get( 'ulz_order_id' );
                if( $order_id ) {
                    echo '<a href="' . esc_url( get_edit_post_link( Ucore()->get( 'ulz_order_id' ) ) ) . '">#' . esc_html( $order_id ) . '</a>';
                }else{
                    echo '-';
                }

                break;

            case 'ulz_title':

                $plan_title = get_the_title();
                // $plan_type = 'Some';

                echo '<div class="ulz-edit-title">';
                    echo '<a href="' . esc_url( admin_url( 'post.php?post=' . $post_id . '&action=edit' ) ) . '" class="tips" data-tip="' . sprintf( esc_html__( 'ID: %d', 'utillz-enhance' ), intval( $post_id ) ) . '">' . esc_html( $plan_title ) . ' - ' . get_the_title( Ucore()->get( 'ulz_product_id' ) ) . '</a>';
                    // echo '<div class="ulz-edit-type"><span>' . esc_attr( $plan_type ) . '</span></div>';
                echo '</div>';

                break;

            case 'ulz_posted':

                echo '<div class="ulz-posted">';
                echo '<strong>' . esc_html( date_i18n( get_option( 'date_format' ), strtotime( $post->post_date ) ) ) . '</strong><span>';
                echo ( empty( $post->post_author ) ? esc_html__( 'by a guest', 'utillz-enhance' ) : sprintf( esc_html__( 'by %s', 'utillz-enhance' ), '<a href="' . esc_url( add_query_arg( 'author', $post->post_author ) ) . '">' . esc_html( get_the_author() ) . '</a>' ) ) . '</span>';
                echo '</div>';
                break;

            case 'ulz_status':

                echo '<div class="ulz-post-status ulz-status-' . $post->post_status . '"><span>' . Uhance()->get_status( $post ) . '</span></div>';

                break;

            case 'ulz_actions':

                echo '<div class="ulz-actions">';
                $admin_actions = apply_filters( 'admin_edit_listing_actions', [], $post );

                if ( in_array( $post->post_status, [ 'pending', 'pending_payment' ], true ) && current_user_can( 'publish_post', $post_id ) ) {
                    $admin_actions['approve'] = [
                        'action' => 'approve',
                        'name'   => __( 'Approve', 'utillz-enhance' ),
                        'url'    => wp_nonce_url( add_query_arg( 'approve_listing', $post_id ), 'approve_listing' ),
                        'icon'    => 'fas fa-check',
                    ];
                }
                if ( 'trash' !== $post->post_status ) {
                    if ( current_user_can( 'edit_post', $post_id ) ) {
                        $admin_actions['edit'] = [
                            'action' => 'edit',
                            'name'   => __( 'Edit', 'utillz-enhance' ),
                            'url'    => get_edit_post_link( $post_id ),
                            'icon'    => 'fas fa-pen',
                        ];
                    }
                    if ( current_user_can( 'delete_post', $post_id ) ) {
                        $admin_actions['delete'] = [
                            'action' => 'delete',
                            'name'   => __( 'Delete', 'utillz-enhance' ),
                            'url'    => get_delete_post_link( $post_id ),
                            'icon'    => 'fas fa-trash-alt',
                        ];
                    }
                }

                $admin_actions = apply_filters( 'ulz_admin_actions', $admin_actions, $post );

                foreach ( $admin_actions as $action ) {
                    if ( is_array( $action ) ) {
                        printf( '<a class="button button-icon tips icon-%1$s" href="%2$s" data-tip="%3$s"><i class="%4$s"></i></a>', esc_attr( $action['action'] ), esc_url( $action['url'] ), esc_attr( $action['name'] ), esc_html( $action['icon'] ) );
                    }else{
                        echo wp_kses_post( str_replace( 'class="', 'class="button ', $action ) );
                    }
                }

                echo '</div>';

                break;

        }
    }

    public function sortable_columns( $columns ) {

        $custom = [
            'ulz_posted'                     => 'date',
            'ulz_title'                      => 'title',
            'taxonomy-ulz_listing_category'  => 'title',
            'taxonomy-ulz_listing_region'    => 'title',
            'taxonomy-ulz_listing_tag'       => 'title',
            'ulz_location'                   => 'ulz_location',
            'ulz_expires'                    => 'ulz_expires',
        ];

        return wp_parse_args( $custom, $columns );

    }

}
