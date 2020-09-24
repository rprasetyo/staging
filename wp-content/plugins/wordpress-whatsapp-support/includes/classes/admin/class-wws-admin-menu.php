<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

/**
 * Add plugin menus
 * @author WeCreativez
 * @since 1.2
 */
class WWS_Admin_Menu {

    public function __construct() {

        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );

    }


    /**
     * Add plugin setting menu on WordPress admin menu
     * @since 1.2
     */
    public function add_admin_menu() {

        if ( ! get_option( 'sk_wws_license_key' ) ) {
        
            add_menu_page( 
                esc_html__('WhatsApp Support', 'wc-wws'), 
                esc_html__('WhatsApp Support', 'wc-wws'), 
                'manage_options', 
                'wc-whatsapp-support', 
                array( $this, 'admin_plugin_activation_page' ), 
                'dashicons-format-chat', 
                NULL 
            );

            add_submenu_page( 
                'wc-whatsapp-support', 
                esc_html__( 'Plugin Support', 'wc-wws' ), 
                esc_html__( 'Plugin Support', 'wc-wws' ), 
                'manage_options', 
                'wc-whatsapp-support-plugin-support', 
                array( $this, 'admin_plugin_support_page' )
            );

        } else {

            add_menu_page( 
                esc_html__('WhatsApp Support', 'wc-wws'), 
                esc_html__('WhatsApp Support', 'wc-wws'), 
                'manage_options', 
                'wc-whatsapp-support', 
                array( $this, 'admin_setting_page' ), 
                'dashicons-format-chat', 
                NULL 
            );
            
            add_submenu_page( 
                'wc-whatsapp-support', 
                esc_html__( 'Analytics', 'wc-wws' ), 
                esc_html__( 'Analytics', 'wc-wws' ), 
                'manage_options', 
                'wc-whatsapp-support-analytics', 
                array( $this, 'admin_analytics_page' )
            );

            add_submenu_page( 
                'wc-whatsapp-support', 
                esc_html__( 'FB & GA Analytics', 'wc-wws' ), 
                esc_html__( 'FB & GA Analytics', 'wc-wws' ), 
                'manage_options', 
                'wc-whatsapp-support-fb-ga-analytics', 
                array( $this, 'admin_fb_ga_analytics_page' )
            );

            add_submenu_page( 
                'wc-whatsapp-support', 
                esc_html__( 'GDPR Setting', 'wc-wws' ), 
                esc_html__( 'GDPR Setting', 'wc-wws' ), 
                'manage_options', 
                'wc-whatsapp-support-gdpr-setting', 
                array( $this, 'admin_gdpr_setting_page' )
            );

            add_submenu_page( 
                'wc-whatsapp-support', 
                esc_html__( 'Plugin Support', 'wc-wws' ), 
                esc_html__( 'Plugin Support', 'wc-wws' ), 
                'manage_options', 
                'wc-whatsapp-support-plugin-support', 
                array( $this, 'admin_plugin_support_page' )
            );

        }

    }


    // Admin general setting page.
    public function admin_setting_page() {

        require_once WWS_ABSPATH . 'views/admin/admin-setting-page.php';  

    }

    // Admin analytics page
    public function admin_analytics_page() {

        $analytics                  = WWS_Analytics::get_complete_analytics();
        $total_clicks               = WWS_Analytics::get_total_clicks();
        $total_clicks_by_mobile     = WWS_Analytics::get_total_clicks_by_mobile();
        $total_clicks_by_desktop    = WWS_Analytics::get_total_clicks_by_desktop();

        require_once WWS_ABSPATH . 'views/admin/admin-analytics-page.php';

    }


    public function admin_fb_ga_analytics_page() {

        // Get WeCreativez admin feild settings
        $field = new Wecreativez_Core_Field;

        // Get FB and GA Analytics settings
        $wws_fb_ga_analytics_settings = get_option( 'wws_fb_ga_analytics_settings', array() );

        require_once WWS_ABSPATH . 'views/admin/admin-fb-ga-analytics-page.php';

    }

    // Admin GDPR setting page
    public function admin_gdpr_setting_page() {

        // Get WeCreativez admin feild settings
        $field = new Wecreativez_Core_Field;

        // Get GDPR settings
        $wws_gdpr_settings = get_option( 'wws_gdpr_settings', array() );

        require_once WWS_ABSPATH . 'views/admin/admin-gdpr-setting-page.php';

    }

    // Admin plugin support page
    public function admin_plugin_support_page() {

        require_once WWS_ABSPATH . 'views/admin/admin-plugin-support.php';

    }


    public function admin_plugin_activation_page() {

        require_once WWS_ABSPATH . 'views/admin/admin-plugin-activation-page.php';

    }



} // End of WWS_Admin_Menu class


// Init the class
$wws_admin_menu = new WWS_Admin_Menu;