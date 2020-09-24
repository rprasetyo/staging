<?php

if ( ! defined ( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

! defined( 'WECREATIVEZ_CORE_PLUGIN' ) && define( 'WECREATIVEZ_CORE_PLUGIN', true);

if ( ! defined('WECREATIVEZ_CORE_PATH')) {
    define('WECREATIVEZ_CORE_PATH', plugin_dir_path(__FILE__));
}

if ( ! defined('WECREATIVEZ_CORE_URL')) {
    define('WECREATIVEZ_CORE_URL', plugin_dir_url(__FILE__));
}

if ( ! defined('WECREATIVEZ_CORE_VER')) {
    define('WECREATIVEZ_CORE_VER', '1.0.4');
}

// Helpers
require_once WECREATIVEZ_CORE_PATH . 'helpers/wc-debug.php';

// classes
require_once WECREATIVEZ_CORE_PATH . 'classes/wc-enqueue.php';
require_once WECREATIVEZ_CORE_PATH . 'classes/wc-field.php';
require_once WECREATIVEZ_CORE_PATH . 'classes/wc-report.php';

// common functions
require_once WECREATIVEZ_CORE_PATH . 'wc-functions.php';
require_once WECREATIVEZ_CORE_PATH . 'wc-dropdowns.php';
