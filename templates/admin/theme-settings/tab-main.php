<?php

defined('ABSPATH') || exit;

?>

<li :class="{ 'ulz-active': tabMain == 'theme' }">
    <a href="#" v-on:click.prevent="tabClick('theme/styles')">
        <?php esc_html_e( 'Theme', 'utillz-enhance' ); ?>
    </a>
</li>
