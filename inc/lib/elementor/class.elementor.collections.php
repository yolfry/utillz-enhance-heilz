<?php

class Utillz_Elementor_Collections extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ulz-collections';
	}

	public function get_title() {
		return __( 'Collections', 'utillz-enhance' );
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
			'style',
			[
                'label' => __( 'Style', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'wall' => __( 'Wall', 'utillz-enhance' ),
					'cols' => __( 'Columns', 'utillz-enhance' ),
					'stack' => __( 'Stack', 'utillz-enhance' ),
					'thumbs' => __( 'Thumbs', 'utillz-enhance' ),
                ],
				'default' => 'wall',
				'label_block' => true,
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
				'condition' => [
                    'style' => [
						'cols',
						'stack',
					]
                ],
			]
		);

		$this->add_control(
			'columns',
			[
				'label' => __( 'Columns', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 2,
				'max' => 10,
				'step' => 1,
				'default' => 7,
				'condition' => [
                    'style' => 'thumbs'
                ],
			]
		);

		$this->add_control(
			'columns_stack_cols',
			[
				'label' => __( 'Columns', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 2,
				'max' => 4,
				'step' => 1,
				'default' => 3,
				'condition' => [
                    'style' => [
						'stack',
						'cols',
					]
                ],
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'Size', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 20,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'condition' => [
                    'style' => 'thumbs'
                ],
			]
		);

		$this->add_control(
			'wall_grid',
			[
				'label' => __( 'Wall grid', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => false,
				'options' => [
					'4x3' => '4x3',
					'3x2' => '3x2',
				],
				'default' => '4x3',
				'label_block' => true,
				'condition' => [
                    'style' => 'wall'
                ],
			]
		);

		$collection_ids = [];
        $collections = get_posts([
            'post_type' => 'ulz_collection',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ]);
        foreach( $collections as $collection ) {
            $collection_ids[ $collection->ID ] = $collection->post_title;
        }

        $this->add_control(
			'collection_ids',
			[
				'label' => __( 'Select specific collections (optional)', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $collection_ids,
				'label_block' => true,
			]
		);

		$this->add_control(
			'show_tags',
			[
                'label' => __( 'Show tags?', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => true,
				'condition' => [
                    'style' => [
						'cols',
						'stack',
					]
                ],
			]
		);

		$this->add_control(
			'dark_tags',
			[
				'label' => __( 'Dark tag colors?', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => false,
				'condition' => [
                    'style' => [
						'stack',
						'cols',
					]
                ],
			]
		);

		$this->add_control(
			'dark_shadow',
			[
				'label' => __( 'Dark Shadow?', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => false,
				'condition' => [
                    'style' => 'thumbs'
                ],
			]
		);

        $this->end_controls_section();

	}

	protected function render() {

		global $ulz_show_tags, $size;

		$settings = $this->get_settings_for_display();

		extract( $settings );

		$ulz_show_tags = $show_tags;
        $posts_per_page = 0;

		switch( $style ) {
			case 'wall':
				$posts_per_page = 999;
				break;
			case 'cols':
				$posts_per_page = $columns_stack_cols * $rows;
				break;
			case 'stack':
				$posts_per_page = $columns_stack_cols * $rows;
				break;
			case 'thumbs':
				$posts_per_page = 999;
				break;
		}

		$args = [
			'post_type' => 'ulz_collection',
			'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
		];

		if( $collection_ids ) {
			$args['post__in'] = $collection_ids;
		}

        $collections = new \WP_Query( $args );

        ob_start(); ?>

		<section class="ulz-elementor-section ulz-elementor-row">
            <div class="ulz-flex--full ulz-justify-center">

                <?php if( $collections->have_posts() ): ?>

					<?php

						$class = [];
						$class[] = 'ulz-collections--' . esc_attr( $style );
						if( $style == 'wall' ) {
							$class[] = 'ulz--' . esc_attr( $wall_grid );
						}
						if( $style == 'thumbs' ) {
							$class[] = sprintf('ulz--x%s', $columns);
						}
						if( $style == 'stack' || $style == 'cols' ) {
							$class[] = sprintf('ulz--x%s', $columns_stack_cols);
						}
						if( $dark_tags ) {
							$class[] = 'ulz--dark';
						}

					?>

                    <div class="ulz-collections <?php echo implode( ' ', $class ); ?>">
	                    <div class="ulz--inner">
	                        <?php while( $collections->have_posts() ): $collections->the_post(); ?>
	                            <?php get_template_part( 'templates/collection', $style ); ?>
	                        <?php endwhile; wp_reset_postdata(); ?>
	                    </div>
						<?php if( $style == 'thumbs' ): ?>
							<?php $class = $dark_shadow ? ' ulz--dark-shadow' : ''; ?>
							<div class="ulz-nav-shadow<?php echo esc_attr( $class ); ?>" data-direction="prev">
								<a href="#" class="ulz--button">
									<i class="fas fa-arrow-left"></i>
								</a>
							</div>
							<div class="ulz-nav-shadow<?php echo esc_attr( $class ); ?>" data-direction="next">
								<a href="#" class="ulz--button">
									<i class="fas fa-arrow-right"></i>
								</a>
							</div>
						<?php endif; ?>
                    </div>

                <?php else: ?>
                    <p><?php esc_html_e( 'No collections were found.', 'utillz-enhance' ) ?></p>
                <?php endif; ?>

            </div>
        </section>

		<?php echo ob_get_clean();

	}

}
