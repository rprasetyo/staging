<form action="#" method="post">

    <?php 
        // Single support person layout
        if ( $sk_wws_setting['ui_layout'] == '1' 
        || $sk_wws_setting['ui_layout'] == '2' 
        || $sk_wws_setting['ui_layout'] == '3' 
        || $sk_wws_setting['ui_layout'] == '4'
        || $sk_wws_setting['ui_layout'] == '7' ) : 
    ?>

        <h3><?php esc_html_e( 'WhatsApp Single Person Support', 'wc-wws' ); ?></h3>

        <table class="form-table">
            
            <tbody>
                
                <?php

                    // Support Group ID
                    $field->add('text',
                        array(
                            'label'         => esc_html__('Support Contact Number', 'wc-wws'),
                            'name'          => 'sk_wws_setting[wws_contact_number]',
                            'value'         => esc_html( $sk_wws_setting['wws_contact_number'] ),
                            'tooltip'       => esc_html__('Enter mobile phone number with the international country code, without + character. Example:  911234567890 for (+91) 1234567890', 'wc-wws'),
                        )
                    );

                    // Support Person Image
                    $field->add('file',
                        array(
                            'label'         => esc_html__('Support Person Image', 'wc-wws'),
                            'id'            => 'wws-single-support-person-image',
                            'name'          => 'sk_wws_setting[ui_support_person_img]',
                            'value'         => esc_url( $sk_wws_setting['ui_support_person_img'] ),
                            'tooltip'       => esc_html__('Upload support person image', 'wc-wws'),
                        )
                    );

                ?>

            </tbody>

        </table>

        <hr>

    <?php endif; ?>

    <?php 
        //  Group invitation layout
        if ( $sk_wws_setting['ui_layout'] == '5' ) : 
    ?>

        <h3><?php esc_html_e( 'WhatsApp Group Settings', 'wc-wws' ); ?></h3>

        <table class="form-table">
            
            <tbody>
                
                <?php

                    // Support Group ID
                    $field->add('text',
                        array(
                            'label'         => esc_html__('Support Group ID', 'wc-wws'),
                            'name'          => 'sk_wws_setting[wws_group_id]',
                            'value'         => esc_html( $sk_wws_setting['wws_group_id'] ),
                            'tooltip'       => esc_html__('Enter your WhatsApp group chat ID', 'wc-wws'),
                        )
                    );

                ?>

            </tbody>

        </table>

        <hr>

    <?php endif; ?>

    <?php 
        //  Multi person support layout
        if ( $sk_wws_setting['ui_layout'] == '6' ) : 
    ?>

        <h3><?php _e('WhatsApp Multi Account Settings', 'wc-wws') ?></h3>

        <table class="form-table">
        
            <tbody>

                <?php foreach ( get_option( 'sk_wws_multi_account', array() ) as $key => $value) : ?>

                    <tr>
                        <th scope="row">
                            <label><?php echo esc_html( $value['name'] ) ?> <small><?php echo '( '. esc_html( $value['title'] ) . ' )' ?></small></label>
                        </th>
                        <td>
                            <a href="#" data-multi-account-key="<?php echo esc_attr( $key ) ?>" class="button wws_edit_multi_account_show_popup"><?php esc_html_e( 'Edit', 'wc-wws' ) ?></a>&nbsp;<a href="?wws_multi_account_delete=<?php echo esc_attr( $key ) ?>" class="wecreativez-btn-delete"><?php esc_html_e( 'Delete', 'wc-wws' ) ?></a>
                        </td>
                    </tr>

                <?php endforeach; ?>      

                <tr>
                    <th scope="row">
                        <label><?php esc_html_e( 'Add Support Person', 'wc-wws' ) ?></label>
                    </th>
                    <td>
                        <a href="#" name="<?php esc_html_e('Add Support Person', 'wc-wws') ?>" class="button button-primary wws_add_multi_account_show_popup"><?php esc_html_e( 'Add Support Person', 'wc-wws' ) ?></a>
                    </td>
                </tr>

            </tbody>

        </table>

    <?php endif; ?>

    <?php submit_button( esc_html__( 'Save Changes', 'wc-wws' ), 'primary', 'wws_manage_support_person_settings_submit' ) ?>

</form>