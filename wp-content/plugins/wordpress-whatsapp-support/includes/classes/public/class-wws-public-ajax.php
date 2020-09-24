<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

class WWS_Public_Ajax {

    public function __construct() {

        add_action( 'wp_ajax_wws_view_multi_person_form', array( $this, 'view_multi_person_form' ) );
        add_action( 'wp_ajax_nopriv_wws_view_multi_person_form', array( $this, 'view_multi_person_form' ) );

    }

    public function view_multi_person_form() {

        $support_person_id = sanitize_text_field( $_POST['support_person_id'] );
        $post_id           = sanitize_text_field( $_POST['post_id'] );

        $setting        = get_option( 'sk_wws_setting', array() );
        $multi_account  = get_option( 'sk_wws_multi_account', array() );
        
        $pre_message    = str_replace(
            array(
                '{title}',
                '{url}',
                '{br}',
            ),
            array(
                get_the_title( $post_id ),
                get_permalink( $post_id ),
                '%0A',
            ),
            $multi_account[$support_person_id]['pre_message']
        );

        require_once WWS_ABSPATH . 'views/wws-template-6-form.php';

        wp_die();

    }



} // emd of the class WWS_Public_Ajax

$wws_public_ajax = new WWS_Public_Ajax;