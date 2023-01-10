<?php

defined('ABSPATH') || exit;

?>

<!-- theme -->
<ul class="ulz-sub-nav ulz-shade" v-if="tabMain == 'theme'">
    <li :class="{ 'ulz-active': tabSub == 'styles' }">
        <a href="#" v-on:click.prevent="tabClick('theme/styles')">
            <?php esc_html_e( 'Styles', 'utillz-enhance' ); ?>
        </a>
    </li>
    <li :class="{ 'ulz-active': tabSub == 'fonts' }">
        <a href="#" v-on:click.prevent="tabClick('theme/fonts')">
            <?php esc_html_e( 'Fonts', 'utillz-enhance' ); ?>
        </a>
    </li>
    <li :class="{ 'ulz-active': tabSub == 'header' }">
        <a href="#" v-on:click.prevent="tabClick('theme/header')">
            <?php esc_html_e( 'Header', 'utillz-enhance' ); ?>
        </a>
    </li>
    <li :class="{ 'ulz-active': tabSub == 'footer' }">
        <a href="#" v-on:click.prevent="tabClick('theme/footer')">
            <?php esc_html_e( 'Footer', 'utillz-enhance' ); ?>
        </a>
    </li>
    <li :class="{ 'ulz-active': tabSub == 'mobile' }">
        <a href="#" v-on:click.prevent="tabClick('theme/mobile')">
            <?php esc_html_e( 'Mobile', 'utillz-enhance' ); ?>
        </a>
    </li>
    <li :class="{ 'ulz-active': tabSub == 'social' }">
        <a href="#" v-on:click.prevent="tabClick('theme/social')">
            <?php esc_html_e( 'Social', 'utillz-enhance' ); ?>
        </a>
    </li>
</ul>
