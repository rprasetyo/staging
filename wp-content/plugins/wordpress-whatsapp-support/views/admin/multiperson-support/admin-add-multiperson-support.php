<form action="#" method="post">

    <table class="form-table">

        <tbody>

            <?php

                // Support Person Contact
                $field->add( 'number',
                    array(
                        'label'         => esc_html__( 'Support Person Contact', 'wc-wws' ),
                        'name'          => 'wws_multi_account[contact]',
                        'step'          => '1',
                        'desc'          => esc_html__( 'Enter mobile phone number with the international country code, without "+" character. Example:  911234567890 for (+91) 1234567890', 'wc-wws' ),
                    )
                );

                // Text
                $field->add( 'text',
                    array(
                        'label'         => esc_html__( 'Support Person Name', 'wc-wws'),
                        'name'          => 'wws_multi_account[name]',
                        'desc'          => esc_html__( $setting[$person_id]['name'], 'wc-wws' ),
                    )
                );

                // Support Person Title
                $field->add( 'text',
                    array(
                        'label'         => esc_html__( 'Support Person Title', 'wc-wws' ),
                        'name'          => 'wws_multi_account[title]',
                        'desc'          => esc_html__( 'Enter support person title/designation.', 'wc-wws' ),
                    )
                );

                // Support Person Image
                $field->add( 'file',
                    array(
                        'label'         => esc_html__( 'Support Person Image', 'wc-wws' ),
                        'id'            => 'wws-multiperson-edit-image',
                        'name'          => 'wws_multi_account[image]',
                        'desc'          => esc_html__( 'Add support person image', 'wc-wws' ),
                    )
                );

                // Predefined Text
                $field->add( 'textarea',
                    array(
                        'label'         => esc_html__( 'Support Pre Message', 'wc-wws'),
                        'name'          => 'wws_multi_account[pre_message]',
                        'value'         => '{br}' . PHP_EOL . 'Page Title: {title}{br}' . PHP_EOL . 'Page URL: {url}',
                        'desc'          => wp_kses_post( sprintf( __( '%s to display current page title in chat.<br>%s to display current page URL in chat.<br>%s to break the line into a new line.', 'wc-wws' ), '<code>{title}</code>', '<code>{url}</code>', '<code>{br}</code>' ) ),
                    )
                );


            ?>


            <!-- schedule -->
            <tr>
                <th scope="row">
                    <label><?php esc_html_e( 'Schedule', 'wc-wws' ) ?></label>
                </th>
                <td>
                    <?php 
                        wws_time_hours_dropdown(
                            array(
                                'name'      => 'wws_multi_account[start_hours]', 
                                'selected'  => '00',
                            )
                        ) 
                    ?>
                    :
                    <?php 
                        wws_time_minutes_dropdown(
                            array(
                                'name'      => 'wws_multi_account[start_minutes]', 
                                'selected'  => '00',
                            )
                         );
                    ?>
                    To
                    <?php 
                        wws_time_hours_dropdown(
                            array(
                                'name'      => 'wws_multi_account[end_hours]', 
                                'selected'  => '23',
                            )
                        ) 
                    ?>
                    :
                    <?php 
                        wws_time_minutes_dropdown(
                            array(
                                'name'      => 'wws_multi_account[end_minutes]', 
                                'selected'  => '59',
                            )
                        ) 
                    ?>    
                    <br>
                    <input type="checkbox" value="mon" name="wws_multi_account[mon]" checked="checked"> <?php esc_html_e( 'Monday', 'wc-wws' ) ?><br>
                    <input type="checkbox" value="tue" name="wws_multi_account[tue]" checked="checked"> <?php esc_html_e( 'Tuesday', 'wc-wws' ) ?><br>
                    <input type="checkbox" value="wed" name="wws_multi_account[wed]" checked="checked"> <?php esc_html_e( 'Wednesday', 'wc-wws' ) ?><br>
                    <input type="checkbox" value="thu" name="wws_multi_account[thu]" checked="checked"> <?php esc_html_e( 'Thursday', 'wc-wws' ) ?><br>
                    <input type="checkbox" value="fri" name="wws_multi_account[fri]" checked="checked"> <?php esc_html_e( 'Friday', 'wc-wws' ) ?><br>
                    <input type="checkbox" value="sat" name="wws_multi_account[sat]" checked="checked"> <?php esc_html_e( 'Saturday', 'wc-wws' ) ?><br>
                    <input type="checkbox" value="sun" name="wws_multi_account[sun]" checked="checked"> <?php esc_html_e( 'Sunday', 'wc-wws' ) ?><br>
                    <span class="description"><?php esc_html_e( 'Schedule by days to show contact person availablity. Time format HH:MM', 'wc-wws' ) ?></span>
                </td>
            </tr><!-- .schedule -->

        </tbody>

    </table>

    <hr>

    <!-- submit button -->
    <p class="submit">
        <input type="submit" value="<?php esc_html_e( 'Save Changes', 'wc-wws' ) ?>" class="button-primary" name="wws_add_multi_account_submit" style="float: right;">
    </p><!-- end submit button -->

</form>