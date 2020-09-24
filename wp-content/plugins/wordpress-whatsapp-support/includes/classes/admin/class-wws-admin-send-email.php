<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

class WWS_Admin_Send_Email {

    public function __construct() {
        
    }

    private function _mail( $email_to, $email_subject, $email_body, $headers = array() ) { 

        $headers[] = 'Content-Type: text/html; charset=UTF-8';

        if ( isset( $headers['from_name'] ) && isset( $headers['from_email'] ) ) {
            $headers[] = 'From: '. esc_html__( $headers['from_name'] ) .' <'. esc_html__( $headers['from_email'] ) .'>';
        }


       return wp_mail( $email_to, $email_subject, $email_body , $headers );

    }



} // end of class WWS_Admin_Send_Email

$wws_admin_send_email = new WWS_Admin_Send_Email;
