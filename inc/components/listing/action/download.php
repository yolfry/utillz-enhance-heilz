<?php

namespace UtillzEnhance\Inc\Components\Listing\Action;

use \UtillzCore\Inc\Src\Listing\Action\Modules\Module;

class Download extends Module {

    public function template() {

        global $utilities_download_data, $ulz_listing;

        // check if download action type is being adopted by the gallery cover type
        if( $ulz_listing->type->get('ulz_single_cover_type') == 'full-cover' && $this->component->get_position() == 'sidebar' ) {
            return;
        }

        extract( array_merge([
            'title' => null,
            'description' => null,
        ], (array) $this->props ) );

        $available_found = null;
        foreach( $utilities_download_data as $id => $data ) {
            if( ! $data['available'] ) {
                continue;
            }
            $available_found = $data;
            break;
        }

        ob_start(); ?>

        <div class="ulz-mod-action ulz-mod-action-<?php echo esc_attr( $type ); ?>" data-type="<?php echo esc_attr( $type ); ?>">

            <input type="hidden" name="ulz_download_listing_id" value="<?php echo (int) $ulz_listing->id; ?>">

            <?php if( function_exists('wc_get_product') ): ?>

                <?php if( $utilities_download_data ): ?>

                    <?php if( $title ): ?>
                        <p class="ulz-action-title">
                            <?php echo esc_html( $title ); ?>
                        </p>
                    <?php endif; ?>

                    <?php if( $summary ): ?>
                        <p class="ulz-action-summary">
                            <?php echo esc_html( $summary ); ?>
                        </p>
                    <?php endif; ?>

                    <div class="ulz-download-plans">

                        <?php global $ulz_listing ?>

                        <?php if( $ulz_listing->post->post_author == get_current_user_id() ): ?>

                            <div class="ulz-availabe-found ulz--unlocked">
                                <div class="ulz--item">
                                    <div class="ulz--container">
                                        <div class="ulz--selection">
                                            <i class="material-icons">check_circle</i>
                                        </div>
                                        <div class="ulz--content">
                                            <span class="ulz--label"><?php esc_html_e('This is one of your items', 'heilz'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php elseif( Uhance()->is_unlock_download( get_the_ID() ) ): ?>

                            <div class="ulz-availabe-found ulz--unlocked">
                                <div class="ulz--item">
                                    <div class="ulz--container">
                                        <div class="ulz--selection">
                                            <i class="material-icons">check_circle</i>
                                        </div>
                                        <div class="ulz--content">
                                            <span class="ulz--label"><?php esc_html_e('You have previously unlocked this download and it won\'t count toward any plan limitations', 'heilz'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php else: ?>

                            <?php

                            $has_ondemand = $has_subscriptions = false;
                            foreach( $utilities_download_data as $data ) {
                                if( $data['type'] == 'listing_subscription_download_plan' ) {
                                    $has_subscriptions = true;
                                }
                                if( $data['type'] == 'listing_download_plan' ) {
                                    $has_ondemand = true;
                                }
                            }

                            ?>

                            <div class="ulz--plans ulz-no-select">

                                <?php if( class_exists('WC_Subscriptions_Manager') && $has_ondemand && $has_subscriptions ): ?>
                                    <div class="ulz-section-toggle"
                            			data-section-primary="plans"
                            			data-section-secondary="subscriptions">
                                        <div class="ulz--primary">
                            				<?php esc_html_e('On-demand', 'heilz'); ?>
                                        </div>
                                        <div class="ulz--toggle">
                                        	<span></span>
                                        </div>
                                        <div class="ulz--secondary">
                            				<?php esc_html_e('Subscription', 'heilz'); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php $first_selected = false; ?>

                                <div class="ulz--sections">
                                    <div class="ulz--section ulz--active" data-id="plans">
                                        <?php foreach( $utilities_download_data as $id => $data ): ?>
                                            <?php if( $data['type'] !== 'listing_download_plan' ) { continue; } ?>
                                            <label class="<?php if( $data['is_limit_reached'] ) { echo ' ulz--limit'; } if( $data['available'] && ! $data['is_limit_reached'] ) { echo ' ulz--available'; } if( $data['is_freebie'] ) { echo ' freebie'; } ?>">
                                                <input type="radio" name="download_plan" value="<?php echo (int) $id; ?>"<?php if( $data['is_limit_reached'] ) { echo ' disabled'; } ?>
                                                <?php if( ! $first_selected && ( $data['is_freebie'] || $data['available'] ) ) { echo 'checked'; $first_selected = true; } ?>>
                                                <div class="ulz--item">
                                                    <div class="ulz--container">
                                                        <div class="ulz--selection">
                                                            <i class="material-icons unchecked">radio_button_unchecked</i>
                                                            <i class="material-icons checked">radio_button_checked</i>
                                                        </div>
                                                        <div class="ulz--content">
                                                            <div class="ulz--headword">
                                                                <div class="ulz--name"><?php echo esc_html( $data['title'] ); ?></div>
                                                                <?php if( ! $data['available'] ): ?>
                                                                    <div class="ulz--price">
                                                                        <?php echo wp_kses_post( $data['price_html'] ); ?>
                                                                    </div>
                                                                <?php elseif( $data['available'] && ! $data['is_limit_reached']): ?>
                                                                    <div>
                                                                        <span class="ulz--available-label"><?php esc_html_e('Available'); ?></span>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <?php if( $data['available'] ): ?>
                                                                <div class="ulz--availabe">
                                                                    <span class="ulz--label">
                                                                        <?php if( $data['available_left'] === null ): ?>
                                                                            <?php esc_html_e('Unlimited downloads left'); ?>
                                                                        <?php else: ?>
                                                                            <?php echo sprintf( esc_html__('%s available downloads'), (int) $data['available_left'] ); ?>
                                                                        <?php endif; ?>
                                                                    </span>
                                                                </div>
                                                            <?php else: ?>
                                                                <span class="ulz--info">
                                                                    <?php if( $data['is_limit_reached'] ): ?>
                                                                        <?php esc_html_e('Plan limitation has been reached', 'utillz-enhance'); ?>
                                                                    <?php else: ?>
                                                                        <?php if( $data['price'] > 0 ): ?>
                                                                            <?php echo sprintf( _n( '%s download', '%s downloads', $data['limit'], 'utillz-enhance' ), $data['limit'] == 0 ? esc_html__( 'Unlimited', 'utillz-enhance' ) : $data['limit'] ); ?>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php if( class_exists('WC_Subscriptions_Manager') ): ?>
                                        <div class="ulz--section<?php if( ! $has_ondemand && $has_subscriptions ) { echo ' ulz--active'; } ?>" data-id="subscriptions">
                                            <?php foreach( $utilities_download_data as $id => $data ): ?>
                                                <?php if( $data['type'] !== 'listing_subscription_download_plan' ) { continue; } ?>
                                                <label class="<?php if( $data['is_limit_reached'] ) { echo ' ulz--limit'; } if( $data['available'] && ! $data['is_limit_reached'] ) { echo ' ulz--available'; } if( $data['is_freebie'] ) { echo ' freebie'; } ?>">
                                                    <input type="radio" name="download_plan" value="<?php echo (int) $id; ?>">
                                                    <div class="ulz--item">
                                                        <div class="ulz--container">
                                                            <div class="ulz--selection">
                                                                <i class="material-icons unchecked">radio_button_unchecked</i>
                                                                <i class="material-icons checked">radio_button_checked</i>
                                                            </div>
                                                            <div class="ulz--content">
                                                                <div class="ulz--headword">
                                                                    <div class="ulz--name"><?php echo esc_html( $data['title'] ); ?></div>
                                                                    <?php if( ! $data['available'] ): ?>
                                                                        <div class="ulz--price">
                                                                            <?php echo wp_kses_post( $data['price_html'] ); ?>
                                                                        </div>
                                                                    <?php elseif( $data['available'] && ! $data['is_limit_reached']): ?>
                                                                        <div>
                                                                            <span class="ulz--available-label"><?php esc_html_e('Available'); ?></span>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <?php if( $data['available'] ): ?>
                                                                    <div class="ulz--availabe">
                                                                        <span class="ulz--label">
                                                                            <?php if( $data['available_left'] === null ): ?>
                                                                                <?php esc_html_e('Unlimited downloads left'); ?>
                                                                            <?php else: ?>
                                                                                <?php echo sprintf( esc_html__('%s available downloads'), (int) $data['available_left'] ); ?>
                                                                            <?php endif; ?>
                                                                        </span>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <span class="ulz--info">
                                                                        <?php if( $data['is_limit_reached'] ): ?>
                                                                            <?php esc_html_e('Plan limitation has been reached', 'utillz-enhance'); ?>
                                                                        <?php else: ?>
                                                                            <?php if( $data['price'] > 0 ): ?>
                                                                                <?php echo sprintf( _n( '%s download', '%s downloads', $data['limit'], 'utillz-enhance' ), $data['limit'] == 0 ? esc_html__( 'Unlimited', 'utillz-enhance' ) : $data['limit'] ); ?>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        <?php endif; ?>
                    </div>

                    <div class="ulz-action-footer ulz-text-center ulz-mt-2">
                        <div class="ulz--action">
                            <a href="#" class="ulz-button ulz--large ulz-block" data-action="action-download">
                                <span><i class="material-icons ulz-mr-1">file_download</i></span>
                                <span>
                                    <?php esc_html_e('Download', 'heilz'); ?>
                                </span>
                                <?php Ucore()->preloader(); ?>
                            </a>
                        </div>
                    </div>

                <?php else: ?>

                    <p class="ulz-error-holder ulz-text-center">
                        <span class="ulz-error ulz--no-arrow ulz-mt-0">
                            <?php esc_html_e('No products of type `Listing Download` were selected in your action type', 'heilz'); ?>
                        </span>
                    </p>

                <?php endif; ?>

            <?php else: ?>

                <p class="ulz-error-holder ulz-text-center">
                    <span class="ulz-error ulz--no-arrow ulz-mt-0">
                        <?php esc_html_e('Activate WooCommerce in order to display the download plans', 'heilz'); ?>
                    </span>
                </p>

            <?php endif; ?>

        </div>

        <?php return ob_get_clean();

    }

}
