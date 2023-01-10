<?php

namespace UtillzEnhance\Inc\Src\Notification\Notifications;

class New_Download extends \UtillzCore\Inc\Src\Notification\Base {

    public $user_can_manage = true;

    /*
     * general
     *
     */
    public function get_id() {
        return 'new-download';
    }

    public function get_name() {
        return esc_html__('Your have a new download', 'utillz-enhance');
    }

    /*
     * email
     *
     */
    public function get_email_subject() {
        return esc_html__( 'Your have a new download', 'utillz-enhance' );
    }

    public function get_email_template() {
        return esc_html__( "Hello {user_display_name},\r\n\r\nYour have a new download.", 'utillz-enhance' );
    }

    /*
     * email admin
     *
     */
    public function get_email_admin_subject() {
        return esc_html__( 'New download', 'utillz-enhance' );
    }

    public function get_email_admin_template() {
        return esc_html__( "Hello,\r\n\r\nYour have a new download", 'utillz-enhance' );
    }

    /*
     * site
     *
     */
    public function get_site_icon() {
        return [
            'set' => 'material-icons',
            'icon' => 'file_download',
        ];
    }

    public function get_site_message() {
        return esc_html__( 'Your have a new download', 'utillz-enhance' );
    }

    public function get_site_url() {
        if( isset( $this->meta['listing_id'] ) ) {
            return get_permalink( $this->meta['listing_id'] );
        }
        return null;
    }

}
