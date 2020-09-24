<form action="#" method="post">
        
    <table class="form-table">
        
        <tbody>
            
            <?php

                // Enable / Disable Product Support Button
                $field->add('checkbox',
                    array(
                        'label'         => esc_html__( 'Product Support Button', 'wc-wws' ),
                        'name'          => 'wws_product_query_settings[status]',
                        'value'         => intval( $wws_product_query_settings['status'] ),
                        'checkbox_text' => esc_html__( 'Enable/ Disable', 'wc-wws' ),
                        'tooltip'       => esc_html__( 'Enable / Disable product support button on WooCommerce single product page.', 'wc-wws' ),
                    )
                );

                // Button Location
                $field->add('select',
                    array(
                        'label'         => esc_html__('Button Location', 'wc-wws'),
                        'name'          => 'wws_product_query_settings[btn_location]',
                        'selected'      => esc_html( $wws_product_query_settings['btn_location'] ),
                        'option'       => array(
                          'woocommerce_before_add_to_cart_form' => esc_html__( 'After Short Description', 'wc-wws' ),
                          'woocommerce_after_add_to_cart_button' => esc_html__( 'After Add to Cart Button', 'wc-wws' ),
                        ),
                        'tooltip'       => esc_html__('Choose the location of product query button.', 'wc-wws'),
                    )
                );

                // Button Color
                $field->add('color',
                    array(
                        'label'         => esc_html__( 'Button Color', 'wc-wws' ),
                        'name'          => 'wws_product_query_settings[btn_bg_color]',
                        'value'         => esc_html( $wws_product_query_settings['btn_bg_color'] ),
                        'tooltip'       => esc_html__( 'Change button background color.', 'wc-wws' ),
                    )
                );

                // Button Text Color
                $field->add('color',
                    array(
                        'label'         => esc_html__( 'Button Text Color', 'wc-wws' ),
                        'name'          => 'wws_product_query_settings[btn_text_color]',
                        'value'         => esc_html( $wws_product_query_settings['btn_text_color'] ),
                        'tooltip'       => esc_html__( 'Change button text color.', 'wc-wws' ),
                    )
                );

                // Button Label
                $field->add('text',
                    array(
                        'label'         => esc_html__('Button Label', 'wc-wws'),
                        'name'          => 'wws_product_query_settings[btn_label]',
                        'value'         => esc_html( $wws_product_query_settings['btn_label'] ),
                        'tooltip'       => esc_html__('Enter button label.', 'wc-wws'),
                    )
                );

                // Support Contact Number
                $field->add('number',
                    array(
                        'label'         => esc_html__('Support Contact Number', 'wc-wws'),
                        'name'          => 'wws_product_query_settings[support_number]',
                        'value'         => esc_html( $wws_product_query_settings['support_number'] ),
                        'tooltip'       => esc_html__( 'Enter mobile phone number with the international country code, without + character. Example:  911234567890 for (+91) 1234567890', 'wc-wws'),
                        'step'          => '1',
                    )
                );

                // Support Person Name
                $field->add('text',
                    array(
                        'label'         => esc_html__('Support Person Name', 'wc-wws'),
                        'name'          => 'wws_product_query_settings[support_person_name]',
                        'value'         => esc_html( $wws_product_query_settings['support_person_name'] ),
                        'tooltip'       => esc_html__('Enter the name of support person.', 'wc-wws'),
                    )
                );

                // Support Person Title
                $field->add('text',
                    array(
                        'label'         => esc_html__('Support Person Title', 'wc-wws'),
                        'name'          => 'wws_product_query_settings[support_person_title]',
                        'value'         => esc_html( $wws_product_query_settings['support_person_title'] ),
                        'tooltip'       => esc_html__('Enter the title / designation of support person.', 'wc-wws'),
                    )
                );

                // Support Person Image
                $field->add('file',
                    array(
                        'label'         => esc_html__('Support Person Image', 'wc-wws'),
                        'id'            => 'wws-support-person-image',
                        'name'          => 'wws_product_query_settings[support_person_img]',
                        'value'         => esc_url( $wws_product_query_settings['support_person_img'] ),
                        'tooltip'       => esc_html__('Upload support person image.', 'wc-wws'),
                    )
                );

                // Pre Populated Message
                $field->add('textarea',
                    array(
                        'label'         => esc_html__('Pre Populated Message', 'wc-wws'),
                        'name'          => 'wws_product_query_settings[support_pre_message]',
                        'value'         => esc_html( $wws_product_query_settings['support_pre_message'] ),
                        'desc'          => wp_kses_post( sprintf( __( 'Use %s shortcode for product title and %s for product URL', 'wc-wws'), '<code>{title}</code>', '<code>{url}</code>' ) ),
                    )
                );


            ?>

        </tbody>

    </table>

    <hr>

    <table class="form-table">

        <tbody>

        <!--   -->
        <tr>
            <th scope="row">
                <label><?php esc_html_e('Exclude Query Button', 'wc-wws') ?></label>
                <span class="dashicons dashicons-info wecreativez-admin-tooltip" data-tippy-content="<?php esc_html_e( 'You can exclude or turn off WhatsApp product query button by products.', 'wc-wws' ) ?>"></span>
            </th>
            <td>
                <p><?php esc_html_e( 'Exclude by products', 'wc-wws' ) ?></p>
                <?php
                    $args = array(
                        'multiple'  => true,
                        'name'      => 'wws_product_query_settings[exclude_by_products][]',
                        'selected'  => $wws_product_query_settings['exclude_by_products'],
                    );
                    wws_products_dropdown( $args );
                ?>
            </td>
        </tr><!-- .  -->

        <!--   -->
        <tr>
            <th scope="row">
                <span class="dashicons dashicons-info wecreativez-admin-tooltip" data-tippy-content="<?php esc_html_e( 'You can exclude or turn off WhatsApp product query button by categories.', 'wc-wws' ) ?>"></span>
            </th>
            <td>
                <p><?php esc_html_e( 'Exclude by categories', 'wc-wws' ) ?></p>
                <?php
                    $args = array(
                        'multiple'  => true,
                        'name'      => 'wws_product_query_settings[exclude_by_categories][]',
                        'selected'  => $wws_product_query_settings['exclude_by_categories'],
                    );
                    wws_categories_dropdown( $args );
                ?>
            </td>
        </tr><!-- .  -->

        </tbody>

    </table>

    <?php submit_button( esc_html__( 'Save Changes', 'wc-wws' ), 'primary', 'wws_product_query_settings_submit' ) ?>        

</form>