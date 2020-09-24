<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

/**
* Plugin activation 
* @author WeCreativez
* @since 1.2
*/
class WWS_Activation {


    /**
    * Add options setting in wp_options API
    * @since 1.2
    */
    public static function activate() {

        global $wpdb;

        $wws_analytics_table = $wpdb->prefix.'wws_analytics';

        if($wpdb->get_var("SHOW TABLES LIKE '$wws_analytics_table'") != $wws_analytics_table) {
        
            //table not in database. Create new table
            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $wws_analytics_table ( 
                id BIGINT NOT NULL AUTO_INCREMENT , 
                visitor_ip VARCHAR(32) NOT NULL ,
                message LONGTEXT NOT NULL ,
                device_type VARCHAR(32) NOT NULL ,
                os VARCHAR(32) NOT NULL,
                browser VARCHAR(32) NOT NULL ,
                date VARCHAR(32) NOT NULL , 
                PRIMARY KEY (id)) $charset_collate;";
            
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            
            dbDelta( $sql );

        }

        if ( $wpdb->get_var( "SHOW COLUMNS FROM $wws_analytics_table LIKE 'referral'" ) != 'referral' ) {
            $wpdb->query( "ALTER TABLE $wws_analytics_table ADD referral LONGTEXT NOT NULL AFTER message" );
        }

        // Add Number column in the analytics table.
        // @since 1.7
        if ( $wpdb->get_var( "SHOW COLUMNS FROM $wws_analytics_table LIKE 'number'" ) != 'number' ) {
            $wpdb->query( "ALTER TABLE $wws_analytics_table ADD number LONGTEXT NOT NULL AFTER visitor_ip" );
        }


        self::register( 'sk_wws_setting', array(
            'ui_layout'                 => '1',
            'ui_layout_bg_color'        => '#22C15E',
            'ui_layout_text_color'      => '#ffffff',
            'ui_layout_gradient'        => '1',
            'ui_support_person_img'     => NULL,
            'ul_trigger_btn_only_icon'  => '0',
            'text_about_support'        => 'Our customer support team is here to answer your questions. Ask us anything!',
            'text_welcome_msg'          => '👋 Hi, how can I help?',
            'text_input_placeholder'    => 'Reply to WeCreativez...',
            'text_number_placeholder'   => 'Enter your WhatsApp Number',
            'text_predefined_text'      => '{br}'.PHP_EOL .'Page Title: {title}{br}'.PHP_EOL .'Page URL: {url}',
            'text_trigger_btn'          => 'Hi, how can I help?',
            'wws_contact_number'        => '911234567890',
            'wws_group_id'              => 'XYZ12345678',
            'wws_scroll_length'         => '',
            'wws_rtl'                   => '0',
            'wws_x_axis_offset'         => '12',
            'wws_y_axis_offset'         => '12',
            'wws_display_on_desktop'    => '1',
            'wws_desktop_location'      => 'br',
            'wws_display_on_mobile'     => '1',
            'wws_mobile_location'       => 'br',
            'wws_auto_popup'            => '1',
            'wws_auto_popup_time'       => '10',
            'wws_custom_css'            => '',
            'wws_filter_by_page'        => array(
                'by_slugs'          => NULL,
                'by_slugs_exclude'  => NULL,
                'by_front_page'     => '1',
                'by_everywhere'     => '1',
            ),
            'wws_schedule'              => array(
                    'mon'       => array(
                    'is_enable' => 1,
                    'start'     => '00:00:00',
                    'end'       => '23:59:59'
                ),
                    'tue'       => array(
                    'is_enable' => 1,
                    'start'     => '00:00:00',
                    'end'       => '23:59:59'
                ),
                    'wed'       => array(
                    'is_enable' => 1,
                    'start'     => '00:00:00',
                    'end'       => '23:59:59'
                ),
                    'thu'       => array(
                    'is_enable' => 1,
                    'start'     => '00:00:00',
                    'end'       => '23:59:59'
                ),
                    'fri'       => array(
                    'is_enable' => 1,
                    'start'     => '00:00:00',
                    'end'       => '23:59:59'
                ),
                    'sat'       => array(
                    'is_enable' => 1,
                    'start'     => '00:00:00',
                    'end'       => '23:59:59'
                ),
                    'sun'       => array(
                    'is_enable' => 1,
                    'start'     => '00:00:00',
                    'end'       => '23:59:59'
                )
            )
        ) );

        // Product query settings
        self::register( 'wws_product_query', array(
            'status'                => '0',
            'btn_location'          => 'woocommerce_before_add_to_cart_form',
            'btn_bg_color'          => '#22C15E',
            'btn_text_color'        => '#ffffff',
            'btn_label'             => 'Need Help? Contact Us via WhatsApp',
            'support_number'        => '911234567890',
            'support_person_name'   => 'Maya',
            'support_person_title'  => 'Pre-sale Questions',
            'support_person_img'    => 'http://placehold.it/100x100',
            'support_pre_message'   => 'Hi, I need help with {title} {url}',
            'exclude_by_products'   => array(),
            'exclude_by_categories' => array(),
        ) );

        // GDPR Setting
        self::register( 'wws_gdpr_settings', array(
            'gdpr_status'       => '0',
            'gdpr_msg'          => 'I agree with the {policy_url}',
            'gdpr_privacy_page' => get_option( 'page_on_front' ),
        ) );

        // FB and GA Analytics
        self::register( 'wws_fb_ga_analytics_settings', array(
            'fb_click_tracking_status'          => '1',
            'fb_click_tracking_event_name'      => 'Chat started',
            'fb_click_tracking_event_label'     => 'Support',
            'ga_click_tracking_status'          => '1',
            'ga_click_tracking_event_name'      => 'Button Clicked',
            'ga_click_tracking_event_category'  => 'WordPress WhatsApp Support',
            'ga_click_tracking_event_label'     => 'Support',
        ) );

        // Developer Setting
        self::register( 'wws_developer_settings', array(
            'is_developer'      => '0',
            'delete_setting'    => '0',
        ) );

    }

    /**
     * array_merge_recursive does indeed merge arrays, but it converts values with duplicate
     * keys to arrays rather than overwriting the value in the first array with the duplicate
     * value in the second array, as array_merge does. I.e., with array_merge_recursive,
     * this happens (documented behavior):
     *
     * array_merge_recursive(array('key' => 'org value'), array('key' => 'new value'));
     *     => array('key' => array('org value', 'new value'));
     *
     * array_merge_recursive_distinct does not change the datatypes of the values in the arrays.
     * Matching keys' values in the second array overwrite those in the first array, as is the
     * case with array_merge, i.e.:
     *
     * array_merge_recursive_distinct(array('key' => 'org value'), array('key' => 'new value'));
     *     => array('key' => array('new value'));
     *
     * Parameters are passed by reference, though only for performance reasons. They're not
     * altered by this function.
     *
     * @param array $array1
     * @param array $array2
     *
     * @return array
     */
    protected static function array_merge_recursive_distinct($array1 = array(), $array2 = array()) {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = self::array_merge_recursive_distinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }
        return $merged;
    }


    /**
     * WeCreativez core method to register admin settings
     * @param  string $option_name
     * @param  array  $settings
     * @since 1.0
     */
    public static function register($option_name, $settings = array()) {

        // add plugin settings in wp_options table
        $db_setting    = get_option($option_name, array());
        $merge_setting = self::array_merge_recursive_distinct( (array)$settings, (array)$db_setting );
        update_option($option_name, $merge_setting);

    }


} // .WWS_Activation