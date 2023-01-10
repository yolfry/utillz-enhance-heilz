<?php

class Utillz_Elementor_Point extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ulz-point';
	}

	public function get_title() {
		return __( 'Focus Point', 'utillz-enhance' );
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
			'icon', [
				'label' => __( 'Icon', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::ICONS,
			]
		);

        $this->end_controls_section();

	}

	protected function render() {

		extract( $this->get_settings_for_display() );

        ob_start(); ?>

        <div class="ulz-focus-point">
			<div class="ulz--inner">
				<?php if( ! empty( $icon['value'] ) ): ?>
					<?php if( is_array( $icon['value'] ) ): ?>
						<img src="<?php echo esc_url( $icon['value']['url'] ); ?>" alt="">
					<?php else: ?>
						<i class="<?php echo esc_attr( $icon['value'] ); ?>"></i>
					<?php endif; ?>
				<?php endif; ?>
			</div>
        </div>

        <?php echo ob_get_clean();

	}

}
