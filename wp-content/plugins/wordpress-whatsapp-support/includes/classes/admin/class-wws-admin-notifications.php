<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

class WWS_Admin_Notifications {

    public function __construct() {

        add_action( 'wws_admin_notifications', array( $this, 'save_settings_notifications' ), 20 );
        add_action( 'wws_admin_notifications', array( $this, 'review_notification' ), 25 );

    }


    public function save_settings_notifications() {

        if ( isset( $_POST['wws_basic_settings_submit'] ) 
        || isset( $_POST['wws_manage_support_person_settings_submit'] )
        || isset( $_POST['wws_gdpr_settings_submit'] ) 
        || isset( $_POST['wws_product_query_settings_submit'] ) 
        || isset( $_POST['wws_fb_ga_analytics_settings_submit'] )
        || isset( $_POST['wws_edit_multi_account_submit'] )
        || isset( $_POST['wws_add_multi_account_submit'] )
        || isset( $_GET['wws_multi_account_delete'] )
        || isset( $_POST['wws_developer_settings_submit'] ) ) {

            ?>

                <div class="notice notice-success is-dismissible">
                    <p><?php esc_html_e( 'Settings saved.', 'wc-wws' ) ?></p>
                </div>

            <?php

        }

        if ( isset( $_POST['wws_appearance_settings_submit'] ) ) {

            ?>

                <div class="notice notice-success is-dismissible">
                    <p><?php wp_kses_post( printf( __( 'Settings saved. If you changed the layout then please go to <a href="%s">Manage Support Persons</a> to add or modify the support persons.', 'wc-wws' ), admin_url( 'admin.php?page=wc-whatsapp-support&tab=manage_support_persons' ) ) ) ?></p>
                </div>

            <?php

        }

        if ( isset( $_GET['wws_generate_debug_report'] ) ) {

            ?>

                <div class="notice notice-success is-dismissible">
                    <p><?php esc_html_e( 'Report generated. Please click on Download Report button.', 'wc-wws' ) ?></p>
                </div>

            <?php

        }


    }


    public function review_notification() {

        if ( get_option( 'wws_admin_review' ) != '1' ) {
        
            require_once WWS_ABSPATH . 'views/admin/notifications/admin-review.php';

        }

    }



} // end of class WWS_Admin_Notifications

$wws_admin_notifications = new WWS_Admin_Notifications;