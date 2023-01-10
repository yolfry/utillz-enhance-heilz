<?php

class Utillz_Elementor_Button_Stack extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ulz-button-stack';
	}

	public function get_title() {
		return __( 'Button Stack', 'utillz-enhance' );
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
			'align', [
				'label' => __( 'Align', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'flex-start' => __( 'Left', 'utillz-enhance' ),
					'center' => __( 'Center', 'utillz-enhance' ),
					'flex-end' => __( 'Right', 'utillz-enhance' ),
                ],
				'default' => 'flex-start',
				'label_block' => true,
			]
		);

		/*
         * repeater
         *
         */
        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'text',
			[
				'label' => __( 'Text', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Button', 'utillz-enhance' ),
			]
		);

		$repeater->add_control(
			'url',
			[
				'label' => __( 'URL', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '#',
			]
		);

		$repeater->add_control(
			'icon', [
				'label' => __( 'Icon', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'skin' => 'inline',
				'exclude_inline_options' => [
                    'svg'
                ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'style', [
				'label' => __( 'Style', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'primary' => __( 'Primary', 'utillz-enhance' ),
					'secondary' => __( 'Secondary', 'utillz-enhance' ),
                ],
				'default' => 'primary',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'white', [
				'label' => __( 'White Color', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'utillz-enhance' ),
				'label_off' => __( 'No', 'utillz-enhance' ),
				'return_value' => 'yes',
				'default' => false,
				'condition' => [
                    'style' => 'border'
                ],
			]
		);

		$repeater->add_control(
			'new_tab', [
				'label' => __( 'Open in a new tab', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'utillz-enhance' ),
				'label_off' => __( 'No', 'utillz-enhance' ),
				'return_value' => 'yes',
				'default' => false,
			]
		);

		$repeater->add_control(
			'large', [
				'label' => __( 'Large', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'utillz-enhance' ),
				'label_off' => __( 'No', 'utillz-enhance' ),
				'return_value' => 'yes',
				'default' => false,
			]
		);

		$this->add_control(
			'buttons',
			[
				'label' => __( 'Buttons', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'title_field' => '{{{ text }}}',
			]
		);

        $this->end_controls_section();

	}

	protected function render() {

		extract( $this->get_settings_for_display() );

        ob_start(); ?>

		<div class="ulz-elementor-section ulz-elementor-row">
			<div class="ulz-button-stack" style="justify-content: <?php echo esc_attr( $align ); ?>;">
				<?php foreach( $buttons as $button ): ?>
					<?php
						$classes = [];

						if( $button['large'] ) {
							$classes[] = 'ulz--large';
						}

						switch( $button['style'] ) {
							case 'secondary':
								$classes[] = 'ulz--secondary';
								break;
						}
					?>
					<div class="ulz--button">
						<a href="<?php echo esc_url( Ucore()->format_url( $button['url'] ) ); ?>" class="ulz-button <?php echo implode( ' ', $classes ); ?>"<?php if( $button['new_tab'] ) { echo ' target="_blank"'; } ?>>
							<span><?php echo esc_html( $button['text'] ); ?></span>
							<?php if( ! empty( $button['icon']['value'] ) ): ?>
								<i class="ulz-ml-1 <?php echo esc_attr( $button['icon']['value'] ); ?>"></i>
							<?php endif; ?>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
	    </div>

        <?php echo ob_get_clean();

	}

}
