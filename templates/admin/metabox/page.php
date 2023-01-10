<?php

defined('ABSPATH') || exit;

$panel = \UtillzCore\Inc\Src\Admin\Panel::instance();
$panel->form->set( $panel->form::Storage_Meta );

?>


<div class="ulz-panel ulz-outer">
    <div class="ulz-section">
        <div class="ulz-form ulz-grid">
                <?php

                    $panel->form->render([
                        'type' => 'checkbox',
                        'id' => 'hide_heading',
                        'name' => esc_html__('Hide heading', 'utillz-enhance'),
                    ]);

                    $panel->form->render([
                        'type' => 'checkbox',
                        'id' => 'enable_wide_page',
                        'name' => esc_html__('Enable wide page', 'utillz-enhance'),
                    ]);

                    $panel->form->render([
                        'type' => 'checkbox',
                        'id' => 'enable_dark_header',
                        'name' => esc_html__('Enable dark header mode', 'utillz-enhance'),
                    ]);

                    $panel->form->render([
                        'type' => 'text',
                        'id' => 'heading_custom_title',
                        'name' => esc_html__('Heading custom title', 'utillz-enhance'),
                        'dependency' => [
                            'id' => 'hide_heading',
                            'value' => true,
                            'compare' => '!=',
                        ],
                        'col' => 6
                    ]);

                    $panel->form->render([
                        'type' => 'text',
                        'id' => 'heading_summary',
                        'name' => esc_html__('Heading summary', 'utillz-enhance'),
                        'dependency' => [
                            'id' => 'hide_heading',
                            'value' => true,
                            'compare' => '!=',
                        ],
                        'col' => 6
                    ]);

                    $panel->form->render([
                        'type' => 'text',
                        'id' => 'heading_background_color',
                        'name' => esc_html__('Heading background color', 'utillz-enhance'),
                        'placeholder' => '#fff',
                        'dependency' => [
                            'id' => 'hide_heading',
                            'value' => true,
                            'compare' => '!=',
                        ],
                        'col' => 6
                    ]);

                    $panel->form->render([
                        'type' => 'text',
                        'id' => 'heading_text_color',
                        'name' => esc_html__('Heading text color', 'utillz-enhance'),
                        'placeholder' => '#000',
                        'dependency' => [
                            'id' => 'hide_heading',
                            'value' => true,
                            'compare' => '!=',
                        ],
                        'col' => 6
                    ]);

                    $panel->form->render([
                        'type' => 'upload',
                        'id' => 'heading_background_image',
                        'name' => esc_html__('Heading background image', 'utillz-enhance'),
                        'dependency' => [
                            'id' => 'hide_heading',
                            'value' => true,
                            'compare' => '!=',
                        ],
                    ]);

                    $panel->form->render([
                        'type' => 'checkbox',
                        'id' => 'overlap_header',
                        'name' => esc_html__('Overlap header', 'utillz-enhance'),
                    ]);

                    $panel->form->render([
                        'type' => 'checkbox',
                        'id' => 'overlap_header_white',
                        'name' => esc_html__('Use transparent header background color overlapping state', 'utillz-enhance'),
                        'dependency' => [
                            'id' => 'overlap_header',
                            'value' => true,
                            'compare' => '=',
                        ],
                    ]);

                    $panel->form->render([
                        'type' => 'checkbox',
                        'id' => 'hide_primary_search',
                        'name' => esc_html__('Hide primary search', 'utillz-enhance'),
                    ]);

                    $panel->form->render([
                        'type' => 'checkbox',
                        'id' => 'hide_footer',
                        'name' => esc_html__('Hide footer', 'utillz-enhance'),
                        'description' => esc_html__('No footer will be displayed', 'utillz-enhance'),
                    ]);

                    $panel->form->render([
                        'type' => 'checkbox',
                        'id' => 'enable_dark_footer',
                        'name' => esc_html__('Invert footer colors', 'utillz-enhance'),
                        'dependency' => [
                            'id' => 'hide_footer',
                            'value' => true,
                            'compare' => '!=',
                        ],
                        'class' => ['ulz-mb-0']
                    ]);

                ?>

        </div>
    </div>
</div>
