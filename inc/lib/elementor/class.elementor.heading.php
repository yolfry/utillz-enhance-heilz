<?php

class Utillz_Elementor_Heading extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ulz-heading';
	}

	public function get_title() {
		return __( 'Heading', 'utillz-enhance' );
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
			'title',
			[
				'label' => __( 'Title', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Title', 'utillz-enhance' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'title_tag', [
				'label' => __( 'Title Tag', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
					'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'DEV',
                    'span' => 'SPAN',
                    'p' => 'P',
                ],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'title_size',
			[
				'label' => __( 'Title Size', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
                    'small' => __( 'Small', 'utillz-enhance' ),
                    'medium' => __( 'Medium', 'utillz-enhance' ),
                    'large' => __( 'Large', 'utillz-enhance' ),
                    'xl' => __( 'XL', 'utillz-enhance' ),
                    'xxl' => __( 'XXL', 'utillz-enhance' ),
                    'xxxl' => __( 'XXXL', 'utillz-enhance' ),
                    'xxxxl' => __( 'XXXXL', 'utillz-enhance' ),
                ],
				'default' => 'large',
			]
		);

		$this->add_control(
			'sub_title',
			[
				'label' => __( 'Sub-Title', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'sub_title_url',
			[
				'label' => __( 'Sub-Title URL (optional)', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'sub_title_icon', [
				'label' => __( 'Sub-Title Icon (optional)', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'skin' => 'inline',
				'exclude_inline_options' => [
                    'svg'
                ],
			]
		);

		$this->add_control(
			'sub_title_tag', [
				'label' => __( 'Sub-Title Tag', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'DEV',
                    'span' => 'SPAN',
                    'p' => 'P',
                ],
				'default' => 'p',
			]
		);

		$this->add_control(
			'sub_title_size',
			[
				'label' => __( 'Sub-Title Size', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
                    'normal' => __( 'Normal', 'utillz-enhance' ),
                    'small' => __( 'Small', 'utillz-enhance' ),
                    'medium' => __( 'Medium', 'utillz-enhance' ),
                    'large' => __( 'Large', 'utillz-enhance' ),
                    'xl' => __( 'XL', 'utillz-enhance' ),
                    'xxl' => __( 'XXL', 'utillz-enhance' ),
                    'xxxl' => __( 'XXXL', 'utillz-enhance' ),
                ],
				'default' => 'normal',
			]
		);

        $this->end_controls_section();

		/*
         * >>>>> section styles
         *
         */
        $this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'utillz-enhance' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        /*
         * bg image
         *
         */
        $this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'inherit',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		extract( $this->get_settings_for_display() );

        ob_start(); ?>

		<div class="ulz-elementor-section ulz-elementor-row">
			<div class="ulz--heading" style="<?php if( $text_color ) { echo sprintf( 'color: %s;', $text_color ); } ?>">
                <<?php echo esc_attr( $title_tag ); ?> class="ulz--title ulz--size-<?php echo esc_attr( $title_size ); ?>">
                    <?php echo wp_kses( html_entity_decode( $title ), Ucore()->allowed_html() ); ?>
                </<?php echo esc_attr( $title_tag ); ?>>
                <?php if( $sub_title ): ?>
                    <<?php echo esc_attr( $sub_title_tag ); ?> class="ulz--sub-title ulz--size-<?php echo esc_attr( $sub_title_size ); ?>">
						<?php if( $sub_title_url ): ?><a href="<?php echo esc_url( Ucore()->format_url( $sub_title_url ) ); ?>"><?php endif; ?>
							<?php echo wp_kses( html_entity_decode( $sub_title ), Ucore()->allowed_html() ); ?>
							<?php if( ! empty( $sub_title_icon['value'] ) ): ?>
								<i class="ulz-ml-1 <?php echo esc_html( $sub_title_icon['value'] ); ?>"></i>
							<?php endif; ?>
						<?php if( $sub_title_url ): ?></a><?php endif; ?>
					</<?php echo esc_attr( $sub_title_tag ); ?>>
                <?php endif; ?>
		    </div>
	    </div>

        <?php echo ob_get_clean();

	}

}
