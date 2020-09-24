<?php
/**
 * Framework Name: WeCreativez Plugin Framework
 * Version: 1.0.4
 * Author: WeCreativez
 * Text Domain: wecreativez-plugin-fw
 * Domain Path: /languages/
 */

if ( ! defined ( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! function_exists ( 'wecreativez_maybe_plugin_fw_loader' ) ) {
    /**
     * wecreativez_maybe_plugin_fw_loader
     *
     * @since 1.0.0
     */
    function wecreativez_maybe_plugin_fw_loader ( $plugin_path ) {
        global $plugin_wc_data;

        $default_headers = array (
            'Name'       => 'Framework Name',
            'Version'    => 'Version',
            'Author'     => 'Author',
            'TextDomain' => 'Text Domain',
            'DomainPath' => 'Domain Path',
        );

        $framework_data      = get_file_data ( trailingslashit ( $plugin_path ) . 'plugin-core/init.php', $default_headers );
        $plugin_wc_main_file = trailingslashit ( $plugin_path ) . 'plugin-core/wc-plugin.php';

        if ( ! empty( $plugin_wc_data ) ) {
            foreach ( $plugin_wc_data as $version => $path ) {
                if ( version_compare ( $version, $framework_data[ 'Version' ], '<' ) ) {
                    $plugin_wc_data = array ( $framework_data[ 'Version' ] => $plugin_wc_main_file );
                }
            }
        } else {
            $plugin_wc_data = array ( $framework_data[ 'Version' ] => $plugin_wc_main_file );
        }
    }
}


