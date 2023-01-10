<?php

class Utillz_Elementor_Articles extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ulz-articles';
	}

	public function get_title() {
		return __( 'Articles', 'utillz-enhance' );
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

		$this->add_control(
			'rows',
			[
				'label' => __( 'Rows', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 99,
				'step' => 1,
				'default' => 1,
			]
		);

		$categories = [];
        $terms = get_categories([
            'hide_empty' => false
        ]);
        foreach( $terms as $term ) {
            $categories[ $term->term_id ] = $term->name;
        }

        $this->add_control(
			'categories',
			[
				'label' => __( 'Select Category', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $categories,
				'label_block' => true,
			]
		);

		$this->add_control(
			'no_excerpt', [
				'label' => __( 'Hide excerpt', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'utillz-enhance' ),
				'label_off' => __( 'No', 'utillz-enhance' ),
				'return_value' => 'yes',
				'default' => false,
			]
		);

        $this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		extract( $settings );

        $posts_per_page = 3;

        $articles = new \WP_Query([
			'post_type' => 'post',
			'post_status' => 'publish',
            'posts_per_page' => $posts_per_page * $rows,
            'ignore_sticky_posts' => true,
			'category__in' => is_array( $categories ) ? $categories : [],
		]);

        ob_start(); ?>

		<section class="ulz-elementor-section ulz-elementor-row">
            <div class="ulz-flex--full ulz-justify-center">

                <?php if( $articles->have_posts() ): ?>

                    <div class="ulz-articles<?php if( $no_excerpt ) { echo ' ulz-no-excerpt'; } ?>" data-cols="3">
                        <div class="ulz-grid">
                            <?php while( $articles->have_posts() ): $articles->the_post(); ?>
                                <?php get_template_part( 'templates/article' ); ?>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>
                    </div>

                <?php else: ?>
                    <p><?php esc_html_e( 'No articles were found', 'utillz-enhance' ) ?></p>
                <?php endif; ?>

            </div>
        </section>

		<?php echo ob_get_clean();

	}

}
