<?php

// use \UtillzCore\Inc\Src\Page\Component as Page;

defined('ABSPATH') || exit;

$panel = \UtillzCore\Inc\Src\Admin\Panel::instance();
$panel->form->set( $panel->form::Storage_Meta );
// $page = Page::instance();

?>

<div class="ulz-panel ulz-outer">
    <div class="ulz-section">
        <div class="ulz-form ulz-grid">

            <?php

                $panel->form->render([
                    'type' => 'checkbox',
                    'id' => 'featured',
                    'name' => esc_html__('Featured article', 'utillz-enhance'),
                ]);

                $panel->form->render([
                    'type' => 'upload',
                    'id' => 'gallery',
                    'name' => esc_html__('Gallery', 'utillz-enhance'),
                    'multiple_upload' => true,
                    'upload_type' => 'image',
                ]);

            ?>

        </div>
    </div>
</div>
