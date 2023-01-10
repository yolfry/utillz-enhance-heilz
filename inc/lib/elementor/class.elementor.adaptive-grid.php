<?php

class Utillz_Elementor_Boxes extends \Elementor\Widget_Base {

	protected $image_sizes = [
		1 => [ 'x2' ],
		2 => [ 'x2','x2' ],
		3 => [ 'x2','x2','x2' ],
		4 => [ 'x2','x2','x1','x1' ],
		5 => [ 'x2','x1','x1','x1','x1' ],
		6 => [ 'x2','x1','x1','x2','x1','x1' ],
		7 => [ 'x2','x1','x1','x1','x1','x1','x1' ],
		8 => [ 'x1','x1','x1','x1','x1','x1','x1','x1' ],
	];

	public function get_name() {
		return 'ulz-adaptive-grid';
	}

	public function get_title() {
		return __( 'Adaptive Grid', 'utillz-enhance' );
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

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'name', [
				'label' => __( 'Name', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Name' , 'utillz-enhance' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description', [
				'label' => __( 'Description', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Description' , 'utillz-enhance' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Image', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);

		$repeater->add_control(
			'location',
			[
                'label' => __( 'URI Location', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'listing_type' => __( 'Listing Type', 'utillz-enhance' ),
                    'custom' => __( 'Custom', 'utillz-enhance' ),
                ],
				'label_block' => true,
				'default' => 'listing_type',
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

        $repeater->add_control(
			'location_listing_type',
			[
				'label' => __( 'Select Listing Type', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => $listing_types,
				'label_block' => true,
				'condition' => [
                    'location' => 'listing_type'
                ],
			]
		);

		$repeater->add_control(
			'location_custom', [
				'label' => __( 'Custom Location URI', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '#',
				'label_block' => true,
				'condition' => [
                    'location' => 'custom'
                ],
			]
		);

		$this->add_control(
			'boxes',
			[
				'label' => __( 'Boxes', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'title_field' => '{{{ name }}}',
			]
		);

        $this->end_controls_section();

	}

	protected function render() {

		extract( $this->get_settings_for_display() );

		$num_boxes = min( 8, count( $boxes ) );

        ob_start(); ?>

		<section class="ulz-elementor-section ulz-elementor-row">
            <div class="ulz-flex--full ulz-justify-center">
                <div class="ulz-bxs-container">
                    <div class="ulz-bxs ulz--dynamic" data-items="<?php echo (int) $num_boxes; ?>">
                        <?php foreach( $boxes as $key => $box ): ?>
                            <?php if( $key >= 8 ) { break; } ?>
                            <?php $is_large = $this->image_sizes[ (int) $num_boxes ][ $key ] == 'x2'; ?>
                            <div class="ulz--cell">

                                <?php

                                    $location = $box['location'];
                                    $location_listing_type = $box['location_listing_type'];
                                    $location_custom = $box['location_custom'];
                                    $url = $location == 'custom' ? $location_custom : Ucore()->get_explore_page_url([ 'type' => Ucore()->get( 'ulz_slug', $location_listing_type ) ]);

                                    $image_url = '';
                                    if( $box['image']['id'] ) {
                                        $image_size = $is_large ? 'brk_box_main' : 'brk_box';
                                        $image_src = wp_get_attachment_image_src( $box['image']['id'], $image_size );
                                        if( isset( $image_src[0] ) ) {
                                            $image_url = $image_src[0];
                                        }elseif( ! empty( $box['image']['url'] ) ) {
											$image_url = $box['image']['url'];
										}
                                    }

                                ?>

                                <a href="<?php echo esc_url( Ucore()->format_url( $url ) ); ?>"
                                    class="ulz-bx-item ulz--<?php if( $is_large ) { echo 'x2'; }else{ echo 'x1'; } ?>"
									<?php if( $image_url ): ?> style="background-image: url('<?php echo esc_url( $image_url ); ?>');"<?php endif; ?>>
                                    <div class="ulz--content">
                                        <span class="ulz--name ulz-font-heading">
                                            <?php echo esc_html( $box['name'] ); ?>
                                        </span>
                                        <?php if( $box['description'] ): ?>
                                            <span class="ulz--desc">
                                                <?php echo esc_html( $box['description'] ); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </a>

                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </section>

        <?php echo ob_get_clean();

	}

}
