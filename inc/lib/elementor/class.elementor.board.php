<?php

class Utillz_Elementor_Board extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ulz-board';
	}

	public function get_title() {
		return __( 'Board', 'utillz-enhance' );
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
			'summary',
			[
				'label' => __( 'Summary', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
			]
		);

		$this->add_control(
			'background_color', [
				'label' => __( 'Background Color', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ulz-board' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_text', [
				'label' => __( 'Button Text', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'button_url', [
				'label' => __( 'Button URL', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

        $this->end_controls_section();

	}

	protected function render() {

		extract( $this->get_settings_for_display() );

        ob_start(); ?>

        <div class="ulz-board">
            <div class="ulz--content">
	            <?php if( $summary ): ?>
	                <?php echo wp_kses_post( html_entity_decode( Ucore()->format_url( $summary ) ) ); ?>
	            <?php endif; ?>
            </div>
			<?php if( $button_text && $button_url ): ?>
				<div class="ulz--action">
					<a href="<?php echo esc_url( $button_url ); ?>" class="ulz-button ulz--large ulz--white">
						<?php echo esc_html( $button_text ); ?>
					</a>
				</div>
			<?php endif; ?>
        </div>

        <?php echo ob_get_clean();

	}

}
