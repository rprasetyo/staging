<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

/**
* Add popup for frontend users
* @package WeCreativez/Public
* @since 1.2
*/
class WWS_Widget {


    public function __construct() {

        add_action( 'wp_footer', array( $this, 'display_popup' ) );

    }

    /**
    * Displaying widget on frontend
    * @since 1.2
    */
    public function display_popup() {

        if ( apply_filters( 'wws_display_widget_on_current_page', $this->disable_popup() ) != true ) {
            return;
        }

        $layout = apply_filters( 'wws_current_layout', $this->_get_setting('ui_layout') );

        require_once WWS_ABSPATH . 'views/wws-template-' . intval( $layout ) . '.php';

    }


    /**
    * Display on page 
    * @return bool 
    * @since 1.2
    */
    public function display_on_page() {

        global $post;

        // Not display wws on selected page
        $by_slugs_exclude = $this->_get_setting('wws_filter_by_page', 'by_slugs_exclude');
        if ( count( $by_slugs_exclude ) != 0 ) {  
            $post_slug = $post->post_name;
            if ( in_array( $post_slug, $by_slugs_exclude) ) {
                return false;
            }
        }

        // display wws on selected page
        $by_slugs = $this->_get_setting('wws_filter_by_page', 'by_slugs');
        if (  count( $by_slugs ) != 0 ) {  
            $post_slug = $post->post_name;
            return in_array( $post_slug, $by_slugs);
        }

        // display wws on front page
        if ( is_front_page() == true && $this->_get_setting('wws_filter_by_page', 'by_front_page') == 1 ) {
            return true;
        }

        // display wws on all pages and posts
        if ( $this->_get_setting('wws_filter_by_page', 'by_everywhere') == 1 ) {
            return true;
        }

        return false;

    }



    public function disable_popup() {


        // if is_mobile == true && enable_moble != true : return
        if ( wp_is_mobile() == true && $this->_get_setting( 'wws_display_on_mobile' ) != 1 ) {
            return false;
        }

        // if is_desktop == true && enable_desktop != true : return
        if ( ! wp_is_mobile() == true && $this->_get_setting( 'wws_display_on_desktop' ) != 1 ) {
            return false;
        }

        // if display on page is not true
        if ( $this->display_on_page() != true ) {
            return false;
        }

        // if schedule is true
        if ( $this->is_schedule() != true ) {
            return false;
        }

        return true;

    }


    public function format_time_for_compare($day, $time) {
        return (int)str_replace(":","",$this->_get_schedule($day, $time));
    }

    public function is_schedule() {

        $current_day    = strtolower(current_time('D'));
        $current_time   = (int)current_time('His');

        // for monday
        if ( $current_day == 'mon' && $this->_get_schedule('mon', 'is_enable') == 1) {
            if ( ( $current_time > $this->format_time_for_compare('mon', 'start') ) && ( $current_time < $this->format_time_for_compare('mon', 'end') )  ) {
                    return true;
                } 
        }
        // for tuesday
        if ( $current_day == 'tue' && $this->_get_schedule('tue', 'is_enable') == 1) {
            if ( ( $current_time > $this->format_time_for_compare('tue', 'start') ) && ( $current_time < $this->format_time_for_compare('tue', 'end') )  ) {
                    return true;
                } 
        }
        // for wednesday
        if ( $current_day == 'wed' && $this->_get_schedule('wed', 'is_enable') == 1) {
            if ( ( $current_time > $this->format_time_for_compare('wed', 'start') ) && ( $current_time < $this->format_time_for_compare('wed', 'end') )  ) {
                    return true;
                } 
        }
        // for thursday
        if ( $current_day == 'thu' && $this->_get_schedule('thu', 'is_enable') == 1) {
            if ( ( $current_time > $this->format_time_for_compare('thu', 'start') ) && ( $current_time < $this->format_time_for_compare('thu', 'end') )  ) {
                    return true;
                } 
        }
        // for friday
        if ( $current_day == 'fri' && $this->_get_schedule('fri', 'is_enable') == 1) {
            if ( ( $current_time > $this->format_time_for_compare('fri', 'start') ) && ( $current_time < $this->format_time_for_compare('fri', 'end') )  ) {
                    return true;
                } 
        }
        // for saturday
        if ( $current_day == 'sat' && $this->_get_schedule('sat', 'is_enable') == 1) {
            if ( ( $current_time > $this->format_time_for_compare('sat', 'start') ) && ( $current_time < $this->format_time_for_compare('sat', 'end') )  ) {
                    return true;
                } 
        }
        // for sunday
        if ( $current_day == 'sun' && $this->_get_schedule('sun', 'is_enable') == 1) {
            if ( ( $current_time > $this->format_time_for_compare('sun', 'start') ) && ( $current_time < $this->format_time_for_compare('sun', 'end') )  ) {
                    return true;
                } 
        }

        return false;

    }


    /**
    * Get plugin settings
    * @param  string $setting first level key of an array
    * @param  string $level2  second level key of an array
    * @return mixed          return value from an associated array
    * @since 1.2
    */
    private function _get_setting($setting, $level2 = NULL) {
        
        $data = get_option( 'sk_wws_setting', array() );
        
        if( ! $data[$setting] ) {
            return;
        }

        if ( $level2 != NULL ) {
            return $data[$setting][$level2];
        }

        return $data[$setting];
    }


    /**
     * Get schedule data
     * @param  steing $day    mon,tue,wed,thu,fri,sat,sun
     * @param  mixed $level2 
     * @return mixed
     * @since 1.2
     */
    private function _get_schedule($day, $level2 = NULL) {

        $schedule = $this->_get_setting( 'wws_schedule', $day );

        if ( ! $schedule) {
            return;
        }
        
        if ( $level2 )  {
            return $schedule[$level2];
        }

        return $schedule;
    }



} // .WWS_Widget


$wss_widget = new WWS_Widget;