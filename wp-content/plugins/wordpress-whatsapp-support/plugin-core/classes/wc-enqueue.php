<?php

// Preventing to direct access
defined('ABSPATH') OR die('Direct access not acceptable!');

if ( ! class_exists('Wecreativez_Core_Enqueue')):

    class Wecreativez_Core_Enqueue {

        public function __construct() {

            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

        }

        public function enqueue_scripts() {


            wp_register_style('wecreativez-core-style', WECREATIVEZ_CORE_URL . 'assets/css/wecreativez-core-style.css', array('wp-color-picker'), WECREATIVEZ_CORE_VER);
            wp_register_script('wecreativez-core-script', WECREATIVEZ_CORE_URL . 'assets/js/wecreativez-core-script.js', array('wp-color-picker'), WECREATIVEZ_CORE_VER, true);

            //  Admin Tippy
            wp_register_script('wecreativez-core-tooltip', WECREATIVEZ_CORE_URL . 'assets/libraries/tippy/tippy.all.min.js', array(), '3.4.1', true);

            wp_register_style('wecreativez-core-select2', WECREATIVEZ_CORE_URL . 'assets/libraries/select2/select2.min.css', array(), '4.0.6-rc.0');
            wp_register_script('wecreativez-core-select2', WECREATIVEZ_CORE_URL . 'assets/libraries/select2/select2.min.js', array(), '4.0.6-rc.0', true);

            wp_register_style( 'wecreativez-core-fonts', WECREATIVEZ_CORE_URL . 'assets/css/wecreativez-core-fonts.css', array(), '4.7.0' );
       
            wp_register_style('wecreativez-core-datatable', WECREATIVEZ_CORE_URL . 'assets/libraries/datatable/jquery.dataTables.min.css', array(), '1.10.19');
            wp_register_script('wecreativez-core-datatable', WECREATIVEZ_CORE_URL . 'assets/libraries/datatable/jquery.dataTables.min.js', array(), '1.10.19', true);

            wp_register_style('wecreativez-prism', WECREATIVEZ_CORE_URL . 'assets/libraries/prism/prism.css', array(), '1.16.0');
            wp_register_script('wecreativez-prism', WECREATIVEZ_CORE_URL . 'assets/libraries/prism/prism.js', array(), '1.16.0', true);

        }


    } // end Wecreativez_Core_Enqueue

    new Wecreativez_Core_Enqueue;

endif;