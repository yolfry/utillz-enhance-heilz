<?php

namespace UtillzEnhance\Inc\Src;

use \UtillzEnhance\Inc\Src\Traits\Singleton;

class Install {

    use Singleton;

    function __construct() {

        register_activation_hook( UTILLZ_ENH_PLUGIN, [ $this, 'activation' ] );
        register_deactivation_hook( UTILLZ_ENH_PLUGIN, [ $this, 'deactivation' ] );

    }

    public function activation( $network_wide ) {

        /*
         * multisite
         *
         */
        if( is_multisite() && $network_wide ) {

            $sites = get_sites([
                'fields' => 'ids'
            ]);

            foreach( $sites as $blog_id ) {
                switch_to_blog( $blog_id );
                $this->install();
                restore_current_blog();
            }

        }
        /*
         * single site
         *
         */
        else{

            $this->install();

        }
    }

    public function deactivation( $network_wide ) {

        /*
         * multisite
         *
         */
        if( is_multisite() && $network_wide ) {

            $sites = get_sites([
                'fields' => 'ids'
            ]);

            foreach( $sites as $blog_id ) {
                switch_to_blog( $blog_id );
                $this->uninstall();
                restore_current_blog();
            }

        }
        /*
         * single site
         *
         */
        else{

            $this->uninstall();

        }
    }

    public function install() {

        $this->schedule_events();

    }

    public function uninstall() {

        $this->unschedule_events();

    }

    public function schedule_events() {

        if ( ! wp_next_scheduled('utilities_clear_temp_downloads') ) {
			wp_schedule_event(time(), 'hourly', 'utilities_clear_temp_downloads');
		}

	}

	public function unschedule_events() {
		wp_clear_scheduled_hook('utilities_clear_temp_downloads');
	}

}
