<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

// Get Developer settings
$wws_developer_settings = get_option( 'wws_developer_settings', array() );

// This file run when plugin delete or uninstall.
if ( $wws_developer_settings['delete_setting'] == '1' ) {

    global $wpdb;

    delete_option( 'sk_wws_setting' );
    delete_option( 'sk_wws_multi_account' );
    delete_option( 'sk_wws_license_key' );
    delete_option( 'wws_product_query' );
    delete_option( 'wws_fb_ga_analytics_settings' );
    delete_option( 'wws_gdpr_settings' );
    delete_option( 'wws_developer_settings' );
    delete_option( 'wws_admin_review' );

    // Delete tables.
    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}wws_analytics" );

}

