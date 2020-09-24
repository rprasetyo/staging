<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

if ( ! class_exists( 'WWS_Analytics' ) ) :

    /**
     * Plugin public analytics report
     * @package WeCreativez/Classes
     * @since 1.4
     */
    class WWS_Analytics {

        public function __construct() {

            add_action( "wp_ajax_wws_click_analytics", array( $this, 'click_analytics' ) );
            add_action( "wp_ajax_nopriv_wws_click_analytics", array( $this, 'click_analytics' ) );

            add_action( "wp_ajax_wws_analytics_deep_report", array( $this, 'analytics_deep_report' ) );
            add_action( "wp_ajax_nopriv_wws_analytics_deep_report", array( $this, 'analytics_deep_report' ) );

            add_action( 'admin_init', array( $this, 'delete_complete_analytics' ) );
            add_action( 'admin_init', array( $this, 'delete_analytics' ) );

        }


        public function delete_complete_analytics() {

            if ( ! isset( $_GET['wws_delete_complete_analytics'] ) ) {
                return;
            }

            if ( ! is_admin() ) {
                return;
            }

            $this->_delete_all_analytics();

            wp_redirect( admin_url( 'admin.php?page=wc-whatsapp-support-analytics' ) );


        }

        public function delete_analytics() {

            if ( ! isset( $_GET['wws_delete_analytics'] ) ) {
                return;
            }

            if ( ! is_admin() ) {
                return;
            }
            
            global $wpdb;
            
            $wws_analytics_table = $wpdb->prefix.'wws_analytics';
            
            $wpdb->delete( $wws_analytics_table, array( 'ID' => $_GET['wws_delete_analytics'] ), array( '%d' ) );

            wp_redirect( admin_url( 'admin.php?page=wc-whatsapp-support-analytics' ) );


        }


        public function click_analytics() {

            global $wpdb;

            $wpdb->insert( 
                $wpdb->prefix.'wws_analytics', 
                array( 
                    'visitor_ip'    => $this->_get_current_ip(),
                    'number'        => ( isset( $_POST['number'] ) ? sanitize_text_field( $_POST['number'] ) : 'N/A' ),
                    'message'       => ( isset( $_POST['message'] ) ? sanitize_text_field( $_POST['message'] ) : 'N/A' ),
                    'referral'      => $this->_get_current_url(),
                    'device_type'   => ( wp_is_mobile() == true ? 'Mobile' : 'Desktop' ),
                    'os'            => $this->_getOS(),
                    'browser'       => $this->getBrowser(),
                    'date'          => current_time('M d, y - H:i:s')
                )
            );

            wp_die();
        }

        public function analytics_deep_report() {

            if ( ! is_admin() ) {
                return;
            }

            $ip = $_GET['ip'];

            $ip_data = maybe_unserialize( file_get_contents( "http://ip-api.com/php/$ip" ) );

            $ip_city            = isset( $ip_data['city'] ) ? $ip_data['city'] : '';
            $ip_region          = isset( $ip_data['regionName'] ) ? $ip_data['regionName'] : '';
            $ip_country         = isset( $ip_data['country'] ) ? $ip_data['country'] : '';
            $ip_zip             = isset( $ip_data['zip'] ) ? $ip_data['zip'] : '';

            $ip_lon             = isset( $ip_data['lon'] ) ? $ip_data['lon'] : '';
            $ip_lat             = isset( $ip_data['lat'] ) ? $ip_data['lat'] : '';

            $ip_org             = isset( $ip_data['org'] ) ? $ip_data['org'] : '';
            $ip_as              = isset( $ip_data['as'] ) ? $ip_data['as'] : '';
            $ip_isp             = isset( $ip_data['isp'] ) ? $ip_data['isp'] : '';

            $ip_timezone    = isset( $ip_data['timezone'] ) ? $ip_data['timezone'] : '';


            require_once WWS_ABSPATH . 'views/admin/analytics/admin-deep-analytics.php';

            wp_die();
        }


        protected function _get_current_url() {
            return wp_get_referer();
        }


        protected function _get_current_ip() {
            if ( $_SERVER['HTTP_CLIENT_IP'] ) {
                //check ip from share internet
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif ( $_SERVER['HTTP_X_FORWARDED_FOR'] ) {
                //to check ip is pass from proxy
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        }


        protected function _getOS() {
                $os_platform  = "Unknown OS Platform";

                $os_array     = array(
                    '/windows nt 10/i'      =>  'Windows 10',
                    '/windows nt 6.3/i'     =>  'Windows 8.1',
                    '/windows nt 6.2/i'     =>  'Windows 8',
                    '/windows nt 6.1/i'     =>  'Windows 7',
                    '/windows nt 6.0/i'     =>  'Windows Vista',
                    '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                    '/windows nt 5.1/i'     =>  'Windows XP',
                    '/windows xp/i'         =>  'Windows XP',
                    '/windows nt 5.0/i'     =>  'Windows 2000',
                    '/windows me/i'         =>  'Windows ME',
                    '/win98/i'              =>  'Windows 98',
                    '/win95/i'              =>  'Windows 95',
                    '/win16/i'              =>  'Windows 3.11',
                    '/macintosh|mac os x/i' =>  'Mac OS X',
                    '/mac_powerpc/i'        =>  'Mac OS 9',
                    '/linux/i'              =>  'Linux',
                    '/ubuntu/i'             =>  'Ubuntu',
                    '/iphone/i'             =>  'iPhone',
                    '/ipod/i'               =>  'iPod',
                    '/ipad/i'               =>  'iPad',
                    '/android/i'            =>  'Android',
                    '/blackberry/i'         =>  'BlackBerry',
                    '/webos/i'              =>  'Mobile'
                );

                foreach ($os_array as $regex => $value)
                    if (preg_match($regex, $_SERVER['HTTP_USER_AGENT']))
                        $os_platform = $value;

                return $os_platform;
        }




        protected function getBrowser(){
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            if(strpos($user_agent, 'Maxthon') !== FALSE)
                return "Maxthon";
            elseif(strpos($user_agent, 'SeaMonkey') !== FALSE)
                return "SeaMonkey";
            elseif(strpos($user_agent, 'Vivaldi') !== FALSE)
                return "Vivaldi";
            elseif(strpos($user_agent, 'Arora') !== FALSE)
                return "Arora";
            elseif(strpos($user_agent, 'Avant Browser') !== FALSE)
                return "Avant Browser";
            elseif(strpos($user_agent, 'Beamrise') !== FALSE)
                return "Beamrise";
            elseif(strpos($user_agent, 'Epiphany') !== FALSE)
                return 'Epiphany';
            elseif(strpos($user_agent, 'Chromium') !== FALSE)
                return 'Chromium';
            elseif(strpos($user_agent, 'Iceweasel') !== FALSE)
                return 'Iceweasel';
            elseif(strpos($user_agent, 'Galeon') !== FALSE)
                return 'Galeon';
            elseif(strpos($user_agent, 'Edge') !== FALSE)
                return 'Microsoft Edge';
            elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
                return 'Internet Explorer';
            elseif(strpos($user_agent, 'MSIE') !== FALSE)
                return 'Internet Explorer';
            elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
                return "Opera Mini";
            elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
                return "Opera";
            elseif(strpos($user_agent, 'Firefox') !== FALSE)
                return 'Mozilla Firefox';
            elseif(strpos($user_agent, 'Chrome') !== FALSE)
                return 'Google Chrome';
            elseif(strpos($user_agent, 'Safari') !== FALSE)
                return "Safari";
            elseif(strpos($user_agent, 'iTunes') !== FALSE)
                return 'iTunes';
            elseif(strpos($user_agent, 'Konqueror') !== FALSE)
                return 'Konqueror';
            elseif(strpos($user_agent, 'Dillo') !== FALSE)
                return 'Dillo';
            elseif(strpos($user_agent, 'Netscape') !== FALSE)
                return 'Netscape';
            elseif(strpos($user_agent, 'Midori') !== FALSE)
                return 'Midori';
            elseif(strpos($user_agent, 'ELinks') !== FALSE)
                return 'ELinks';
            elseif(strpos($user_agent, 'Links') !== FALSE)
                return 'Links';
            elseif(strpos($user_agent, 'Lynx') !== FALSE)
                return 'Lynx';
            elseif(strpos($user_agent, 'w3m') !== FALSE)
                return 'w3m';
            else
                return 'Unknown';
        }


        public static function get_complete_analytics() {
            global $wpdb;
            $wws_analytics_table = $wpdb->prefix.'wws_analytics';
            return $wpdb->get_results( "SELECT * FROM {$wws_analytics_table} ORDER BY id DESC", ARRAY_A );
        }

        public static function get_total_clicks() {
            global $wpdb;
            $wws_analytics_table = $wpdb->prefix.'wws_analytics';
            return count( $wpdb->get_results( "SELECT id FROM {$wws_analytics_table}", ARRAY_A ) );
        }

        public static function get_total_clicks_by_mobile() {
            global $wpdb;
            $wws_analytics_table = $wpdb->prefix.'wws_analytics';
            return count( $wpdb->get_results( "SELECT id FROM {$wws_analytics_table} WHERE device_type = 'Mobile'", ARRAY_A ) );
        }

        public static function get_total_clicks_by_desktop() {
            global $wpdb;
            $wws_analytics_table = $wpdb->prefix.'wws_analytics';
            return count( $wpdb->get_results( "SELECT id FROM {$wws_analytics_table} WHERE device_type = 'Desktop'", ARRAY_A ) );
        }

 
        private function _delete_all_analytics() {
            global $wpdb;

            $wws_analytics_table = $wpdb->prefix.'wws_analytics';

            $wpdb->query( "TRUNCATE {$wws_analytics_table}" );

        }


    } // .WWS_Analytics

    $wws_analytics = new WWS_Analytics;

endif;

