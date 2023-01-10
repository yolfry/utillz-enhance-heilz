<?php if( function_exists('Ucore') && $social_icons = Ucore()->json_decode( get_option( 'ulz_social_icons' ) ) ): ?>
    <div class="ulz-social-icons">
        <ul>
            <?php foreach( $social_icons as $icon ): ?>
                <li>
                    <a target="_blank" href="<?php echo esc_url( $icon->fields->url ); ?>" style="<?php if( $icon->fields->color ) { echo sprintf( 'background-color: %s', $icon->fields->color ); } ?>">
                        <?php echo utillz_core()->icon->get( $icon->fields->icon__icon, $icon->fields->icon__set ); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
