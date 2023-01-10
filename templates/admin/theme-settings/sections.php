<?php

defined('ABSPATH') || exit;

use \UtillzCore\Inc\Src\Form\Component as Form;

$form = new Form( Form::Storage_Option );

?>

<section class="ulz-sections" :class="{'ulz-none': tabMain !== 'theme'}">

    <aside class="ulz-section ulz-section-large" :class="{'ulz-none': tabSub !== 'styles'}">
        <div class="ulz-panel-heading">
            <h3 class="ulz-title"><?php esc_html_e( 'Styles', 'utillz-enhance' ); ?></h3>
        </div>
        <div class="ulz-form ulz-grid">
            <?php

                $form->render([
                    'type' => 'heading',
                    'name' => esc_html__('Specify the main theme colors', 'utillz-enhance'),
                    'description' => sprintf( '%s. <a href="https://htmlcolorcodes.com/color-picker/" target="_blank">%s</a>', esc_html__('You can use HEX, RGB or HSL color formats', 'utillz-enhance'), esc_html__('Click here to pick a nice color', 'utillz-enhance') ) . '</a>',
                ]);

                $form->render([
                    'type' => 'color',
                    'id' => 'color_primary',
                    'name' => esc_html__('Primary color', 'utillz-enhance'),
                    'placeholder' => '#2a6b6b',
                    'col' => 6
                ]);

                $form->render([
                    'type' => 'color',
                    'id' => 'color_secondary',
                    'name' => esc_html__('Secondary color', 'utillz-enhance'),
                    'placeholder' => '#000',
                    'col' => 6
                ]);

                $form->render([
                    'type' => 'color',
                    'id' => 'color_system',
                    'name' => esc_html__('System', 'utillz-enhance'),
                    'placeholder' => '#2e89ff',
                    'col' => 6
                ]);

                $form->render([
                    'type' => 'color',
                    'id' => 'color_system_background',
                    'name' => esc_html__('System background', 'utillz-enhance'),
                    'placeholder' => '#eff6ff',
                    'col' => 6
                ]);

                $form->render([
                    'type' => 'color',
                    'id' => 'color_listing_over',
                    'name' => esc_html__('Listing over background', 'utillz-enhance'),
                    'placeholder' => 'rgba(0,145,176,0.4)',
                    'col' => 12
                ]);

                $form->render([
                    'type' => 'color',
                    'id' => 'marker_color',
                    'name' => esc_html__('Marker color', 'utillz-enhance'),
                    'placeholder' => '#fff',
                    'col' => 6
                ]);

                $form->render([
                    'type' => 'color',
                    'id' => 'marker_text_color',
                    'name' => esc_html__('Marker text color', 'utillz-enhance'),
                    'placeholder' => '#111',
                    'col' => 6
                ]);

                $form->render([
                    'type' => 'checkbox',
                    'id' => 'enable_dark_header',
                    'name' => esc_html__('Enable dark header mode', 'utillz-enhance'),
                    'col' => 6
                ]);

                $form->render([
                    'type' => 'checkbox',
                    'id' => 'enable_dark_footer',
                    'name' => esc_html__('Enable dark footer Mode', 'utillz-enhance'),
                    'col' => 6
                ]);

                $form->render([
                    'type' => 'upload',
                    'id' => 'signin_image',
                    'name' => esc_html__('Sign in background image', 'utillz-enhance'),
                ]);

            ?>

            <div class="ulz-form-group ulz-col-12 ulz-mt-3">
                <button type="submit" class="ulz-button ulz--large">
                    <span><?php esc_html_e( 'Save changes', 'utillz-enhance' ); ?></span>
                </button>
            </div>

        </div>
    </aside>

    <aside class="ulz-section ulz-section-large" :class="{'ulz-none': tabSub !== 'fonts'}">
        <div class="ulz-panel-heading">
            <h3 class="ulz-title"><?php esc_html_e( 'Fonts', 'utillz-enhance' ); ?></h3>
        </div>
        <div class="ulz-form ulz-grid">
            <?php

                $form->render([
                    'type' => 'text',
                    'id' => 'font_heading',
                    'name' => esc_html__('Heading font', 'utillz-enhance'),
                    'description' => sprintf( esc_html__('Set custom font for headings from Google Fonts. %s', 'utillz-enhance'), '<a href="https://fonts.google.com/" target="_blank">Search fonts</a>' ),
                    'placeholder' => Utheme()->get_font_family_heading(),
                ]);

                $form->render([
                    'type' => 'text',
                    'id' => 'font_body',
                    'name' => esc_html__('Body font', 'utillz-enhance'),
                    'description' => sprintf( esc_html__('Set custom font for site content. %s', 'utillz-enhance'), '<a href="https://fonts.google.com/" target="_blank">Search fonts</a>' ),
                    'placeholder' => Utheme()->get_font_family_body(),
                ]);

            ?>

            <div class="ulz-form-group ulz-col-12 ulz-mt-3">
                <button type="submit" class="ulz-button ulz--large">
                    <span><?php esc_html_e( 'Save changes', 'utillz-enhance' ); ?></span>
                </button>
            </div>

        </div>
    </aside>

    <aside class="ulz-section ulz-section-large" :class="{'ulz-none': tabSub !== 'header'}">
        <div class="ulz-panel-heading">
            <h3 class="ulz-title"><?php esc_html_e( 'Header', 'utillz-enhance' ); ?></h3>
        </div>
        <div class="ulz-form ulz-grid">
            <?php

                $form->render([
                    'type' => 'text',
                    'id' => 'site_name',
                    'name' => esc_html__('Custom site name', 'utillz-enhance'),
                    'placeholder' => esc_html( Utheme()->get_name() )
                ]);

                /*
                 * logo
                 *
                 */
                $form->render([
                    'type' => 'select',
                    'id' => 'logo_type',
                    'name' => esc_html__('Site logo type', 'utillz-enhance'),
                    'options' => [
                        'upload' => esc_html__('Upload', 'utillz-enhance'),
                        'path' => esc_html__('Path', 'utillz-enhance'),
                    ],
                    'value' => 'upload',
                    'allow_empty' => false,
                ]);

                // upload
                $form->render([
                    'type' => 'upload',
                    'id' => 'logo',
                    'name' => esc_html__('Upload site logo', 'utillz-enhance'),
                    'dependency' => [
                        'id' => 'logo_type',
                        'value' => 'upload',
                        'compare' => '=',
                    ],
                    'col' => 6
                ]);

                $form->render([
                    'type' => 'upload',
                    'id' => 'logo_white',
                    'name' => esc_html__('Upload white logo', 'utillz-enhance'),
                    'dependency' => [
                        'id' => 'logo_type',
                        'value' => 'upload',
                        'compare' => '=',
                    ],
                    'col' => 6
                ]);

                // path
                $form->render([
                    'type' => 'text',
                    'id' => 'logo_path',
                    'name' => esc_html__('Path to site logo', 'utillz-enhance'),
                    'dependency' => [
                        'id' => 'logo_type',
                        'value' => 'path',
                        'compare' => '=',
                    ],
                    'col' => 6
                ]);

                $form->render([
                    'type' => 'text',
                    'id' => 'logo_path_white',
                    'name' => esc_html__('Path to white logo', 'utillz-enhance'),
                    'dependency' => [
                        'id' => 'logo_type',
                        'value' => 'path',
                        'compare' => '=',
                    ],
                    'col' => 6
                ]);

                $form->render([
                    'type' => 'checkbox',
                    'id' => 'enable_dropdown_favorites',
                    'name' => esc_html__('Enable favorites in account drop-down', 'utillz-enhance'),
                ]);

                $form->render([
                    'type' => 'select',
                    'id' => 'primary_search_form',
                    'name' => esc_html__( 'Select primary search form', 'utillz-enhance' ),
                    'options' => [
                        'query' => [
                            'post_type' => 'ulz_search_form',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                        ]
                    ],
                ]);

                $form->render([
                    'type' => 'checkbox',
                    'id' => 'enable_cta',
                    'name' => esc_html__('Enable header call-to-action', 'utillz-enhance'),
                ]);

                $form->render([
                    'type' => 'text',
                    'id' => 'cta_label',
                    'name' => esc_html__('Call-to-action label', 'utillz-enhance'),
                    'dependency' => [
                        'id' => 'enable_cta',
                        'value' => true,
                        'compare' => '=',
                        'style' => 'ulz-opacity-30', // css class
                    ],
                ]);

                $form->render([
                    'type' => 'text',
                    'id' => 'cta_target',
                    'name' => esc_html__('Call-to-action target', 'utillz-enhance'),
                    'placeholder' => 'https://',
                    'dependency' => [
                        'id' => 'enable_cta',
                        'value' => true,
                        'compare' => '=',
                        'style' => 'ulz-opacity-30', // css class
                    ],
                ]);

            ?>

            <div class="ulz-form-group ulz-col-12 ulz-mt-3">
                <button type="submit" class="ulz-button ulz--large">
                    <span><?php esc_html_e( 'Save changes', 'utillz-enhance' ); ?></span>
                </button>
            </div>

        </div>
    </aside>

    <aside class="ulz-section ulz-section-large" :class="{'ulz-none': tabSub !== 'footer'}">
        <div class="ulz-panel-heading">
            <h3 class="ulz-title"><?php esc_html_e( 'Footer', 'utillz-enhance' ); ?></h3>
        </div>
        <div class="ulz-form ulz-grid">
            <?php

                $form->render([
                    'type' => 'textarea',
                    'id' => 'footer_summary',
                    'name' => esc_html__('Footer summary', 'utillz-enhance'),
                ]);

                $form->render([
                    'type' => 'text',
                    'id' => 'footer_copy',
                    'name' => esc_html__('Footer copyright text', 'utillz-enhance'),
                ]);

                $form->render([
                    'type' => 'text',
                    'id' => 'footer_bottom_right',
                    'name' => esc_html__('Footer bottom right text', 'utillz-enhance'),
                ]);

                $form->render([
                    'type' => 'text',
                    'id' => 'footer_account',
                    'name' => esc_html__('Footer account text', 'utillz-enhance'),
                ]);

                $form->render([
                    'type' => 'number',
                    'input_type' => 'stepper',
                    'style' => 'v2',
                    'id' => 'footer_columns',
                    'name' => esc_html__('Number of widget columns', 'utillz-enhance'),
                    'min' => 3,
                    'max' => 6,
                    'value' => 4,
                ]);

            ?>

            <div class="ulz-form-group ulz-col-12 ulz-mt-3">
                <button type="submit" class="ulz-button ulz--large">
                    <span><?php esc_html_e( 'Save changes', 'utillz-enhance' ); ?></span>
                </button>
            </div>

        </div>
    </aside>

    <aside class="ulz-section ulz-section-large" :class="{'ulz-none': tabSub !== 'mobile'}">
        <div class="ulz-panel-heading">
            <h3 class="ulz-title"><?php esc_html_e( 'Mobile', 'utillz-enhance' ); ?></h3>
        </div>
        <div class="ulz-form ulz-grid">
            <?php

                $form->render([
                    'type' => 'repeater',
                    'id' => 'mobile_bar_nav',
                    'name' => esc_html__('Action bar', 'utillz-enhance'),
                    'description' => esc_html__('Customize your mobile navigation using multiple actions.', 'utillz-enhance'),
                    'templates' => [

                        /*
                         * custom link
                         *
                         */
                        'custom' => [
                            'name' => esc_html__( 'Custom', 'utillz-enhance' ),
                            'heading' => 'name',
                            'fields' => [
                                'name' => [
                                    'type' => 'text',
                                    'name' => esc_html__( 'Name', 'utillz-enhance' ),
                                ],
                                'url' => [
                                    'type' => 'text',
                                    'name' => esc_html__( 'URL', 'utillz-enhance' ),
                                    'placeholder' => 'https://',
                                ],
                                'icon' => [
                                    'type' => 'icon',
                                    'name' => esc_html__( 'Icon', 'utillz-enhance' )
                                ],
                                /*'highlight' => [
                                    'type' => 'checkbox',
                                    'name' => esc_html__( 'Highlight', 'utillz-enhance' ),
                                    'description' => esc_html__( 'Enable this option if you want to gain more visibility for this item', 'utillz-enhance' ),
                                ],*/
                                'hide_out' => [
                                    'type' => 'checkbox',
                                    'name' => esc_html__( 'Hide when logged out', 'utillz-enhance' ),
                                    'description' => esc_html__( 'Hide this item if the user is not logged in', 'utillz-enhance' ),
                                ],
                                'hide_in' => [
                                    'type' => 'checkbox',
                                    'name' => esc_html__( 'Hide when logged in', 'utillz-enhance' ),
                                    'description' => esc_html__( 'Hide this item if the user is logged in', 'utillz-enhance' ),
                                ],
                            ]
                        ],

                        /*
                         * pre-defined
                         *
                         */
                        'defined' => [
                            'name' => esc_html__( 'Pre-defined', 'utillz-enhance' ),
                            'heading' => 'name',
                            'fields' => [
                                'name' => [
                                    'type' => 'text',
                                    'name' => esc_html__( 'Name', 'utillz-enhance' ),
                                ],
                                'id' => [
                                    'type' => 'select',
                                    'name' => esc_html__( 'Select page', 'utillz-enhance' ),
                                    'options' => [
                                        'explore' => esc_html__( 'Explore page', 'utillz-enhance' ),
                                        'submission' => esc_html__( 'Submission page', 'utillz-enhance' ),
                                        'messages' => esc_html__( 'Messages page', 'utillz-enhance' ),
                                        'notifications' => esc_html__( 'Open notifications panel', 'utillz-enhance' ),
                                        'favorites' => esc_html__( 'Open favorites modal', 'utillz-enhance' ),
                                        'signup' => esc_html__( 'Open sign up modal / Sign out', 'utillz-enhance' ),
                                    ]
                                ],
                                'icon' => [
                                    'type' => 'icon',
                                    'name' => esc_html__( 'Icon', 'utillz-enhance' )
                                ],
                                /*'highlight' => [
                                    'type' => 'checkbox',
                                    'name' => esc_html__( 'Highlight', 'utillz-enhance' ),
                                    'description' => esc_html__( 'Enable this option if you want to gain more visibility for this item', 'utillz-enhance' ),
                                ],*/
                                'hide_out' => [
                                    'type' => 'checkbox',
                                    'name' => esc_html__( 'Hide when logged out', 'utillz-enhance' ),
                                    'description' => esc_html__( 'Hide this item if the user is not logged in', 'utillz-enhance' ),
                                ],
                                'hide_in' => [
                                    'type' => 'checkbox',
                                    'name' => esc_html__( 'Hide when logged in', 'utillz-enhance' ),
                                    'description' => esc_html__( 'Hide this item if the user is logged in', 'utillz-enhance' ),
                                ],
                            ]
                        ]

                    ]
                ]);

            ?>

            <div class="ulz-form-group ulz-col-12 ulz-mt-3">
                <button type="submit" class="ulz-button ulz--large">
                    <span><?php esc_html_e( 'Save changes', 'utillz-enhance' ); ?></span>
                </button>
            </div>

        </div>
    </aside>

    <aside class="ulz-section ulz-section-large" :class="{'ulz-none': tabSub !== 'social'}">
        <div class="ulz-panel-heading">
            <h3 class="ulz-title"><?php esc_html_e( 'Social', 'utillz-enhance' ); ?></h3>
        </div>
        <div class="ulz-form ulz-grid">
            <?php

                $form->render([
                    'type' => 'repeater',
                    'id' => 'social_icons',
                    'name' => esc_html__('Social media icons', 'utillz-enhance'),
                    'description' => esc_html__('Add the social media icons that you need, then use the element anywere on your site with the following shortcode: [utillz-social-icons]', 'utillz-enhance'),
                    'button' => [
                        'label' => esc_html__('Add new icon', 'utillz-enhance')
                    ],
                    'templates' => [

                        'icon' => [
                            'name' => esc_html__( 'Icon', 'utillz-enhance' ),
                            'heading' => 'title',
                            'fields' => [
                                'title' => [
                                    'type' => 'text',
                                    'name' => esc_html__( 'Title', 'utillz-enhance' ),
                                ],
                                'icon' => [
                                    'type' => 'icon',
                                    'name' => esc_html__( 'Icon', 'utillz-enhance' )
                                ],
                                'url' => [
                                    'type' => 'text',
                                    'name' => esc_html__( 'URL', 'utillz-enhance' ),
                                    'placeholder' => 'https://',
                                    'col' => 6,
                                ],
                                'color' => [
                                    'type' => 'color',
                                    'name' => esc_html__( 'Background color (optional)', 'utillz-enhance' ),
                                    'col' => 6,
                                ],
                            ]
                        ],
                    ]
                ]);

            ?>

            <div class="ulz-form-group ulz-col-12 ulz-mt-3">
                <button type="submit" class="ulz-button ulz--large">
                    <span><?php esc_html_e( 'Save changes', 'utillz-enhance' ); ?></span>
                </button>
            </div>

        </div>
    </aside>

</section>
