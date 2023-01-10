<?php

use \UtillzCore\Inc\Src\Admin\Panel;
use \UtillzCore\Inc\Src\User;

defined('ABSPATH') || exit;

global $post;

$panel = Panel::instance();
$panel->form->set( $panel->form::Storage_Meta );

$user = new User( $post->post_author );
$userdata = $user->get_userdata();

$product_id = get_post_meta( get_the_ID(), 'ulz_product_id', true );
$order_id = get_post_meta( get_the_ID(), 'ulz_order_id', true );

?>

<div class="ulz-panel ulz-outer">
    <div class="ulz-section">
        <table class="ulz-table">
            <thead>
                <tr>
                    <th><?php esc_html_e('General details', 'utillz-enhance'); ?></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php esc_html_e('User', 'utillz-enhance'); ?></td>
                    <td><a href="<?php echo esc_url( get_edit_user_link( $user->id ) ); ?>"><?php echo esc_html( $userdata->display_name ); ?></a></td>
                </tr>
                <?php if( $product_id ): ?>
                    <tr>
                        <td><?php esc_html_e('Download plan', 'utillz-enhance'); ?></td>
                        <td><a href="<?php echo esc_url( get_edit_post_link( $product_id ) ); ?>"><?php echo get_the_title( $product_id ); ?></a></td>
                    </tr>
                <?php endif; ?>
                <?php if( $order_id ): ?>
                    <tr>
                        <td><?php esc_html_e('Order', 'utillz-enhance'); ?></td>
                        <td><a href="<?php echo esc_url( get_edit_post_link( $order_id ) ); ?>"><?php echo get_the_title( $order_id ); ?></a></td>
                    </tr>
                <?php endif; ?>
                <?php $attached_ids = get_post_meta( get_the_ID(), 'ulz_attached', false ); ?>
                <?php if( is_array( $attached_ids ) ): ?>
                    <?php
                        $attached = new \WP_Query([
                            'post_type' => 'ulz_listing',
                            'post__in' => $attached_ids ? $attached_ids : [0],
                        ]);
                    ?>
                    <?php if( $attached->found_posts ): ?>
                        <?php foreach( $attached->posts as $attached ): ?>
                            <?php $listing = new \UtillzCore\Inc\Src\Listing\Listing( $attached->ID ); ?>
                            <tr>
                                <td><?php esc_html_e('Listing', 'utillz-enhance'); ?></td>
                                <td><a href="<?php echo esc_url( get_edit_post_link( $attached->ID ) ); ?>"><?php echo get_the_title( $attached->ID ); ?></a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <p class="ulz-mt-5"><strong><?php esc_html_e('Parameters', 'utillz-enhance'); ?></strong></p>

        <div class="ulz-form ulz-grid">
            <?php

                $panel->form->render([
                    'type' => 'text',
                    'id' => 'ulz_count',
                    'name' => esc_html__( 'Count', 'utillz-enhance' ),
                    'value' => 0,
                    'description' => esc_html__( 'How many items have been downloaded with this plan.', 'utillz-enhance' ),
                    'disabled' => true,
                ]);

                $panel->form->render([
                    'type' => 'text',
                    'id' => 'ulz_limit',
                    'name' => esc_html__( 'Limit', 'utillz-enhance' ),
                    'description' => esc_html__( 'The maximum number of downloads allows with this plan, 0 = unlimited.', 'utillz-enhance' ),
                    'disabled' => true,
                ]);

            ?>
        </div>
    </div>
</div>
