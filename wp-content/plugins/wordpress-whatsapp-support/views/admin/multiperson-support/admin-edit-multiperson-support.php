<form action="#" method="post">

    <table class="form-table">

        <tbody>

            <input type="hidden" name="wws_multi_account[key]" value="<?php echo intval( $person_id ) ?>">

            <?php

                // Support Person Contact
                $field->add( 'number',
                    array(
                        'label'         => esc_html__( 'Support Person Contact', 'wc-wws' ),
                        'name'          => 'wws_multi_account[contact]',
                        'value'         => esc_html( $setting[$person_id]['contact'] ),
                        'step'          => '1',
                        'desc'          => esc_html__( 'Enter mobile phone number with the international country code, without "+" character. Example:  911234567890 for (+91) 1234567890', 'wc-wws' ),
                    )
                );

                // Text
                $field->add( 'text',
                    array(
                        'label'         => esc_html__( 'Support Person Name', 'wc-wws'),
                        'name'          => 'wws_multi_account[name]',
                        'value'         => esc_html( $setting[$person_id]['name'] ),
                        'desc'          => esc_html__( $setting[$person_id]['name'], 'wc-wws' ),
                    )
                );

                // Support Person Title
                $field->add( 'text',
                    array(
                        'label'         => esc_html__( 'Support Person Title', 'wc-wws' ),
                        'name'          => 'wws_multi_account[title]',
                        'value'         => esc_html( $setting[$person_id]['title'] ),
                        'desc'          => esc_html__( 'Enter support person title/designation.', 'wc-wws' ),
                    )
                );

                // Support Person Image
                $field->add( 'file',
                    array(
                        'label'         => esc_html__( 'Support Person Image', 'wc-wws' ),
                        'id'            => 'wws-multiperson-edit-image',
                        'name'          => 'wws_multi_account[image]',
                        'value'         => esc_url( $setting[$person_id]['image'] ),
                        'desc'          => esc_html__( 'Add support person image', 'wc-wws' ),
                    )
                );

                // Predefined Text
                $field->add( 'textarea',
                    array(
                        'label'         => esc_html__( 'Support Pre Message', 'wc-wws'),
                        'name'          => 'wws_multi_account[pre_message]',
                        'value'         => esc_html( $setting[$person_id]['pre_message'] ),
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
                                'selected'  => esc_html( $setting[$person_id]['start_hours'] ),
                            )
                        ) 
                    ?>
                    :
                    <?php 
                        wws_time_minutes_dropdown(
                            array(
                                'name'      => 'wws_multi_account[start_minutes]', 
                                'selected'  => esc_html( $setting[$person_id]['start_minutes'] ),
                            )
                         );
                    ?>
                    To
                    <?php 
                        wws_time_hours_dropdown(
                            array(
                                'name'      => 'wws_multi_account[end_hours]', 
                                'selected'  => esc_html( $setting[$person_id]['end_hours'] ),
                            )
                        ) 
                    ?>
                    :
                    <?php 
                        wws_time_minutes_dropdown(
                            array(
                                'name'      => 'wws_multi_account[end_minutes]', 
                                'selected'  => esc_html( $setting[$person_id]['end_minutes'] ),
                            )
                        ) 
                    ?>    
                    <br>
                    <input type="checkbox" value="mon" name="wws_multi_account[mon]" <?php checked( 'mon', $setting[$person_id]['days']['0'], true ) ?>> <?php esc_html_e( 'Monday', 'wc-wws' ) ?><br>
                    <input type="checkbox" value="tue" name="wws_multi_account[tue]" <?php checked( 'tue', $setting[$person_id]['days']['1'], true ) ?>> <?php esc_html_e( 'Tuesday', 'wc-wws' ) ?><br>
                    <input type="checkbox" value="wed" name="wws_multi_account[wed]" <?php checked( 'wed', $setting[$person_id]['days']['2'], true ) ?>> <?php esc_html_e( 'Wednesday', 'wc-wws' ) ?><br>
                    <input type="checkbox" value="thu" name="wws_multi_account[thu]" <?php checked( 'thu', $setting[$person_id]['days']['3'], true ) ?>> <?php esc_html_e( 'Thursday', 'wc-wws' ) ?><br>
                    <input type="checkbox" value="fri" name="wws_multi_account[fri]" <?php checked( 'fri', $setting[$person_id]['days']['4'], true ) ?>> <?php esc_html_e( 'Friday', 'wc-wws' ) ?><br>
                    <input type="checkbox" value="sat" name="wws_multi_account[sat]" <?php checked( 'sat', $setting[$person_id]['days']['5'], true ) ?>> <?php esc_html_e( 'Saturday', 'wc-wws' ) ?><br>
                    <input type="checkbox" value="sun" name="wws_multi_account[sun]" <?php checked( 'sun', $setting[$person_id]['days']['6'], true ) ?>> <?php esc_html_e( 'Sunday', 'wc-wws' ) ?><br>
                    <span class="description"><?php esc_html_e( 'Schedule by days to show contact person availablity. Time format HH:MM', 'wc-wws' ) ?></span>
                </td>
            </tr><!-- .schedule -->

        </tbody>

    </table>

    <hr>

    <!-- submit button -->
    <p class="submit">
        <input type="submit" value="<?php esc_html_e( 'Save Changes', 'wc-wws' ) ?>" class="button-primary" name="wws_edit_multi_account_submit" style="float: right;">
    </p><!-- end submit button -->

</form>