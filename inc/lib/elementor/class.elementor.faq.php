<?php

class Utillz_Elementor_Faq extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ulz-faq';
	}

	public function get_title() {
		return __( 'FAQ', 'utillz-enhance' );
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
				'default' => __( 'Some name', 'utillz-enhance' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => __( 'Content', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ultricies diam neque, eget sagittis sem blandit sit amet. Praesent varius nulla a magna ultricies, et condimentum orci porta.', 'utillz-enhance' ),
			]
		);

		$this->add_control(
			'items',
			[
				'label' => __( 'Items', 'utillz-enhance' ),
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
			<div class="ulz-faq">
				<?php foreach( $items as $item ): ?>
					<div class="ulz--item">
						<div class="ulz--name">
							<?php echo esc_html( $item['text'] ); ?>
						</div>
						<div class="ulz--content">
							<?php echo wp_kses_post( html_entity_decode( Ucore()->format_url( $item['description'] ) ) ); ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
	    </div>

        <?php echo ob_get_clean();

	}

}
