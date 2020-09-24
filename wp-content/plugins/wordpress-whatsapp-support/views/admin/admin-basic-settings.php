<form action="#" method="post" accept-charset="utf-8">

    <table class="form-table">
        
        <tbody>
            
            <?php

                // Offset From X Axis
                $field->add( 'number',
                    array(
                        'label'         => esc_html__( 'X-axis Offset', 'wc-wws' ),
                        'name'          => 'sk_wws_setting[wws_x_axis_offset]',
                        'value'         => intval( $sk_wws_setting['wws_x_axis_offset'] ),
                        'step'          => '1',
                        'min'           => '0',
                        'max'           => '200',
                        'field_size'    => 'small-text',
                        'desc'          => esc_html__( 'In px ( pixels ) only. Default 12px.', 'wc-wws' ),
                        'tooltip'       => esc_html__( 'Enter the value of x-axis ( horizontal ) widget spacing.', 'wc-wws' ),
                    )
                );

                // Offset From Y Axis
                $field->add( 'number',
                    array(
                        'label'         => esc_html__( 'Y-axis Offset', 'wc-wws' ),
                        'name'          => 'sk_wws_setting[wws_y_axis_offset]',
                        'value'         => intval( $sk_wws_setting['wws_y_axis_offset'] ),
                        'step'          => '1',
                        'min'           => '0',
                        'max'           => '200',
                        'field_size'    => 'small-text',
                        'desc'          => esc_html__( 'In px ( pixels ) only. Default 12px.', 'wc-wws' ),
                        'tooltip'       => esc_html__( 'Enter the value of y-axis ( vertical ) widget spacing.', 'wc-wws' ),
                    )
                );

            ?>

        </tbody>

    </table>

    <hr>

    <table class="form-table">
      
        <tbody>

            <!-- display on desktop -->
            <tr>
                <th scope="row">
                    <label><?php esc_html_e('Display On Desktop', 'wc-wws') ?></label>
                    <span class="dashicons dashicons-info wecreativez-admin-tooltip" data-tippy-content="<?php esc_html_e('Display on desktop/laptop', 'wc-wws') ?>"></span>
                </th>
                <td>
                    <select name="sk_wws_setting[wws_display_on_desktop]">
                        <option value="1" <?php selected( $sk_wws_setting['wws_display_on_desktop'], '1' ) ?>><?php esc_html_e('Yes', 'wc-wws') ?></option>
                        <option value="0" <?php selected( $sk_wws_setting['wws_display_on_desktop'], '0' ) ?>><?php esc_html_e('No', 'wc-wws') ?></option>
                    </select>
                    <select name="sk_wws_setting[wws_desktop_location]">
                        <option value="tl" <?php selected( $sk_wws_setting['wws_desktop_location'], 'tl' ) ?>><?php esc_html_e('Top Left', 'wc-wws') ?></option>
                        <option value="tc" <?php selected( $sk_wws_setting['wws_desktop_location'], 'tc' ) ?>><?php esc_html_e('Top Center', 'wc-wws') ?></option>
                        <option value="tr" <?php selected( $sk_wws_setting['wws_desktop_location'], 'tr' ) ?>><?php esc_html_e('Top Right', 'wc-wws') ?></option>
                        <option value="bl" <?php selected( $sk_wws_setting['wws_desktop_location'], 'bl' ) ?>><?php esc_html_e('Bottom Left', 'wc-wws') ?></option>
                        <option value="bc" <?php selected( $sk_wws_setting['wws_desktop_location'], 'bc' ) ?>><?php esc_html_e('Bottom Center', 'wc-wws') ?></option>
                        <option value="br" <?php selected( $sk_wws_setting['wws_desktop_location'], 'br' ) ?>><?php esc_html_e('Bottom Right', 'wc-wws') ?></option>
                    </select>
                </td>
            </tr><!-- .display on desktop -->


            <!-- display on mobile -->
            <tr>
                <th scope="row">
                    <label><?php esc_html_e('Display On Mobile', 'wc-wws') ?></label>
                    <span class="dashicons dashicons-info wecreativez-admin-tooltip" data-tippy-content="<?php esc_html_e('Display on mobile devices', 'wc-wws') ?>"></span>
                </th>
                <td>
                    <select name="sk_wws_setting[wws_display_on_mobile]">
                        <option value="1" <?php selected( $sk_wws_setting['wws_display_on_mobile'], '1' ) ?>><?php esc_html_e('Yes', 'wc-wws') ?></option>
                        <option value="0" <?php selected( $sk_wws_setting['wws_display_on_mobile'], '0' ) ?>><?php esc_html_e('No', 'wc-wws') ?></option>
                    </select>
                    <select name="sk_wws_setting[wws_mobile_location]">
                        <option value="tl" <?php selected( $sk_wws_setting['wws_mobile_location'], 'tl' ) ?>><?php esc_html_e('Top Left', 'wc-wws') ?></option>
                        <option value="tc" <?php selected( $sk_wws_setting['wws_mobile_location'], 'tc' ) ?>><?php esc_html_e('Top Center', 'wc-wws') ?></option>
                        <option value="tr" <?php selected( $sk_wws_setting['wws_mobile_location'], 'tr' ) ?>><?php esc_html_e('Top Right', 'wc-wws') ?></option>
                        <option value="bl" <?php selected( $sk_wws_setting['wws_mobile_location'], 'bl' ) ?>><?php esc_html_e('Bottom Left', 'wc-wws') ?></option>
                        <option value="bc" <?php selected( $sk_wws_setting['wws_mobile_location'], 'bc' ) ?>><?php esc_html_e('Bottom Center', 'wc-wws') ?></option>
                        <option value="br" <?php selected( $sk_wws_setting['wws_mobile_location'], 'br' ) ?>><?php esc_html_e('Bottom Right', 'wc-wws') ?></option>
                    </select>
                </td>
            </tr><!-- .display on mobile -->


            <!-- auto popup -->
            <tr>
                <th scope="row">
                    <label><?php esc_html_e('Auto Popup', '') ?></label>
                    <span class="dashicons dashicons-info wecreativez-admin-tooltip" data-tippy-content="<?php esc_html_e('Enter the popup auto display time in seconds', 'wc-wws') ?>"></span>
                </th>
                <td>
                    <select name="sk_wws_setting[wws_auto_popup]">
                        <option <?php selected( $sk_wws_setting['wws_auto_popup'], '1' ) ?> value="1"><?php esc_html_e('Yes', 'wc-wws') ?></option>
                        <option <?php selected( $sk_wws_setting['wws_auto_popup'], '0' ) ?> value="0"><?php esc_html_e('No', 'wc-wws') ?></option>
                    </select>
                    <input type="number" class="small-text"  name="sk_wws_setting[wws_auto_popup_time]" value="<?php echo esc_html( $sk_wws_setting['wws_auto_popup_time'] ) ?>">
                </td>
            </tr><!-- .auto popup -->


            <?php

                // RTL
                $field->add('checkbox',
                    array(
                        'label'         => esc_html__( 'Enable RTL', 'wc-wws' ),
                        'name'          => 'sk_wws_setting[wws_rtl]',
                        'value'         => intval( $sk_wws_setting['wws_rtl'] ),
                        'checkbox_text' => esc_html__( 'Enable/ Disable', 'wc-wws' ),
                        'tooltip'       => esc_html__( 'You can enable RTL ( Right to Left ) if your website has language like Arabic, Persian and Hebrew.', 'wc-wws' ),
                    )
                );

                // Scroll Length
                $field->add('number',
                    array(
                        'label'         => esc_html__('Scroll Length', 'wc-wws'),
                        'name'          => 'sk_wws_setting[wws_scroll_length]',
                        'value'         => esc_html( $sk_wws_setting['wws_scroll_length'] ),
                        'step'          => '1',
                        'min'           => '0',
                        'max'           => '100',
                        'field_size'    => 'small-text',
                        'desc'          => esc_html__( 'Leave blank for display every time.', 'wc-wws' ),
                        'tooltip'       => esc_html__('Display button when scroll length matched with above value.', 'wc-wws'),
                    )
                );

            ?>

            <!-- filter by page -->
            <tr>
                <th scope="row">
                    <label><?php esc_html_e('Filter By Page', 'wc-wws') ?></label>
                </th>
                <td>
                    <p>
                        <label for="sk-wws__filter-by-page-1">
                            <input type="checkbox" id="sk-wws__filter-by-page-1" name="sk_wws_setting[wws_filter_by_page][by_everywhere]" <?php checked( $sk_wws_setting['wws_filter_by_page']['by_everywhere'], '1') ?>> <?php esc_html_e('Everwhere', 'wc-wws') ?>
                        </label>
                    </p>
                    <p>
                        <label for="sk-wws__filter-by-page-4">
                            <input type="checkbox" id="sk-wws__filter-by-page-4" name="sk_wws_setting[wws_filter_by_page][by_front_page]" <?php checked( $sk_wws_setting['wws_filter_by_page']['by_front_page'], '1') ?>>    <?php esc_html_e('Front Page', 'wc-wws') ?>
                        </label>
                    </p>
                    <p class="description"><?php esc_html_e('Include popup on Pages', 'wc-wws') ?></p>
                    <?php 
                        wws_admin_page_dropdown( array(
                            'multiple' => '1',
                            'name' => 'sk_wws_setting[wws_filter_by_page][by_slugs][]',
                            'selected' => (array)$sk_wws_setting['wws_filter_by_page']['by_slugs'],
                        ) );
                    ?>
                    <p class="description"><?php esc_html_e('Select pages, where you want to add WhatsApp Support.', 'wc-wws') ?></p><br>
                    <p class="description"><?php esc_html_e('Exclude popup on Pages', 'wc-wws') ?></p>
                    <?php 
                        wws_admin_page_dropdown( array(
                            'multiple' => '1',
                            'name' => 'sk_wws_setting[wws_filter_by_page][by_slugs_exclude][]',
                            'selected' => (array)$sk_wws_setting['wws_filter_by_page']['by_slugs_exclude'],
                        ) );
                    ?>
                    <p class="description"><?php esc_html_e('Select pages, where you not want to add WhatsApp Support.', 'wc-wws') ?></p>

                </td>
            </tr><!-- .filter by page -->


            <!-- schedule -->
            <tr>
                <th scope="row">
                    <label><?php esc_html_e('Schedule', 'wc-wws') ?></label>
                </th>
                <td>

                <table id="sk-wws__schedule-table">
                    <tr>
                        <td><input type="checkbox" name="sk_wws_setting[wws_schedule][mon][is_enable]" <?php checked( $sk_wws_setting['wws_schedule']['mon']['is_enable'], 1 ) ?>> <?php esc_html_e('Monday', 'wc-wws') ?></td>
                        <td><input type="text" name="sk_wws_setting[wws_schedule][mon][start]" class="wws-timepicker" value="<?php echo esc_html( $sk_wws_setting['wws_schedule']['mon']['start'] ); ?>"></td>
                        <td>-</td>
                        <td><input type="text" name="sk_wws_setting[wws_schedule][mon][end]" class="wws-timepicker" value="<?php echo esc_html( $sk_wws_setting['wws_schedule']['mon']['end'] ); ?>"></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="sk_wws_setting[wws_schedule][tue][is_enable]" <?php checked( $sk_wws_setting['wws_schedule']['tue']['is_enable'], 1 ) ?>> <?php esc_html_e('Tuesday', 'wc-wws') ?> </td>
                        <td><input type="text" name="sk_wws_setting[wws_schedule][tue][start]" class="wws-timepicker" value="<?php echo esc_html( $sk_wws_setting['wws_schedule']['tue']['start'] ); ?>"></td>
                        <td>-</td>
                        <td><input type="text" name="sk_wws_setting[wws_schedule][tue][end]"  class="wws-timepicker"  value="<?php echo esc_html( $sk_wws_setting['wws_schedule']['tue']['end'] ); ?>" ></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="sk_wws_setting[wws_schedule][wed][is_enable]" <?php checked( $sk_wws_setting['wws_schedule']['wed']['is_enable'], 1 ) ?>> <?php esc_html_e('Wednesday', 'wc-wws') ?> </td>
                        <td><input type="text" name="sk_wws_setting[wws_schedule][wed][start]" class="wws-timepicker" value="<?php echo esc_html( $sk_wws_setting['wws_schedule']['wed']['start'] ); ?>"></td>
                        <td>-</td>
                        <td><input type="text" name="sk_wws_setting[wws_schedule][wed][end]" class="wws-timepicker"  value="<?php echo esc_html( $sk_wws_setting['wws_schedule']['wed']['end'] ); ?>" ></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="sk_wws_setting[wws_schedule][thu][is_enable]" <?php checked( $sk_wws_setting['wws_schedule']['thu']['is_enable'], 1 ) ?>> <?php esc_html_e('Thursday', 'wc-wws') ?> </td>
                        <td><input type="text" name="sk_wws_setting[wws_schedule][thu][start]" class="wws-timepicker" value="<?php echo esc_html( $sk_wws_setting['wws_schedule']['thu']['start'] ); ?>"></td>
                        <td>-</td>
                        <td><input type="text" name="sk_wws_setting[wws_schedule][thu][end]" class="wws-timepicker"  value="<?php echo esc_html( $sk_wws_setting['wws_schedule']['thu']['end'] ); ?>" ></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="sk_wws_setting[wws_schedule][fri][is_enable]" <?php checked( $sk_wws_setting['wws_schedule']['fri']['is_enable'], 1 ) ?>> <?php esc_html_e('Friday', 'wc-wws') ?> </td>
                        <td><input type="text" name="sk_wws_setting[wws_schedule][fri][start]" class="wws-timepicker" value="<?php echo esc_html( $sk_wws_setting['wws_schedule']['fri']['start'] ); ?>"></td>
                        <td>-</td>
                        <td><input type="text" name="sk_wws_setting[wws_schedule][fri][end]" class="wws-timepicker"  value="<?php echo esc_html( $sk_wws_setting['wws_schedule']['fri']['end'] ); ?>" ></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="sk_wws_setting[wws_schedule][sat][is_enable]" <?php checked( $sk_wws_setting['wws_schedule']['sat']['is_enable'], 1 ) ?>> <?php esc_html_e('Saturday', 'wc-wws') ?> </td>
                        <td><input type="text" name="sk_wws_setting[wws_schedule][sat][start]" class="wws-timepicker" value="<?php echo esc_html( $sk_wws_setting['wws_schedule']['sat']['start'] ); ?>"></td>
                        <td>-</td>
                        <td><input type="text" name="sk_wws_setting[wws_schedule][sat][end]" class="wws-timepicker"  value="<?php echo esc_html( $sk_wws_setting['wws_schedule']['sat']['end'] ); ?>" ></td>
                        </tr>
                        <tr>
                        <td><input type="checkbox" name="sk_wws_setting[wws_schedule][sun][is_enable]" <?php checked( $sk_wws_setting['wws_schedule']['sun']['is_enable'], 1 ) ?>> <?php esc_html_e('Sunday', 'wc-wws') ?> </td>
                        <td><input type="text" name="sk_wws_setting[wws_schedule][sun][start]" class="wws-timepicker" value="<?php echo esc_html( $sk_wws_setting['wws_schedule']['sun']['start'] ); ?>"></td>
                        <td>-</td>
                        <td><input type="text" name="sk_wws_setting[wws_schedule][sun][end]" class="wws-timepicker" value="<?php echo esc_html( $sk_wws_setting['wws_schedule']['sun']['end'] ); ?>" ></td>
                    </tr>
                </table>
                <span class="description"><?php esc_html_e('Schedule by days to show WhatsApp Support Popup. Time format HH:MM:SS', 'wc-wws') ?></span><br>
                <span class="description">
                <?php 
                printf( __( 'Your selected time zone is %s', 'wc-wws' ), 
                '<a href="'.admin_url( 'options-general.php' ).'">' . wws_selected_timezone() . '</a>' );
                ?>
                </span>
                </td>
            </tr><!-- .schedule -->
            
            
            <!-- custom css -->
            <tr>
                <th scope="row">
                    <label><?php esc_html_e('Custom   CSS', 'wc-wws') ?></label>
                    <span class="dashicons dashicons-info wecreativez-admin-tooltip" data-tippy-content="<?php esc_html_e( 'Add your custom CSS here', 'wc-wws' ) ?>"></span>
                </th>
                <td>
                    <textarea name="sk_wws_setting[wws_custom_css]" class="regular-text" id="wws-admin__custom-css" cols="5" spellcheck="false"><?php echo esc_html( $sk_wws_setting['wws_custom_css'] ); ?></textarea>
                </td>
            </tr><!-- .custom css -->



        </tbody>

    </table>

    <a href="<?php echo esc_url( admin_url( 'admin.php?page=wc-whatsapp-support&tab=developer_settings' ) ) ?>"><?php esc_html_e( 'Developer settings', 'wc-wws' ) ?></a>

    <?php submit_button( esc_html__( 'Save Changes', 'wc-wws' ), 'primary', 'wws_basic_settings_submit' ) ?>

</form>