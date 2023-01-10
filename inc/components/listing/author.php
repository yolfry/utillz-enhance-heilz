<?php

namespace UtillzEnhance\Inc\Components\Listing;

use \UtillzCore\Inc\Src\Listing\Modules\Module;
use \UtillzCore\Inc\Src\User;

class Author extends Module {

    public function template() {

        extract( array_merge([
            'title' => null,
            'description' => null,
        ], (array) $this->props ) );

        global $ulz_listing;
        $user_id = $ulz_listing->post->post_author;

        $userdata = get_userdata( $user_id );
        $user = new User( $user_id );
        $user_public_url = get_author_posts_url( $user->id );
        $user_cover = $user->get_cover();

        $total_reviews = $user->get_total_reviews();
        $user_description = get_the_author_meta( 'description', $user_id );

        ob_start(); ?>

        <div class="ulz-mod-listing ulz-mod-listing-author" data-type="author">
            <?php if( ! empty( $name ) ): ?>
                <h4><?php echo esc_html( $name ); ?></h4>
            <?php endif; ?>
            <div class="ulz-author<?php if( $user_cover ) { echo ' ulz--is-image'; } ?>"<?php if( $user_cover ) { echo 'style="background-image:url(\'' . esc_url( $user_cover ) . '\');"'; } ?>>
                <div class="ulz--heading">
                    <div class="ulz--avatar">
                        <a href="<?php echo esc_url( $user_public_url ); ?>">
                            <?php echo wp_kses_post( $user->avatar() ); ?>
                        </a>
                    </div>
                    <div class="ulz--meta">
                        <div class="ulz--name">
                            <a href="<?php echo esc_url( $user_public_url ); ?>">
                                <?php echo esc_html( $userdata->display_name ); ?>
                            </a>
                            <?php if( $total_reviews ): ?>
                                <div class="ulz--reviews">
                                    <span><?php echo sprintf( _n( '%s review', '%s reviews', $total_reviews, 'utillz-enhance' ), $total_reviews ); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if( $user_description ): ?>
                    <div class="ulz--description">
                        <?php echo wp_kses_post( wpautop( $user_description ) ); ?>
                    </div>
                <?php endif; ?>
                <?php if( $display_contact || $display_public_profile ): ?>
                    <div class="ulz--action">
                        <?php if( $display_contact ): ?>
                            <a href="#" class="ulz-button" data-modal="<?php echo is_user_logged_in() ? 'conversation' : 'signin'; ?>" data-params='{"id":<?php echo (int) $ulz_listing->id; ?>}'>
                                <i class="material-icons ulz-mr-1">chat</i>
                                <span><?php echo sprintf( esc_html__('Contact %s', 'utillz-enhance'), $userdata->display_name ); ?></span>
                            </a>
                        <?php endif; ?>
                        <?php if( $display_public_profile ): ?>
                            <a href="<?php echo esc_url( $user_public_url ); ?>" class="ulz-button" target="_blank">
                                <i class="material-icons ulz-mr-1">person</i>
                                <span><?php esc_html_e('View profile', 'utillz-enhance'); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php return ob_get_clean();

    }

}
