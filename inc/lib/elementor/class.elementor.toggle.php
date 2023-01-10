<?php

class Utillz_Elementor_Toggle extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ulz-toggle';
	}

	public function get_title() {
		return __( 'Toggle Sections', 'utillz-enhance' );
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
			'id_primary', [
				'label' => __( 'ID of primary section', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'primary_text', [
				'label' => __( 'Primary Text', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Primary', 'utillz-enhance' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'id_secondary', [
				'label' => __( 'ID of secondary section', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'secondary_text', [
				'label' => __( 'Secondary Text', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Secondary', 'utillz-enhance' ),
				'label_block' => true,
			]
		);

        $this->end_controls_section();

	}

	protected function render() {

		extract( $this->get_settings_for_display() );

        ob_start(); ?>

        <div class="ulz-section-toggle"
			data-section-primary="<?php echo esc_attr( $id_primary ); ?>"
			data-section-secondary="<?php echo esc_attr( $id_secondary ); ?>">
            <div class="ulz--primary">
				<?php echo esc_html( $primary_text ); ?>
            </div>
            <div class="ulz--toggle">
            	<span></span>
            </div>
            <div class="ulz--secondary">
				<?php echo esc_html( $secondary_text ); ?>
            </div>
        </div>

        <?php echo ob_get_clean();

	}

}
