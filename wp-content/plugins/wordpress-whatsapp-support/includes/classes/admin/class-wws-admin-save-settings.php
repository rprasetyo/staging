<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

class WWS_Admin_Save_Settings {


    public function __construct() {

        add_action( 'admin_init', array( $this, 'save_appearance_settings' ) );
        add_action( 'admin_init', array( $this, 'save_basic_settings' ) );
        add_action( 'admin_init', array( $this, 'save_manage_support_persons_settings' ) );
        add_action( 'admin_init', array( $this, 'save_gdpr_settings' ) );
        add_action( 'admin_init', array( $this, 'save_product_query_settings' ) );
        add_action( 'admin_init', array( $this, 'save_fb_ga_analytics_settings' ) );
        add_action( 'admin_init', array( $this, 'save_developer_settings' ) );

        add_action( 'admin_init', array( $this, 'save_edit_multi_account_settings' ) );
        add_action( 'admin_init', array( $this, 'save_add_multi_account_settings' ) );
        add_action( 'admin_init', array( $this, 'save_delete_multi_account_settings' ) );

        add_action( 'admin_init', array( $this, 'generate_debug_report' ) );

        add_action( 'admin_init', array( $this, 'admin_plugin_review' ) );

    }


    public function save_appearance_settings() {

        if ( ! isset( $_POST['wws_appearance_settings_submit'] ) ) {
            return;
        }

        // get settings from backend
        $saved_settings = get_option( 'sk_wws_setting', array() );

        // post data from form
        $post_data = stripslashes_deep( $_POST['sk_wws_setting'] );

        $saved_settings['ui_layout']            = sanitize_text_field( $post_data['ui_layout'] );
        $saved_settings['ui_layout_bg_color']   = sanitize_text_field( $post_data['ui_layout_bg_color'] );
        $saved_settings['ui_layout_text_color'] = sanitize_text_field( $post_data['ui_layout_text_color'] );
        $saved_settings['ui_layout_gradient']   = ( isset( $post_data['ui_layout_gradient'] ) ? '1' : '0' );

        $saved_settings['text_trigger_btn']             = sanitize_text_field( $post_data['text_trigger_btn'] );
        $saved_settings['ul_trigger_btn_only_icon']     = ( isset( $post_data['ul_trigger_btn_only_icon'] ) ? '1' : '0' );
        $saved_settings['text_about_support']           = sanitize_textarea_field( $post_data['text_about_support'] );
        $saved_settings['text_welcome_msg']             = sanitize_text_field( $post_data['text_welcome_msg'] );
        $saved_settings['text_input_placeholder']       = sanitize_text_field( $post_data['text_input_placeholder'] );
        $saved_settings['text_number_placeholder']      = sanitize_text_field( $post_data['text_number_placeholder'] );
        $saved_settings['text_predefined_text']         = sanitize_textarea_field( $post_data['text_predefined_text'] );

        update_option( 'sk_wws_setting', $saved_settings );

    }


    public function save_basic_settings() {

        if ( ! isset( $_POST['wws_basic_settings_submit'] ) ) {
            return;
        }

        // get settings from backend
        $saved_settings = get_option( 'sk_wws_setting', array() );

        // post data from form
        $post_data = stripslashes_deep( $_POST['sk_wws_setting'] );

        $saved_settings['wws_x_axis_offset']        = sanitize_text_field( $post_data['wws_x_axis_offset'] );
        $saved_settings['wws_y_axis_offset']        = sanitize_text_field( $post_data['wws_y_axis_offset'] );
        $saved_settings['wws_display_on_desktop']   = sanitize_text_field( $post_data['wws_display_on_desktop'] );
        $saved_settings['wws_desktop_location']     = sanitize_text_field( $post_data['wws_desktop_location'] );
        $saved_settings['wws_display_on_mobile']    = sanitize_text_field( $post_data['wws_display_on_mobile'] );
        $saved_settings['wws_mobile_location']      = sanitize_text_field( $post_data['wws_mobile_location'] );
        $saved_settings['wws_auto_popup']           = sanitize_text_field( $post_data['wws_auto_popup'] );
        $saved_settings['wws_auto_popup_time']      = sanitize_text_field( $post_data['wws_auto_popup_time'] );
        $saved_settings['wws_rtl']                  = ( isset( $post_data['wws_rtl'] ) ? '1' : '0' );
        $saved_settings['wws_scroll_length']        = sanitize_text_field( $post_data['wws_scroll_length'] );
        $saved_settings['wws_filter_by_page']       = array(
            'by_everywhere'     => ( isset( $post_data['wws_filter_by_page']['by_everywhere'] ) ? '1' : '0' ),
            'by_front_page'     => ( isset( $post_data['wws_filter_by_page']['by_front_page'] ) ? '1' : '0' ),
            'by_slugs'          => ( isset( $post_data['wws_filter_by_page']['by_slugs'] ) ? $post_data['wws_filter_by_page']['by_slugs'] : array()),
            'by_slugs_exclude'  => ( isset( $post_data['wws_filter_by_page']['by_slugs_exclude'] ) ? $post_data['wws_filter_by_page']['by_slugs_exclude'] : array() ),
        );
        $saved_settings['wws_schedule']             = array(
            'mon' => array(
                'is_enable' => ( isset( $post_data['wws_schedule']['mon']['is_enable'] ) ? '1' : '0' ),
                'start'     => sanitize_text_field( $post_data['wws_schedule']['mon']['start'] ),
                'end'       => sanitize_text_field( $post_data['wws_schedule']['mon']['end'] ),
            ),
            'tue' => array(
                'is_enable' => ( isset( $post_data['wws_schedule']['tue']['is_enable'] ) ? '1' : '0' ),
                'start'     => sanitize_text_field( $post_data['wws_schedule']['tue']['start'] ),
                'end'       => sanitize_text_field( $post_data['wws_schedule']['tue']['end'] ),
            ),
            'wed' => array(
                'is_enable' => ( isset( $post_data['wws_schedule']['wed']['is_enable'] ) ? '1' : '0' ),
                'start'     => sanitize_text_field( $post_data['wws_schedule']['wed']['start'] ),
                'end'       => sanitize_text_field( $post_data['wws_schedule']['wed']['end'] ),
            ),
            'thu' => array(
                'is_enable' => ( isset( $post_data['wws_schedule']['thu']['is_enable'] ) ? '1' : '0' ),
                'start'     => sanitize_text_field( $post_data['wws_schedule']['thu']['start'] ),
                'end'       => sanitize_text_field( $post_data['wws_schedule']['thu']['end'] ),
            ),
            'fri' => array(
                'is_enable' => ( isset( $post_data['wws_schedule']['fri']['is_enable'] ) ? '1' : '0' ),
                'start'     => sanitize_text_field( $post_data['wws_schedule']['fri']['start'] ),
                'end'       => sanitize_text_field( $post_data['wws_schedule']['fri']['end'] ),
            ),
            'sat' => array(
                'is_enable' => ( isset( $post_data['wws_schedule']['sat']['is_enable'] ) ? '1' : '0' ),
                'start'     => sanitize_text_field( $post_data['wws_schedule']['sat']['start'] ),
                'end'       => sanitize_text_field( $post_data['wws_schedule']['sat']['end'] ),
            ),
            'sun' => array(
                'is_enable' => ( isset( $post_data['wws_schedule']['sun']['is_enable'] ) ? '1' : '0' ),
                'start'     => sanitize_text_field( $post_data['wws_schedule']['sun']['start'] ),
                'end'       => sanitize_text_field( $post_data['wws_schedule']['sun']['end'] ),
            ),
        );
            
        update_option( 'sk_wws_setting', $saved_settings );

    }


    public function save_manage_support_persons_settings() {

        if ( ! isset( $_POST['wws_manage_support_person_settings_submit'] ) ) {
            return;
        }

        // get settings from backend
        $saved_settings = get_option( 'sk_wws_setting', array() );

        // post data from form
        $post_data = stripslashes_deep( $_POST['sk_wws_setting'] );

        $saved_settings['wws_group_id']             = ( isset( $post_data['wws_group_id'] ) ? sanitize_text_field( $post_data['wws_group_id'] ) : $saved_settings['wws_group_id'] );
        $saved_settings['wws_contact_number']       = ( isset( $post_data['wws_contact_number'] ) ? sanitize_text_field( $post_data['wws_contact_number'] ) : $saved_settings['wws_contact_number'] );
        $saved_settings['ui_support_person_img']    = ( isset( $post_data['ui_support_person_img'] ) ? esc_url_raw( $post_data['ui_support_person_img'] ) : $saved_settings['ui_support_person_img'] );

        update_option( 'sk_wws_setting', $saved_settings );

    }


    public function save_gdpr_settings() {

        if ( ! isset( $_POST['wws_gdpr_settings_submit'] ) ) {
            return;
        }

        $post_data = stripslashes_deep( $_POST['wws_gdpr_settings'] );

        $wws_gdpr_settings['gdpr_status']       = ( isset( $post_data['gdpr_status'] ) ? 1 : 0 );
        $wws_gdpr_settings['gdpr_msg']          = sanitize_textarea_field( $post_data['gdpr_msg'] );
        $wws_gdpr_settings['gdpr_privacy_page'] = sanitize_text_field( $post_data['gdpr_privacy_page'] );

        update_option( 'wws_gdpr_settings', $wws_gdpr_settings );

    }


    public function save_product_query_settings() {

        if ( ! isset( $_POST['wws_product_query_settings_submit'] ) ) {
            return;
        }

        $post_data = stripslashes_deep( $_POST['wws_product_query_settings'] );

        $wws_product_query_settings['status']                   = ( isset( $post_data['status'] ) ? 1 : 0 );
        $wws_product_query_settings['btn_location']             = sanitize_text_field( $post_data['btn_location'] );
        $wws_product_query_settings['btn_bg_color']             = sanitize_text_field( $post_data['btn_bg_color'] );
        $wws_product_query_settings['btn_text_color']           = sanitize_text_field( $post_data['btn_text_color'] );
        $wws_product_query_settings['btn_label']                = sanitize_text_field( $post_data['btn_label'] );
        $wws_product_query_settings['support_number']           = sanitize_text_field( $post_data['support_number'] );
        $wws_product_query_settings['support_person_name']      = sanitize_text_field( $post_data['support_person_name'] );
        $wws_product_query_settings['support_person_title']     = sanitize_text_field( $post_data['support_person_title'] );
        $wws_product_query_settings['support_person_img']       = esc_url_raw( $post_data['support_person_img'] );
        $wws_product_query_settings['support_pre_message']      = sanitize_textarea_field( $post_data['support_pre_message'] );
        $wws_product_query_settings['exclude_by_products']      = ( isset( $post_data['exclude_by_products'] ) ? $post_data['exclude_by_products'] : array() );
        $wws_product_query_settings['exclude_by_categories']    = ( isset( $post_data['exclude_by_categories'] ) ? $post_data['exclude_by_categories'] : array() );

        update_option( 'wws_product_query', $wws_product_query_settings );

    }


    public function save_fb_ga_analytics_settings() {

        if ( ! isset( $_POST['wws_fb_ga_analytics_settings_submit'] ) ) {
            return;
        }

        $post_data = stripslashes_deep( $_POST['wws_fb_ga_analytics_settings'] );

        $setting['fb_click_tracking_status']            = ( isset( $post_data['fb_click_tracking_status'] ) ? '1' : '0' );
        $setting['fb_click_tracking_event_name']        = sanitize_text_field( $post_data['fb_click_tracking_event_name'] );
        $setting['fb_click_tracking_event_label']       = sanitize_text_field( $post_data['fb_click_tracking_event_label'] );
        $setting['ga_click_tracking_status']            = ( isset( $post_data['ga_click_tracking_status'] ) ? '1' : '0' );
        $setting['ga_click_tracking_event_name']        = sanitize_text_field( $post_data['ga_click_tracking_event_name'] );
        $setting['ga_click_tracking_event_category']    = sanitize_text_field( $post_data['ga_click_tracking_event_category'] );
        $setting['ga_click_tracking_event_label']       = sanitize_text_field( $post_data['ga_click_tracking_event_label'] );

        update_option( 'wws_fb_ga_analytics_settings', $setting );

    }


    public function save_developer_settings() {

        if ( ! isset( $_POST['wws_developer_settings_submit'] ) ) {
            return;
        }

        // $post_data = stripslashes_deep( $_POST['wws_developer_settings'] );

        $setting['is_developer']        = ( isset( $_POST['wws_developer_settings']['is_developer'] ) ? '1' : '0' );
        $setting['delete_setting']      = ( isset( $_POST['wws_developer_settings']['delete_setting'] ) ? '1' : '0' );

        update_option( 'wws_developer_settings', $setting );


    }


    public function save_edit_multi_account_settings() {

        if ( ! isset( $_POST['wws_edit_multi_account_submit'] ) ) {
            return;
        }

        $setting    = get_option('sk_wws_multi_account');
        $key        = $_POST['wws_multi_account']['key'];

        $post_data  = stripslashes_deep( $_POST['wws_multi_account'] );

        $setting[$key] = array(
            'contact'       => sanitize_text_field( $post_data['contact'] ),
            'name'          => sanitize_text_field( $post_data['name'] ),
            'title'         => sanitize_text_field( $post_data['title'] ),
            'image'         => esc_url_raw( $post_data['image'] ),
            'pre_message'   => sanitize_textarea_field( $post_data['pre_message'] ),
            'start_hours'   => sanitize_text_field( $post_data['start_hours'] ),
            'start_minutes' => sanitize_text_field( $post_data['start_minutes'] ),
            'end_hours'     => sanitize_text_field( $post_data['end_hours'] ),
            'end_minutes'   => sanitize_text_field( $post_data['end_minutes'] ),
            'days' => array(
                (isset($post_data['mon'])) ? 'mon' : '0',
                (isset($post_data['tue'])) ? 'tue' : '0',
                (isset($post_data['wed'])) ? 'wed' : '0',
                (isset($post_data['thu'])) ? 'thu' : '0',
                (isset($post_data['fri'])) ? 'fri' : '0',
                (isset($post_data['sat'])) ? 'sat' : '0',
                (isset($post_data['sun'])) ? 'sun' : '0',
            ),
        );

        update_option( 'sk_wws_multi_account', $setting );

    }


    public function save_add_multi_account_settings() {

        if ( ! isset( $_POST['wws_add_multi_account_submit'] ) ) {
            return;
        }

        $setting    = get_option('sk_wws_multi_account');

        $post_data  = stripslashes_deep( $_POST['wws_multi_account'] );

        $setting[] = array(
            'contact'       => sanitize_text_field( $post_data['contact'] ),
            'name'          => sanitize_text_field( $post_data['name'] ),
            'title'         => sanitize_text_field( $post_data['title'] ),
            'image'         => esc_url_raw( $post_data['image'] ),
            'pre_message'   => sanitize_textarea_field( $post_data['pre_message'] ),
            'start_hours'   => sanitize_text_field( $post_data['start_hours'] ),
            'start_minutes' => sanitize_text_field( $post_data['start_minutes'] ),
            'end_hours'     => sanitize_text_field( $post_data['end_hours'] ),
            'end_minutes'   => sanitize_text_field( $post_data['end_minutes'] ),
            'days' => array(
                (isset($post_data['mon'])) ? 'mon' : '0',
                (isset($post_data['tue'])) ? 'tue' : '0',
                (isset($post_data['wed'])) ? 'wed' : '0',
                (isset($post_data['thu'])) ? 'thu' : '0',
                (isset($post_data['fri'])) ? 'fri' : '0',
                (isset($post_data['sat'])) ? 'sat' : '0',
                (isset($post_data['sun'])) ? 'sun' : '0',
            ),
        );

        update_option( 'sk_wws_multi_account', $setting );

    }


    public function save_delete_multi_account_settings() {

        if ( ! isset( $_GET['wws_multi_account_delete'] ) )  {
            return;
        }

        if ( ! is_admin() ) {
            return;
        }

        $setting = get_option('sk_wws_multi_account');

        unset( $setting[$_GET['wws_multi_account_delete']]);

        update_option('sk_wws_multi_account', $setting);

        wp_redirect( admin_url( 'admin.php?page=wc-whatsapp-support&tab=manage_support_persons' ) );

        exit;

    }


    public function generate_debug_report() {

        if ( ! isset( $_GET['wws_generate_debug_report'] ) ) {
            return;
        }

        if ( ! is_admin() ) {
            return;
        }

        $upload_dir = wp_upload_dir();

        if ( ! file_exists( $upload_dir['basedir'] . '/wws-debug-report' ) ) {
            mkdir( $upload_dir['basedir'] . '/wws-debug-report', 0777, true );
        }

        ob_start();
        
        $report = new Wecreativez_Report;
        
        require_once WWS_ABSPATH . 'views/admin/email/email-debug-report.php';
        
        $report = ob_get_clean();


        file_put_contents( $upload_dir['basedir'] . '/wws-debug-report/report.html', $report );

        wp_redirect( admin_url( 'admin.php?page=wc-whatsapp-support-plugin-support&debug_report_generated=1' ) );

    }


    public function admin_plugin_review() {

      if ( ! isset( $_GET['wws_admin_review'] ) ) {
        return;
      }

      update_option( 'wws_admin_review', '1' );

      wp_redirect( admin_url( 'admin.php?page=wc-whatsapp-support' ) );


    }


} // end of class WWS_Admin_Save_Settings

$wws_admin_save_settings = new WWS_Admin_Save_Settings;