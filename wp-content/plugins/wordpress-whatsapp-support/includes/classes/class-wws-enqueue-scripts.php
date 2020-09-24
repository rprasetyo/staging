<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * WWS_Enqueue_Scripts class responsable to load all the scripts and styles.
 */
class WWS_Enqueue_Scripts {

    public function __construct() {

        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'public_enqueue_scripts' ), 200 );

        add_action( 'wp_enqueue_scripts', array( $this, 'public_dynamic_resources'), 200 );

    }

    /**
     * Load all the required backend scripts
     * @return void
     * @since 1.3
     */
    public function admin_enqueue_scripts( $hook ) {

        if ( $this->is_my_admin_page( $hook ) !== true ) {
            return;
        }

        // Load WordPress media script
        wp_enqueue_media();

        // enqueue WeCreativez Core fontasweome fonts
        wp_enqueue_style( 'wecreativez-core-fonts' );

        // enqueue WeCreativez Core  tippy tooltip
        wp_enqueue_script( 'wecreativez-core-tooltip' );

        // enqueue WeCreativez Core select2
        wp_enqueue_style( 'wecreativez-core-select2' );
        wp_enqueue_script( 'wecreativez-core-select2' );

        // enqueue WeCreativez Core datatable
        wp_enqueue_style( 'wecreativez-core-datatable' );
        wp_enqueue_script( 'wecreativez-core-datatable' );
        
        // Export CSV for the datatable
        wp_enqueue_script( 'wws-datatable-button-html5', WWS_URL . 'assets/libraries/dataTables/buttons.html5.min.js', array(), '1.5.2', true );
        wp_enqueue_script( 'wws-datatable-button', WWS_URL . 'assets/libraries/dataTables/dataTables.buttons.min.js', array(), '1.5.2', true );

        // Prism
        wp_enqueue_style( 'wecreativez-prism' );
        wp_enqueue_script( 'wecreativez-prism' );

        // enqueue WeCreativez Core style and script
        wp_enqueue_style( 'wecreativez-core-style' );
        wp_enqueue_script( 'wecreativez-core-script' );


        // Timepicker v1.11.12
        wp_enqueue_script( 'wws-timepicker', WWS_URL . 'assets/libraries/timepicker/wws-timepicker.js', array(), '1.11.12', true );
        wp_enqueue_style( 'wws-timepicker', WWS_URL . 'assets/libraries/timepicker/wws-timepicker.css', array(), '1.11.12' );

        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');

        // Load admin scripts
        wp_enqueue_style( 'wws-admin-style', WWS_URL . 'assets/css/wws-admin-style.css', array(), WWS_VER );
        wp_enqueue_script( 'wws-admin-script', WWS_URL . 'assets/js/wws-admin-script.js', array(), WWS_VER, true );
        wp_localize_script( 'wws-admin-script', 'wwsAdimnObj', array(
            'adminAjaxURL' => admin_url( 'admin-ajax.php' ),
        ) );


    }


    /**
     * Check current admin page is plugin admin page or not.
     * @param  string  $hook
     * @return boolean
     */
    public function is_my_admin_page( $hook ) {

        if ( $hook == 'toplevel_page_wc-whatsapp-support' 
         ||  $hook == 'whatsapp-support_page_wc-whatsapp-support-gdpr-setting'
         ||  $hook == 'whatsapp-support_page_wc-whatsapp-support-plugin-support'
         ||  $hook == 'whatsapp-support_page_wc-whatsapp-support-analytics'
         ||  $hook == 'whatsapp-support_page_wc-whatsapp-support-fb-ga-analytics' ) {
            return true;
        }

        return false;
    }

    /**
     * Load all the required frontend scripts
     * @return void
     * @since 1.3
     */
    public function public_enqueue_scripts() {

        // Get Developer settings
        $wws_developer_settings = get_option( 'wws_developer_settings', array() );

        // Get FB and GA Analytics settings
        $wws_fb_ga_analytics_settings = get_option( 'wws_fb_ga_analytics_settings', array() );

        // Get GDPR settings
        $wws_gdpr_settings = get_option( 'wws_gdpr_settings', array() );

        // Get the template
        $template = apply_filters( 'wws_enqueue_css_layout', $this->_get_setting( 'ui_layout' ) );

        // enqueue WeCreativez Core fontasweome fonts
        wp_enqueue_style( 'wecreativez-core-fonts' );

        // Load public scripts
        wp_enqueue_style( 'wws-public-style', WWS_URL . 'assets/css/wws-public-style.css', array(), WWS_VER );
        wp_enqueue_script( 'wws-public-script', WWS_URL . 'assets/js/wws-public-script.js', array(), WWS_VER, true );
        wp_localize_script( 'wws-public-script', 'wwsObj', array(
            'supportNumber'         => esc_html( $this->_get_setting('wws_contact_number') ),
            'autoPopup'             => intval( $this->_get_setting('wws_auto_popup') ),
            'autoPopupTime'         => intval( $this->_get_setting( 'wws_auto_popup_time' ) ),
            'pluginURL'             => esc_url( WWS_URL ),
            'isMobile'              => ( wp_is_mobile() == true ) ? '1' : '0',
            'currentPageID'         => get_the_ID(),
            'currentPageURL'        => get_permalink(),
            'popupTemplate'         => apply_filters( 'wws_current_layout', intval( $this->_get_setting( 'ui_layout' ) ) ),
            'groupInvitationID'     => esc_html( $this->_get_setting('wws_group_id') ),
            'adminAjaxURL'          => admin_url( 'admin-ajax.php' ),
            'scrollLenght'          => esc_html( $this->_get_setting('wws_scroll_length') ),
            'preDefinedText'        => str_replace(
                array( '{title}', '{url}', '{br}' ), 
                array( get_the_title(), get_permalink(), '%0A' ), 
                esc_html( $this->_get_setting( 'text_predefined_text' ) ) 
            ),
            'isDeveloper'           => intval( $wws_developer_settings['is_developer'] ),
            'fbGaAnalytics'         => json_encode( $wws_fb_ga_analytics_settings ),
            'isGDPR'                => intval( $wws_gdpr_settings['gdpr_status'] ),
        ) );

        // Load CSS for template
        wp_enqueue_style( 'wws-public-template', WWS_URL . 'assets/css/wws-public-template-'. intval( $template ) .'.css', array(), WWS_VER );

    }


    /**
     * public dynamic js,css in wp_head
     * @since 1.2
     */
    public function public_dynamic_resources() { 

        $x_axis_offset = $this->_get_setting( 'wws_x_axis_offset' );
        $y_axis_offset = $this->_get_setting( 'wws_y_axis_offset' );

        $dynamic_css = '';

        // Dynamic bg color
        $dynamic_css .= '.wws--bg-color {
            background-color: ' . esc_html( $this->_get_setting('ui_layout_bg_color') ) . ';
        }';

        // Dynamic text color
        $dynamic_css .= '.wws--text-color {
                color: ' . esc_html( $this->_get_setting('ui_layout_text_color') ) . ';
        }';

        // RTL CSS
        if ( $this->_get_setting( 'wws_rtl' ) == 1 ) {

            $dynamic_css .= '.wws-popup-container * { direction: rtl; }
                #wws-layout-1 .wws-popup__header,
                #wws-layout-2 .wws-popup__header,
                #wws-layout-6 .wws-popup__header { 
                    display: flex;
                    flex-direction: row-reverse;
                }
                #wws-layout-1 .wws-popup__input-wrapper { float: left; }';

        }
            
        // Scroll length CSS
        if ( $this->_get_setting('wws_scroll_length') ) {
            
            $dynamic_css .= '.wws-popup-container { display: none; }';

        }

        // Display only icon CSS
        if ( ! $this->_get_setting('text_trigger_btn') ) {

            $dynamic_css .= '.wws-popup__open-btn {
                font-size: 30px;
                border-radius: 50%;
                display: inline-block;
                margin-top: 14px;
                cursor: pointer;
                width: 46px;
                height: 46px;
                position: relative;
                font-family: Arial, Helvetica, sans-serif;
            }
            .wws-popup__open-icon {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }';

        } else {

            $dynamic_css .= '.wws-popup__open-btn {
                padding: 8px 15px;
                font-size: 14px;
                border-radius: 20px;
                display: inline-block;
                margin-top: 14px;
                cursor: pointer;
                font-family: Arial, Helvetica, sans-serif;
            }';
        }

        // Dynamic CSS according to Mobile
        if ( wp_is_mobile() == true ) {

            if ( $this->_get_setting('wws_mobile_location') == 'tl' ) {
                $dynamic_css .= '.wws-popup-container--position { 
                    left: ' . intval( $x_axis_offset ) . 'px; 
                    top: ' . intval( $y_axis_offset ) . 'px; 
                }
                .wws-popup__open-btn { float: left; }';
            }
            
            if ( $this->_get_setting('wws_mobile_location') == 'tc' ) {
                $dynamic_css .= '.wws-popup-container--position { 
                    top: ' . intval( $y_axis_offset ) . 'px; 
                    left: 0; 
                    right: 0; 
                    margin-left: auto; 
                    margin-right: auto; 
                }
                .wws-popup { margin: 0 auto; }
                .wws-popup__footer { text-align: center; }';
            }

            if ( $this->_get_setting('wws_mobile_location') == 'tr' ) {
                $dynamic_css .= '.wws-popup-container--position { 
                    right: ' . intval( $x_axis_offset ) . 'px; 
                    top: ' . intval( $y_axis_offset ) . 'px; 
                }
                .wws-popup__open-btn { float: right; }';
            }

            if ( $this->_get_setting('wws_mobile_location') == 'bl' ) {
                $dynamic_css .= '.wws-popup-container--position { 
                    left: ' . intval( $x_axis_offset ) . 'px; 
                    bottom: ' . intval( $y_axis_offset ) . 'px;
                }
                .wws-popup__open-btn { float: left; }';
            }

            if ( $this->_get_setting('wws_mobile_location') == 'bc' ) {
                $dynamic_css .= '.wws-popup-container--position { 
                    bottom: ' . intval( $y_axis_offset ) . 'px; 
                    left: 0; 
                    right: 0; 
                    margin-left: auto; 
                    margin-right: auto; 
                }
                .wws-popup { margin: 0 auto; }
                .wws-popup__footer { text-align: center; }';
            }

            if ( $this->_get_setting('wws_mobile_location') == 'br' ) {
                $dynamic_css .= '.wws-popup-container--position { 
                    right: ' . intval( $x_axis_offset ) . 'px; 
                    bottom: ' . intval( $y_axis_offset ) . 'px; 
                }
                .wws-popup__open-btn { float: right; }';
            }

        }

        // Dynamic CSS according to Desktop
        if ( wp_is_mobile() != true ) {

            if ( $this->_get_setting('wws_desktop_location') == 'tl' ) {
                 $dynamic_css .= '.wws-popup-container--position { 
                    left: ' . intval( $x_axis_offset ) . 'px; 
                    top: ' . intval( $y_axis_offset ) . 'px; 
                }
                .wws-popup__open-btn { float: left; }
                .wws-gradient--position {
                  top: 0;
                  left: 0;
                  background: radial-gradient(ellipse at top left, rgba(29, 39, 54, 0.2) 0, rgba(29, 39, 54, 0) 72%);
                }';
            }

            if ( $this->_get_setting('wws_desktop_location') == 'tc' ) {
                $dynamic_css .= '.wws-popup-container--position { 
                    top: ' . intval( $y_axis_offset ) . 'px; 
                    left: 0; 
                    right: 0; 
                    margin-left: auto; 
                    margin-right: auto; 
                }
                .wws-popup__footer { text-align: center; }
                .wws-popup { margin: 0 auto; }
                .wws-gradient--position {
                  top: 0;
                  left: 0;
                  right: 0;
                  margin-left: auto;
                  margin-right: auto;
                  background: radial-gradient(ellipse at top, rgba(29, 39, 54, 0.2) 0, rgba(29, 39, 54, 0) 72%);
                }';
            }

            if ( $this->_get_setting('wws_desktop_location') == 'tr' ) {
                $dynamic_css .= '.wws-popup-container--position { 
                    right: ' . intval( $x_axis_offset ) . 'px; 
                    top: ' . intval( $y_axis_offset ) . 'px; 
                }
                .wws-popup__open-btn { float: right; }
                .wws-gradient--position {
                  top: 0;
                  right: 0;
                  background: radial-gradient(ellipse at top right, rgba(29, 39, 54, 0.2) 0, rgba(29, 39, 54, 0) 72%);
                }';
            }

            if ( $this->_get_setting('wws_desktop_location') == 'bl' ) {
                $dynamic_css .= '.wws-popup-container--position { 
                    left: ' . intval( $x_axis_offset ) . 'px; 
                    bottom: ' . intval( $y_axis_offset ) . 'px; 
                }
                .wws-popup__open-btn { float: left; }
                .wws-gradient--position {
                  bottom: 0;
                  left: 0;
                  background: radial-gradient(ellipse at bottom left, rgba(29, 39, 54, 0.2) 0, rgba(29, 39, 54, 0) 72%);
                }';
            }

            if ( $this->_get_setting('wws_desktop_location') == 'bc' ) {
                $dynamic_css .= '.wws-popup-container--position { 
                    bottom: ' . intval( $y_axis_offset ) . 'px; 
                    left: 0; 
                    right: 0; 
                    margin-left: auto; 
                    margin-right: auto; 
                }
                .wws-popup__footer { text-align: center; }
                .wws-popup { margin: 0 auto; }
                .wws-gradient--position {
                  bottom: 0;
                  left: 0;
                  right: 0;
                  margin-left: auto;
                  margin-right: auto;
                  background: radial-gradient(ellipse at bottom, rgba(29, 39, 54, 0.2) 0, rgba(29, 39, 54, 0) 72%);
                }';
            }

            if ( $this->_get_setting('wws_desktop_location') == 'br' ) {
                $dynamic_css .= '.wws-popup-container--position { 
                    right: ' . intval( $x_axis_offset ) . 'px; 
                    bottom: ' . intval( $y_axis_offset ) . 'px; 
                }
                .wws-popup__open-btn { float: right; }
                .wws-gradient--position {
                  bottom: 0;
                  right: 0;
                  background: radial-gradient(ellipse at bottom right, rgba(29, 39, 54, 0.2) 0, rgba(29, 39, 54, 0) 72%);
                }';
            }

        }


        if ( $this->_get_setting( 'ul_trigger_btn_only_icon' ) == 1 ) {

           $dynamic_css .= '@media( max-width: 720px ) {
                .wws-popup__open-btn {
                    padding: 0 !important;
                    width: 50px !important;
                    height: 50px !important;
                    border-radius: 50% !important;
                    display: flex !important;
                    justify-content: center !important;
                    align-items: center !important;
                    font-size: 34px !important;
                }
                .wws-popup__open-btn span { display: none; }
            }';
        }

        $dynamic_css .= $this->_get_setting('wws_custom_css');
        

        wp_add_inline_style( 'wws-public-style', $dynamic_css );
    

    }


    /**
    * Get plugin settings
    * @param  string $setting first level key of an array
    * @param  string $level2  second level key of an array
    * @return mixed          return value from an associated array
    * @since 1.2
    */
    private function _get_setting( $setting, $level2 = NULL ) {
        
        $data = get_option( 'sk_wws_setting', array() );
        
        if( ! $data[$setting] ) {
            return;
        }

        if ( $level2 != NULL ) {
            return $data[$setting][$level2];
        }

        return $data[$setting];
    }


} // end of class WWS_Enqueue_Scripts

$wws_enqueue_scripts = new WWS_Enqueue_Scripts;