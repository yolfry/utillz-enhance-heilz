<?php

class Utillz_Elementor_Search extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ulz-search';
	}

	public function get_title() {
		return __( 'Search', 'utillz-enhance' );
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

		$search_forms = [];
        $post_types = get_posts([
            'post_type' => 'ulz_search_form',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ]);
        foreach( $post_types as $post_type ) {
            $search_forms[ $post_type->ID ] = $post_type->post_title;
        }

		$this->add_control(
			'search_form',
			[
				'label' => __( 'Select Search Form', 'utillz-enhance' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => $search_forms,
				'label_block' => true,
			]
		);

        $this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if( empty( $settings['search_form'] ) ) {
			return;
		}

		ob_start(); ?>

        <div class="ulz-search ulz-elementor-search">
            <?php echo do_shortcode('[ulz-search-form id="' . (int) $settings['search_form'] . '"]'); ?>
        </div>

        <?php echo ob_get_clean();

	}

}
