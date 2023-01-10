<?php

class Utillz_Elementor_Product_Table extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ulz-product-table';
	}

	public function get_title() {
		return __( 'Product Table', 'utillz-enhance' );
	}

	public function get_icon() {
		return 'icon-utillz';
	}

	public function get_categories() {
		return [
            'utillz'
        ];
	}

	protected function _register_controls() {

        /*
         * >>>>> section content
         *
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'utillz-enhance' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$products = [];
        $products_obj = get_posts([
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
			'tax_query' => [
                [
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => [
						'listing_download_plan', 'listing_subscription_download_plan'
					],
                ],
			]
        ]);
        foreach( $products_obj as $product ) {
            $products[ $product->ID ] = $product->post_title;
        }

        $this->add_control(
			'product',
			[
				'label' => __( 'Product', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => $products,
				'label_block' => true,
				'default' => 'grid',
			]
		);

        $this->end_controls_section();

	}

	protected function render() {

		if( ! function_exists('wc_get_product') ) {
			return;
		}

		extract( $this->get_settings_for_display() );

		$post = get_post( $product );

		if( ! $post ) {
			return;
		}

		$product = wc_get_product( $post->ID );
		$price = floatval( $product->get_price() );

        ob_start(); ?>

		<div class="ulz-product-table">
			<div class="ulz--name">
				<h5><?php echo esc_html( $post->post_title ); ?></h5>
			</div>
			<div class="ulz--price">
				<?php echo $price ? wp_kses_post( $product->get_price_html() ) : esc_html__('Free', 'utillz-enhance'); ?>
			</div>
			<div class="ulz--content">
				<?php echo do_shortcode( wpautop( $post->post_content ) ); ?>
			</div>
			<div class="ulz--action">
				<a href="<?php echo esc_url( add_query_arg( 'add-to-cart', $product->get_id(), get_home_url() ) ); ?>" class="ulz-button ulz--large ulz--white ulz-block">
					<?php esc_html_e('Purchase now', 'utillz-enhance'); ?>
				</a>
			</div>
		</div>

        <?php echo ob_get_clean();

	}

}
