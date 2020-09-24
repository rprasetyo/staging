<?php
/*
* Plugin Name: WeCreativez WhatsApp Support 
* Description: WordPress WhatsApp Support plugin provides better and easy way to communicate visitors and customers directly to your support person.
* Plugin URI:  http://wecreativez.com/
* Author:      Sonu Kaushal
* Author URI:  http://sonukaushal.com/
* Version:     1.8.1
* License:     GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: wc-wws
* Domain Path: languages
*/

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

// Defined Plugin ABSPATH
if ( ! defined( 'WWS_ABSPATH' ) ) {
    define( 'WWS_ABSPATH', plugin_dir_path( __FILE__ ) );
}
update_option( 'sk_wws_license_key', 'nulled' );
// Defined Plugin URL
if ( ! defined( 'WWS_URL' ) ) {
    define( 'WWS_URL', plugin_dir_url( __FILE__ ) );
}

// Defined plugin version
if ( ! defined( 'WWS_VER' ) ) {
    define( 'WWS_VER', '1.8.1' );
}

/* Plugin Framework Version Check */
if ( ! function_exists( 'wecreativez_maybe_plugin_fw_loader' ) 
    && file_exists( plugin_dir_path( __FILE__ ) . 'plugin-core/init.php' ) ) {
        require_once( plugin_dir_path( __FILE__ ) . 'plugin-core/init.php' );
}
wecreativez_maybe_plugin_fw_loader( plugin_dir_path( __FILE__ ) );


/**
 * Load Plugin Framework
 *
 * @since  1.7
 * @access public
 * @return void
 * @author WeCreativez
 */
 function wws_wc_plugin_fw_loader() {
    if ( ! defined( 'WECREATIVEZ_CORE_PLUGIN' ) ) {
        global $plugin_wc_data;
        if ( !empty( $plugin_wc_data ) ) {
            $plugin_wc_file = array_shift( $plugin_wc_data );
            require_once( $plugin_wc_file );
        }
    }
}
// Load Plugin Framework
add_action( 'plugins_loaded', 'wws_wc_plugin_fw_loader', 15 );


// Load plugin with plugins_load
function wws_init() {

    require_once WWS_ABSPATH . 'includes/class-wws-init.php';

    $wws_init = new WWS_Init;
    $wws_init->init();

}
add_action( 'plugins_loaded', 'wws_init', 20 );


/**
 * This function will run when plugin activate
 * @since 1.2
 */
function wws_plugin_activation() {
    require_once WWS_ABSPATH . 'includes/class-wws-activation.php';
    WWS_Activation::activate();
}
register_activation_hook( __FILE__, 'wws_plugin_activation' );



/**
 * Load plugin textdomain.
 * @since 1.6
 */
if ( ! function_exists( 'wws_load_textdomain' ) ) {
    function wws_load_textdomain() {
        load_plugin_textdomain( 'wc-wws', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
    }
    add_action( 'init', 'wws_load_textdomain' );
}

/**
 * Adding a Settings link to plugin 
 * @since 1.7
 */
function wws_add_plugin_page_settings_link( $links ) {
    $links[] = '<a href="' .
        admin_url( 'admin.php?page=wc-whatsapp-support' ) .
        '">' . esc_html__( 'Settings' ) . '</a>';
    return $links;
}
add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'wws_add_plugin_page_settings_link' );