<div class="wrap">
  
    <h1><?php esc_html_e( 'Facebook and Google Analytics', 'wc-wws' ) ?></h1>
    
    <?php do_action( 'wws_admin_notifications' ); ?>

    <hr>

    <form action="#" method="post">
        
        <h3><?php esc_html_e( 'Facebook Pixel Analytics', 'wc-wws' ) ?></h3>

        <table class="form-table">
            
            <tbody>
                
                <?php

                    // Facebook Click Tracking
                    $field->add( 'checkbox',
                        array(
                            'label'         => esc_html__( 'Facebook Click Tracking', 'wc-wws' ),
                            'name'          => 'wws_fb_ga_analytics_settings[fb_click_tracking_status]',
                            'value'         => intval( $wws_fb_ga_analytics_settings['fb_click_tracking_status'] ),
                            'checkbox_text' => esc_html__( 'Enable/ Disable', 'wc-wws' ),
                            'tooltip'       => esc_html__( 'You can enable or disable facebook pixel click tracking.', 'wc-wws' ),
                        )
                    );

                    // FB Event
                    $field->add( 'text',
                        array(
                            'label'         => esc_html__( 'FB Event', 'wc-wws' ),
                            'name'          => 'wws_fb_ga_analytics_settings[fb_click_tracking_event_name]',
                            'value'         => esc_html( $wws_fb_ga_analytics_settings['fb_click_tracking_event_name'] ),
                            'desc'          => esc_html__( 'Enter the name of custom event to track on Facebook pixel.', 'wc-wws' ),
                        )
                    );

                    // FB Event Label
                    $field->add( 'text',
                        array(
                            'label'         => esc_html__( 'FB Event Label', 'wc-wws' ),
                            'name'          => 'wws_fb_ga_analytics_settings[fb_click_tracking_event_label]',
                            'value'         => esc_html( $wws_fb_ga_analytics_settings['fb_click_tracking_event_label'] ),
                            'desc'          => esc_html__( 'Enter the label of custom event to track on Facebook pixel.', 'wc-wws' ),
                        )
                    );

                ?>

            </tbody>

        </table>

        <hr>

        <h3><?php esc_html_e( 'Google Click Analytics', 'wc-wws' ) ?></h3>

        <table class="form-table">
            
            <tbody>
                
                <?php

                    // Google Event Tracking
                    $field->add( 'checkbox',
                        array(
                            'label'         => esc_html__( 'Google Event Tracking', 'wc-wws' ),
                            'name'          => 'wws_fb_ga_analytics_settings[ga_click_tracking_status]',
                            'value'         => intval( $wws_fb_ga_analytics_settings['ga_click_tracking_status'] ),
                            'checkbox_text' => esc_html__( 'Enable/ Disable', 'wc-wws' ),
                            'tooltip'       => esc_html__( 'You can enable or disable google event click tracking.', 'wc-wws' ),
                        )
                    );

                    // Text
                    $field->add( 'text',
                        array(
                            'label'         => esc_html__( 'GA Event', 'wc-wws' ),
                            'name'          => 'wws_fb_ga_analytics_settings[ga_click_tracking_event_name]',
                            'value'         => esc_html( $wws_fb_ga_analytics_settings['ga_click_tracking_event_name'] ),
                            'desc'          => esc_html__( 'Enter the name of custom the event to track on Google Analytics.', 'wc-wws' ),
                        )
                    );

                    // Text
                    $field->add( 'text',
                        array(
                            'label'         => esc_html__( 'GA Event Category', 'wc-wws' ),
                            'name'          => 'wws_fb_ga_analytics_settings[ga_click_tracking_event_category]',
                            'value'         => esc_html( $wws_fb_ga_analytics_settings['ga_click_tracking_event_category'] ),
                            'desc'          => esc_html__( 'Enter the name of the event category.', 'wc-wws' ),
                        )
                    );

                    // Text
                    $field->add( 'text',
                        array(
                            'label'         => esc_html__( 'GA Event Label', 'wc-wws' ),
                            'name'          => 'wws_fb_ga_analytics_settings[ga_click_tracking_event_label]',
                            'value'         => esc_html( $wws_fb_ga_analytics_settings['ga_click_tracking_event_label'] ),
                            'desc'          => esc_html__( 'Enter the label of the event.', 'wc-wws' ),
                        )
                    );

                ?>

            </tbody>

        </table>

        <?php submit_button( esc_html__( 'Save Changes', 'wc-wws' ), 'primary', 'wws_fb_ga_analytics_settings_submit' ) ?>

    </form>

</div>