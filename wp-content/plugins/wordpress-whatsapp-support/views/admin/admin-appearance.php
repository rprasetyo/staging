<form action="#" method="post">
    
    <table class="form-table">
      
        <tbody>

            <!-- layout selection  -->
            <tr>
                <th scope="row">
                    <label><?php esc_html_e('Select Layout', 'wc-wws') ?></label>
                    <span class="dashicons dashicons-info wecreativez-admin-tooltip" data-tippy-content="<?php _e( 'Select your layout.', 'wc-wws' ) ?>"></span>
                </th>
                <td>
                
                    <table>
                        <tr>
                            <td>
                                <label class="sk-wws-admin-label">
                                    <input type="radio" name="sk_wws_setting[ui_layout]" class="sk-wws-admin-radio" value="1" <?php checked( $sk_wws_setting['ui_layout'], '1' ) ?>>
                                    <img src="<?php echo esc_url( WWS_URL . 'assets/img/admin/template-1.png' ) ?>" class="sk-wws-admin-radio-image" width="240" alt="//">
                                </label>
                                <label class="sk-wws-admin-label">
                                    <input type="radio" name="sk_wws_setting[ui_layout]" class="sk-wws-admin-radio" value="2" <?php checked( $sk_wws_setting['ui_layout'], '2' ) ?>>
                                    <img src="<?php echo esc_url( WWS_URL . 'assets/img/admin/template-2.png' ) ?>" class="sk-wws-admin-radio-image" width="240"  alt="//">
                                </label>
                                <label class="sk-wws-admin-label">
                                    <input type="radio" name="sk_wws_setting[ui_layout]" class="sk-wws-admin-radio" value="3" <?php checked( $sk_wws_setting['ui_layout'], '3' ) ?>>
                                    <img src="<?php echo esc_url( WWS_URL . 'assets/img/admin/template-3.png' ) ?>" class="sk-wws-admin-radio-image" width="240"  alt="//">
                                </label>
                                <label class="sk-wws-admin-label">
                                    <input type="radio" name="sk_wws_setting[ui_layout]" class="sk-wws-admin-radio" value="4" <?php checked( $sk_wws_setting['ui_layout'], '4' ) ?>>
                                    <img src="<?php echo esc_url( WWS_URL . 'assets/img/admin/template-4.png' ) ?>" class="sk-wws-admin-radio-image" width="240"  alt="//">
                                </label>
                                <label class="sk-wws-admin-label">
                                    <input type="radio" name="sk_wws_setting[ui_layout]" class="sk-wws-admin-radio" value="5" <?php checked( $sk_wws_setting['ui_layout'], '5' ) ?>>
                                    <img src="<?php echo esc_url( WWS_URL . 'assets/img/admin/template-5.png' ) ?>" class="sk-wws-admin-radio-image" width="240"  alt="//">
                                </label>
                                <label class="sk-wws-admin-label">
                                    <input type="radio" name="sk_wws_setting[ui_layout]" class="sk-wws-admin-radio" value="6" <?php checked( $sk_wws_setting['ui_layout'], '6' ) ?>>
                                    <img src="<?php echo esc_url( WWS_URL . 'assets/img/admin/template-6.png' ) ?>" class="sk-wws-admin-radio-image" width="240"  alt="//">
                                </label>
                                <label class="sk-wws-admin-label">
                                    <input type="radio" name="sk_wws_setting[ui_layout]" class="sk-wws-admin-radio" value="7" <?php checked( $sk_wws_setting['ui_layout'], '7' ) ?>>
                                    <img src="<?php echo esc_url( WWS_URL . 'assets/img/admin/template-7.png' ) ?>" class="sk-wws-admin-radio-image" width="240"  alt="//">
                                </label>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr><!-- .layout selection -->

        </tbody>

    </table>

    <hr>

    <table class="form-table">

        <tbody>
            
            <?php


                // Layout Background Color
                $field->add('color',
                    array(
                        'label'         => esc_html__( 'Layout Background Color', 'wc-wws' ),
                        'name'          => 'sk_wws_setting[ui_layout_bg_color]',
                        'value'         => esc_html( $sk_wws_setting['ui_layout_bg_color'] ),
                        'tooltip'       => esc_html__( 'Set popup layout background color.', 'wc-wws' ),
                    )
                );

                // Layout Text Color
                $field->add('color',
                    array(
                        'label'         => esc_html__( 'Layout Text Color', 'wc-wws' ),
                        'name'          => 'sk_wws_setting[ui_layout_text_color]',
                        'value'         => esc_html( $sk_wws_setting['ui_layout_text_color'] ),
                        'tooltip'       => esc_html__( 'Set popup layout text color.', 'wc-wws' ),
                    )
                );

                // Enable Layout Gradient
                $field->add('checkbox',
                    array(
                        'label'         => esc_html__( 'Enable Layout Gradient', 'wc-wws' ),
                        'name'          => 'sk_wws_setting[ui_layout_gradient]',
                        'value'         => intval( $sk_wws_setting['ui_layout_gradient'] ),
                        'checkbox_text' => esc_html__( 'Enable/ Disable', 'wc-wws' ),
                        'tooltip'       => esc_html__( 'Enable/ Disable popup background gradient.', 'wc-wws' ),
                    )
                );

            ?>
            
        </tbody>

    </table>

    <hr>

    <h3><?php esc_html_e( 'WhatsApp Support Trigger Button', 'wc-wws' ) ?></h3>

    <table class="form-table">
        
        <tbody>
            
            <?php

                // Trigger Button Text
                $field->add('text',
                    array(
                        'label'         => esc_html__('Trigger Button Text', 'wc-wws'),
                        'name'          => 'sk_wws_setting[text_trigger_btn]',
                        'value'         => esc_html( $sk_wws_setting['text_trigger_btn'] ),
                        'tooltip'       => esc_html__('If you leave it blank than, trigger button shown as only icon.', 'wc-wws'),
                    )
                );

                // Show Only Icon on Mobile
                $field->add('checkbox',
                    array(
                        'label'         => esc_html__( 'Show Only Icon on Mobile', 'wc-wws' ),
                        'name'          => 'sk_wws_setting[ul_trigger_btn_only_icon]',
                        'value'         => intval( $sk_wws_setting['ul_trigger_btn_only_icon'] ),
                        'checkbox_text' => esc_html__( 'Enable/ Disable', 'wc-wws' ),
                        'tooltip'       => esc_html__( 'Enable this option if you what to display an icon instead of text button on mobile.', 'wc-wws' ),
                    )
                );

            ?>

        </tbody>

    </table>

    <hr>

    <h3><?php esc_html_e('WhatsApp Support Text Settings', 'wc-wws') ?></h3>

    <table class="form-table">
        
        <tbody>
            
            <?php

                // About Support
                $field->add('textarea',
                    array(
                        'label'         => esc_html__('About Support.', 'wc-wws'),
                        'name'          => 'sk_wws_setting[text_about_support]',
                        'value'         => esc_html( $sk_wws_setting['text_about_support'] ),
                        'tooltip'       => esc_html__('About Support.', 'wc-wws'),
                    )
                );

                // Welcome Messages
                $field->add('text',
                    array(
                        'label'         => esc_html__('Welcome Messages', 'wc-wws'),
                        'name'          => 'sk_wws_setting[text_welcome_msg]',
                        'value'         => esc_html( $sk_wws_setting['text_welcome_msg'] ),
                        'tooltip'       => esc_html__('Welcome message from Support. Sometime this can be use as pre message.', 'wc-wws'),
                    )
                );

                // Input Placeholder Text
                $field->add('text',
                    array(
                        'label'         => esc_html__('Input Placeholder Text', 'wc-wws'),
                        'name'          => 'sk_wws_setting[text_input_placeholder]',
                        'value'         => esc_html( $sk_wws_setting['text_input_placeholder'] ),
                        'tooltip'       => esc_html__('Input placeholder.', 'wc-wws'),
                    )
                );

                // Number Placeholder Text
                $field->add('text',
                    array(
                        'label'         => esc_html__('Number Placeholder Text', 'wc-wws'),
                        'name'          => 'sk_wws_setting[text_number_placeholder]',
                        'value'         => esc_html( $sk_wws_setting['text_number_placeholder'] ),
                        'tooltip'       => esc_html__('Enter the placeholder text for asking WhatsApp number from visitors.', 'wc-wws'),
                    )
                );

                // Predefined Text
                $field->add('textarea',
                    array(
                        'label'         => esc_html__('Predefined Text', 'wc-wws'),
                        'name'          => 'sk_wws_setting[text_predefined_text]',
                        'value'         => esc_html( $sk_wws_setting['text_predefined_text'] ),
                        'desc'          => wp_kses_post( sprintf( __( '%s to display current page title in chat.<br>%s to display current page URL in chat.<br>%s to break the line into a new line.', 'wc-wws' ), '<code>{title}</code>', '<code>{url}</code>', '<code>{br}</code>' ) ),
                        'tooltip'       => esc_html__('This will automatically append the following options along with user text.', 'wc-wws'),
                    )
                );

            ?>

        </tbody>

    </table>

    <?php submit_button( esc_html__( 'Save Changes', 'wc-wws' ), 'primary', 'wws_appearance_settings_submit' ) ?>

</form>