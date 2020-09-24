<div class="wrap">
    
    <h1><?php esc_html_e( 'GDPR Setting', 'wc-wws' ) ?></h1>

    <?php do_action( 'wws_admin_notifications' ); ?>
    
    <hr>

    <form action="#" method="post" accept-charset="utf-8">
        
        <table class="form-table">
            
            <tbody>
                
                <?php

                    // Enable/ Disable GDPR
                    $field->add('checkbox',
                        array(
                            'label'         => esc_html__( 'GDPR', 'wc-wws' ),
                            'name'          => 'wws_gdpr_settings[gdpr_status]',
                            'value'         => intval( $wws_gdpr_settings['gdpr_status'] ),
                            'checkbox_text' => esc_html__( 'Enable/ Disable', 'wc-wws' ),
                            'tooltip'       => esc_html__( 'Enable/ Disable GDPR compliant.', 'wc-wws' ),
                        )
                    );

                    // GDPR Message
                    $field->add('textarea',
                        array(
                            'label'         => esc_html__('GDPR Message', 'wc-wws'),
                            'name'          => 'wws_gdpr_settings[gdpr_msg]',
                            'value'         => esc_html( $wws_gdpr_settings['gdpr_msg'] ),
                            'desc'          => wp_kses_post( wp_sprintf( __('Use shortcode %s to add privacy page link.', 'wc-wws') , '<code>{policy_url}</code>' ) ),
                        )
                    );

                ?>

                <tr>
                    <th scope="row">
                        <label><?php esc_html_e('Privacy page', 'wc-wws') ?></label>
                        <span class="dashicons dashicons-info wecreativez-admin-tooltip" data-tippy-content="<?php esc_html_e( 'Select your privacy page.', 'wc-wws' ) ?>"></span>
                    </th>
                    <td>
                        <?php 
                            wws_admin_page_dropdown( 
                                array(
                                    'name'      => 'wws_gdpr_settings[gdpr_privacy_page]',
                                    'selected'  =>  $wws_gdpr_settings['gdpr_privacy_page'], 
                                ) 
                            ) 
                        ?>
                    </td>
                </tr>

            </tbody>

        </table>

        <?php submit_button( esc_html__( 'Save Changes', 'wc-wws' ), 'primary', 'wws_gdpr_settings_submit' ) ?>

    </form>

                          
</div>