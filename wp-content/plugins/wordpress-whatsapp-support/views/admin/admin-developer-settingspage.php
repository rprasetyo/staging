<form action="#" method="post">
    
    <h3><?php esc_html_e( 'Developer Settings', 'wc-wws' ); ?></h3>

    <table class="form-table">
      
        <tbody>
            
            <?php

                // Developer
                $field->add( 'checkbox',
                    array(
                        'label'         => esc_html__( 'Developer', 'wc-wws' ),
                        'name'          => 'wws_developer_settings[is_developer]',
                        'value'         => intval( $wws_developer_settings['is_developer'] ),
                        'checkbox_text' => esc_html__( 'Enable/ Disable', 'wc-wws' ),
                        'desc'          => esc_html__( 'Please do not turn on without our recommendation.', 'wc-wws' ),
                    )
                );

                // Delete Plugin Setting
                $field->add( 'checkbox',
                    array(
                        'label'         => esc_html__( 'Delete Plugin Setting', 'wc-wws' ),
                        'name'          => 'wws_developer_settings[delete_setting]',
                        'value'         => intval( $wws_developer_settings['delete_setting'] ),
                        'checkbox_text' => esc_html__( 'Enable/ Disable', 'wc-wws' ),
                        'desc'          => esc_html__( 'If you want to delete plugin settings stored in database then enable this option and then click on the save changes button. Now delete the plugin from your plugins page.', 'wc-wws' ),
                    )
                );

            ?>

        </tbody>

    </table>

    <?php submit_button( esc_html__( 'Save Changes', 'wc-wws' ), 'primary', 'wws_developer_settings_submit' ) ?>

</form>