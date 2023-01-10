<?php

namespace UtillzEnhance\Inc\Utils;

use \UtillzCore\Inc\Src;

class Helper {

    use \UtillzEnhance\Inc\Src\Traits\Singleton;

    public function get_template( $name ) {

        if( ! $template_path = $this->get_template_path( $name ) ) {
            return;
        }

        ob_start();
        include $template_path;
        return ob_get_clean();

    }

    public function the_template( $name ) {

        echo $this->get_template( $name );

    }

    public function get_template_path( $name ) {

        // child theme
        if( is_child_theme() && $child_template_path = $this->child_template_path( $name ) ) {
            return $child_template_path;
        }
        // theme
        elseif( $theme_template_path = $this->theme_template_path( $name ) ) {
            return $theme_template_path;
        }
        // plugin
        elseif( $plugin_template_path = $this->plugin_template_path( $name ) ) {
            return $plugin_template_path;
        }

        return null;

    }

    public function child_template_path( $name ) {

        $template_path = sprintf( '%s/templates/utilities/%s.php', get_stylesheet_directory(), $name );

        if( file_exists( $template_path ) ) {
            return $template_path;
        }

        return null;

    }

    public function theme_template_path( $name ) {

        $template_path = sprintf( '%s/templates/utilities/%s.php', get_template_directory(), $name );

        if( file_exists( $template_path ) ) {
            return $template_path;
        }

        return null;

    }

    public function plugin_template_path( $name ) {

        $template_path = sprintf( '%stemplates/%s.php', UTILLZ_ENH_PATH, $name );

        if( file_exists( $template_path ) ) {
            return $template_path;
        }

        return null;

    }

    public function get_download_plan_statuses() {
		return apply_filters(
			'utilities/status/download-plan', [
                'publish' => _x( 'Active', 'post status', 'utillz-enhance' ),
				'draft' => _x( 'Inactive', 'post status', 'utillz-enhance' ),
				'used' => _x( 'Used', 'post status', 'utillz-enhance' ),
				'cancelled' => _x( 'Cancelled', 'post status', 'utillz-enhance' ),
			]
		);
	}

    public function get_status( $post = null ) {

    	$post = get_post( $post );
    	$status = $post->post_status;

        switch( $post->post_type ) {
            case 'ulz_download_plan': $statuses = $this->get_download_plan_statuses(); break;
        }

    	if ( isset( $statuses[ $status ] ) ) {
    		$status = $statuses[ $status ];
    	}else{
    		$status = esc_html__( 'Not assigned', 'utillz-enhance' );
    	}

    	return apply_filters( 'utilities/status', $status, $post );

    }

    // check if the download has been unlocked for this user
    public function is_unlock_download( $listing_id ) {
        $unlocked_downloads = get_user_meta( get_current_user_id(), 'ulz_downloaded_item' );
        return is_array( $unlocked_downloads ) && in_array( $listing_id, $unlocked_downloads );
    }

    // if downloaded, the item will be uplocked for further downloads,
    // without adding additional plan counts
    public function unlock_download( $listing_id ) {
        if( ! $this->is_unlock_download( $listing_id ) ) {
            add_user_meta( get_current_user_id(), 'ulz_downloaded_item', $listing_id );
        }
    }

    public function get_listing_preview_params( $listing_id ) {

        $listing_type_id = Ucore()->get('ulz_listing_type', $listing_id);

        if( ! $listing_type_id ) {
            return;
        }

        $explore_open = Ucore()->get('ulz_explore_open', $listing_type_id);

        // return params only for explore open of type modal
        if( $explore_open !== 'modal' ) {
            return;
        }

        $listing = new Src\Listing\Listing( $listing_id );

        if( ! $listing->id ) {
            return;
        }

        $gallery = $listing->get_gallery('ulz_gallery_large');

        // dominant color
		$image_id = Ucore()->get_first_array_upload( Ucore()->jsoning( 'ulz_gallery', $listing_id ) );
	    $image_dominant_color = Ucore()->get('dominant_color_hex', $image_id, true);

		// favorite
		$user_favorites = get_user_meta( get_current_user_id(), 'ulz_favorites', true );
		if( ! is_array( $user_favorites ) ) {
			$user_favorites = [];
		}
		$favorite = in_array( $listing_id, $user_favorites );
        $userdata = get_userdata( $listing->post->post_author );

        // video
        $video_src = '';
        $video = Ucore()->get('ulz_video');
        if( $video ) {
            $video = Ucore()->get_first_array_upload( Ucore()->jsoning('ulz_video') );
            $video_src = esc_url( wp_get_attachment_url( $video ) );
        }

        return json_encode([
            'id' => $listing_id,
            'url' => get_permalink( $listing_id ),
            'title' => get_the_title( $listing_id ),
            'image' => isset( $gallery[0] ) ? $gallery[0] : '',
			'dominant_color' => $image_dominant_color,
			'favorite' => $favorite,
			'video_src' => $video_src,
            /*'author' => [
                'name' => sprintf( esc_html__( 'By %s' ), $userdata->display_name ),
                'url' => get_author_posts_url( $listing->post->post_author ),
                'avatar' => get_author_posts_url( $listing->post->post_author ),
            ]*/
        ]);
    }

}
