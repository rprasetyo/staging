<?php

// Preventing to direct access
defined('ABSPATH') OR die('Direct access not acceptable!');

if ( ! class_exists('Wecreativez_Report')) {

    class Wecreativez_Report {

        public function get_report(  ) {
            $this->beauty( $this->check_wp() );
        }

        private function check_wp() {

            $data = array(
                'Site Information'            => array(
                    'Site URL' => site_url(),
                ),
                'Server Information'          => array(
                    'PHP Version'            => PHP_VERSION,
                    'Web Server Information' => $_SERVER['SERVER_SOFTWARE'],
                ),
                'WordPress Information'       => array(
                    'WP Version' => get_bloginfo('version'),
                ),
                'WordPress Activated Plugins' => $this->get_activated_plugins(),
                'WordPress Actions'           => array(
                    'init'      => has_action('init') ? 1 : 0,
                    'wp'        => has_action('wp') ? 1 : 0,
                    'wp_head'   => has_action('wp_head') ? 1 : 0,
                    'wp_footer' => has_action('wp_footer') ? 1 : 0,
                ),

              );

            return $data;

        }

        private function get_activated_plugins() {

            if ( ! function_exists( 'get_plugins' ) ) {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
            }

            $data = array();

            $active_plugins = get_option( 'active_plugins', array() );

            foreach ( get_plugins() as $plugin_path => $plugin ) {
                // If the plugin isn't active, don't show it.
                if ( ! in_array( $plugin_path, $active_plugins ) )
                    continue;
                $data[$plugin['Name']] = $plugin['Version'] ;
            }

            return $data;

        }

        private function create_row_array( $array = array() ) {

            foreach ( $array as $key => $value ) {
                if ( is_array( $value ) || is_object( $value ) ) {
                    echo "<tr><td colspan='2' style='height: 14px;'></td></tr>";
                    echo "<tr><td colspan='2'><strong>## {$key} ##</strong></td></tr>";;
                    $this->create_row_array( $value );
                } else {
                   echo "<tr><td>$key</td><td>$value</td></tr>";
                }
            }
        }

        public function beauty( $array = array() ) {
            ?>
                <table>
                    <tbody>
                        <?php $this->create_row_array( $array ) ?>
                    </tbody>
                </table>

            <?php
        }


    } // end of Wecreativez_Report class

}
