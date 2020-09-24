<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

final class WWS_Init {

    public function init() {

        // Deprecated Functions, Classes, Shortcodes etc
        require_once WWS_ABSPATH . 'includes/wws-deprecated.php';

        // functions and helpers
        require_once WWS_ABSPATH . 'includes/helpers/helper-wws-functions.php';
        require_once WWS_ABSPATH . 'includes/helpers/helper-wws-dropdown.php';

        // Classes
        //  Common Classes
        require_once WWS_ABSPATH . 'includes/classes/class-wws-enqueue-scripts.php';

        // Admin classes
        if ( is_admin() ) {
            require_once WWS_ABSPATH . 'includes/classes/admin/class-wws-admin-ajax.php';
            require_once WWS_ABSPATH . 'includes/classes/admin/class-wws-plugin-activation.php';
            require_once WWS_ABSPATH . 'includes/classes/admin/class-wws-admin-send-email.php';
            require_once WWS_ABSPATH . 'includes/classes/admin/class-wws-admin-save-settings.php';
            require_once WWS_ABSPATH . 'includes/classes/admin/class-wws-admin-menu.php';
            require_once WWS_ABSPATH . 'includes/classes/admin/class-wws-admin-visual-composer.php';
            require_once WWS_ABSPATH . 'includes/classes/admin/class-wws-admin-notifications.php';
        }

        if ( get_option( 'sk_wws_license_key' ) ) {

            require_once WWS_ABSPATH . 'includes/classes/public/class-wws-public-ajax.php';
            
            // Public
            require_once WWS_ABSPATH . 'includes/classes/public/class-wws-analytics.php';
            require_once WWS_ABSPATH . 'includes/classes/public/class-wws-widget.php';
            require_once WWS_ABSPATH . 'includes/classes/public/class-wws-gdpr-compliance.php';
            require_once WWS_ABSPATH . 'includes/classes/public/class-wws-button-generator.php';
            require_once WWS_ABSPATH . 'includes/classes/public/class-wws-qr-generator.php';
            require_once WWS_ABSPATH . 'includes/classes/public/class-wws-product-query.php';

        }

    }

}