<?php

use \UtillzCore\Inc\Src\Listing_Type\Listing_Type;

class Utillz_Elementor_Listings extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ulz-listings';
	}

	public function get_title() {
		return __( 'Listings', 'utillz-enhance' );
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
			'posts_per_page',
			[
				'label' => __( 'Posts per Page', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 99,
				'step' => 1,
				'default' => 12,
			]
		);

		$this->add_control(
			'columns',
			[
				'label' => __( 'Columns', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => apply_filters('utillz/display/explore/columns', [
					5 => esc_html__('20% — Small', 'utillz-core'),
					4 => esc_html__('25% — Medium', 'utillz-core'),
					3 => esc_html__('33% — Large', 'utillz-core'),
					2 => esc_html__('50% — Supersize', 'utillz-core'),
				]),
				'label_block' => true,
				'default' => 3,
			]
		);

		$listing_types = [];
        $post_types = get_posts([
            'post_type' => 'ulz_listing_type',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ]);
        foreach( $post_types as $post_type ) {
            $listing_types[ $post_type->ID ] = $post_type->post_title;
        }

        $this->add_control(
			'style',
			[
				'label' => __( 'Display', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => [
					'landscape' => esc_html__('Landscape', 'utillz-core'),
					'square' => esc_html__('Square', 'utillz-core'),
					'portrait' => esc_html__('Portrait', 'utillz-core'),
					'auto' => esc_html__('Automatic — Masonry', 'utillz-core'),
				],
				'label_block' => true,
				'default' => 'grid',
			]
		);

        $this->add_control(
			'listing_type',
			[
				'label' => __( 'Select Listing Type', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => $listing_types,
				'label_block' => true,
			]
		);

		$this->add_control(
			'sorting',
			[
                'label' => __( 'Sorting', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'latest' => esc_html__('Latest', 'utillz-enhance'),
					'top_rated' => esc_html__('Top Rated', 'utillz-enhance'),
					'priority' => esc_html__('Priority', 'utillz-enhance'),
					'random' => esc_html__('Random', 'utillz-enhance'),
                ],
				'label_block' => true,
				'default' => 'latest',
			]
		);

		$taxonomies = [
            'none' => __( 'None', 'utillz-enhance' ),
            'ulz_listing_category' => __( 'Categories', 'utillz-enhance' ),
            'ulz_listing_region' => __( 'Regions', 'utillz-enhance' ),
            'ulz_listing_tag' => __( 'Tags', 'utillz-enhance' ),
        ];

        // add custom taxonomies
        $custom_taxonomies = Ucore()->get_custom_taxonomies();
        foreach( $custom_taxonomies as $custom_taxonomy ) {
            $taxonomies[ Ucore()->prefix( $custom_taxonomy->slug ) ] = $custom_taxonomy->name;
        }

		$this->add_control(
			'hr',
			[
                'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'selection',
			[
                'label' => __( 'Selection by', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'taxonomy' => esc_html__('Taxonomy', 'utillz-enhance'),
					'collection' => esc_html__('Collection', 'utillz-enhance'),
                ],
				'label_block' => true,
				'default' => 'taxonomy',
			]
		);

		$this->add_control(
			'taxonomy',
			[
                'label' => __( 'Taxonomy', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $taxonomies,
				'condition' => [
                    'selection' => 'taxonomy'
                ],
			]
		);

		foreach( $taxonomies as $tax_id => $tax_name ) {
			$terms = [];
			$terms_obj = get_terms( $tax_id, [
			    'hide_empty' => false,
			]);
			if( empty( $terms_obj ) || is_wp_error( $terms_obj ) ) {
				continue;
			}
			foreach( $terms_obj as $term_obj ) {
				$terms[ $term_obj->term_id ] = $term_obj->name;
			}
			$this->add_control(
				sprintf( 'terms-%s', $tax_id ),
				[
	                'label' => sprintf( __( 'Terms - %s', 'utillz-enhance' ), $tax_name ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'options' => $terms,
					'label_block' => true,
					'multiple' => true,
					'condition' => [
						'selection' => 'taxonomy',
	                    'taxonomy' => $tax_id,
	                ],
				]
			);
		}

		$collections = new \WP_Query([
			'post_type' => 'ulz_collection',
			'post_status' => 'publish',
			// 'fields' => 'ids'
		]);

		$collection_options = [];
		if( $collections->have_posts() ) {
			foreach( $collections->posts as $collection ) {
				$collection_options[ $collection->ID ] = $collection->post_title;
			}
		}

		$this->add_control(
			'collection',
			[
                'label' => __( 'Collection', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $collection_options,
				'label_block' => true,
			]
		);

        $this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		extract( $settings );

		global $ulz_listing_style;
		$ulz_listing_style = $style;

		$posts_per_page = max( (int) $posts_per_page, 1 );

        $args = [
            'post_type' => 'ulz_listing',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
        ];

		$meta_query = [];

		// listing type
        if( $listing_type ) {
            $listing_type = new Listing_Type( $listing_type );
			if( $listing_type->post ) {
				$meta_query['relation'] = 'AND';
				$meta_query[] = [
	                'key' => 'ulz_listing_type',
	                'value' => $listing_type->id,
	                'compare' => '=',
	            ];
			}
        }

		// collection
		if( $selection == 'collection' ) {

			$listings = new \WP_Query([
			    'post_type' => 'ulz_listing',
			    'posts_per_page' => -1,
			    'fields' => 'ids',
			    'meta_query' => [
			        'relation' => 'AND',
			        [
			            'key' => 'ulz_collection',
			            'value' => $collection,
			            'compare' => '='
			        ]
			    ]
			]);

			if( $listings->have_posts() ) {
				$args['post__in'] = $listings->posts;
			}

		}
		// taxonomy
		else{
			if( $taxonomy && $taxonomy !== 'none' ) {
				$term_key = sprintf( 'terms-%s', $taxonomy );
				if( isset( $settings[ $term_key ] ) ) {
					$terms = $settings[ $term_key ];
					if( $terms ) {
						$meta_query[] = [
			                'key' => $taxonomy,
			                'value' => $terms,
			                'compare' => 'IN',
			            ];
					}
				}
	        }
		}

		$args['meta_query'] = $meta_query;

        switch( $sorting ) {
            case 'top_rated':

				global $wpdb;

				$results = $wpdb->get_results(
					$wpdb->prepare("
						SELECT *
						FROM {$wpdb->posts}, {$wpdb->options} as o
						WHERE {$wpdb->posts}.post_type = 'ulz_listing'
						AND {$wpdb->posts}.post_status = 'publish'
						AND o.option_name LIKE CONCAT( '_transient_ulz_reviews_average_%', {$wpdb->posts}.ID )
						GROUP BY {$wpdb->posts}.ID
						ORDER BY option_value DESC
					", $posts_per_page )
				);

				$post_ids = [];
				foreach( $results as $row ) {
					$post_ids[] = $row->ID;
				}

				$args['post__in'] = $post_ids;
				$args['orderby'] = 'post__in';

                break;

			case 'priority':
				$args['meta_key'] = 'ulz_priority';
				$args['orderby'] = [
					'meta_value_num' => 'DESC',
					'date' => 'DESC',
				];
				$args['order'] = 'DESC';
				break;
			case 'random':
				$args['orderby'] = 'rand';
				break;
        }

		$args['meta_query'] = $meta_query;
        $listings = new \WP_Query( $args );

        ob_start(); ?>

        <section class="ulz-elementor-section ulz-elementor-row">
            <div class="ulz-flex--full ulz-justify-center">

				<?php if( $listings ): ?>
					<div class="ulz-explore-columns--<?php echo (int) $columns; ?> ulz-explore-style--<?php echo esc_attr( $style ); ?>">
						<div class="ulz-explore-listings">

							<?php if( $style == 'auto' ): ?>

								<?php global $post; ?>

								<div class="ulz-listings-columns" data-chunks="<?php echo (int) $columns; ?>">
				                    <?php foreach( Ucore()->listing_chunks( $listings->posts, (int) $columns ) as $chunk ): ?>
										<div class="ulz-listings-column">
			                                <ul class="ulz-listings">
			                                    <?php foreach( $chunk as $item ): $post = $item->post; setup_postdata( $post ); ?>
			                                        <li class="ulz-listing-item <?php Ucore()->listing_class(); ?>"
														data-index="<?php echo (int) $item->index; ?>"
														data-preview-params='<?php echo Uhance()->get_listing_preview_params( get_the_ID() ); ?>'
														>
			                                            <?php Ucore()->the_template('explore/listing/listing'); ?>
			                                        </li>
			                                    <?php endforeach; wp_reset_postdata(); ?>
			                                </ul>
			                            </div>
				                    <?php endforeach; ?>
				                </div>

							<?php else: ?>

				                <div class="ulz-listings">
									<?php $index = 0; ?>
		                            <?php while( $listings->have_posts() ): $listings->the_post() ?>
		                                <li class="ulz-listing-item <?php Ucore()->listing_class(); ?>"
											data-index="<?php echo (int) $index++; ?>"
											data-preview-params='<?php echo Uhance()->get_listing_preview_params( get_the_ID() ); ?>'
											>
		                                    <?php Ucore()->the_template('explore/listing/listing'); ?>
		                                </li>
		                            <?php endwhile; wp_reset_postdata(); ?>
				                </div>

							<?php endif; ?>

						</div>
					</div>
				<?php else: ?>
					<p><?php esc_html_e( 'No results were found.', 'utillz-enhance' ) ?></p>
				<?php endif; ?>

            </div>
        </section>

		<?php echo ob_get_clean(); $ulz_listing_layout = 'grid';

	}

}
