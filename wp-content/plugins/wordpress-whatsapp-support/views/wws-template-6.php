<div id="wws-layout-6" class="wws-popup-container wws-popup-container--position">

    <?php if ( $this->_get_setting( 'ui_layout_gradient' ) == '1' ) : ?>
        <div class="wws-gradient wws-gradient--position"></div>
    <?php endif; ?>

    <!-- Popup -->
    <div class="wws-popup" data-wws-popup-status="0">

        <!-- Popup header -->
        <div class="wws-popup__header">

            <!-- Popup close button -->
            <div class="wws-popup__close-btn wws--bg-color wws--text-color wws-shadow">
                <i class="wc-fa wc-fa-close wws-popup__close-icon" aria-hidden="true"></i>
            </div>
            <div class="wws-clearfix"></div>
            <!-- .Popup close button -->

        </div>
        <!-- .Popup header -->

        <!-- Popup body -->
        <div class="wws-popup__body">

            <!-- Popup support -->
            <div class="wws-popup__support-wrapper  wws-shadow">
                <div class="wws-popup__support">
                    <div class="wws-popup__support-about wws--bg-color wws--text-color">
                        <?php echo esc_html( $this->_get_setting( 'text_about_support' ) ) ?>
                    </div>
                </div>
            </div>
            <div class="wws-clearfix"></div>
            <!-- .Popup support -->

            <!-- Popup support person -->
            <div class="wws-popup__support-person-container wws-shadow">

                <div class="wws-popup__support-person-wrapper">

                <?php 
                    
                    foreach ( (array)get_option( 'sk_wws_multi_account' ) as $m_account_id => $m_account) : 

                    $pre_message = str_replace(
                            array( '{title}', '{url}', '{br}' ), 
                            array( get_the_title(), get_permalink(), '%0A',
                        ), $m_account['pre_message']
                    );

                    $start_time = $m_account['start_hours'] . $m_account['start_minutes'];
                    $end_time   = $m_account['end_hours'] . $m_account['end_minutes'];

                    $wws_availablity = wws_multi_account_availablity( $m_account['days'], $start_time, $end_time );

                    if ( $wws_availablity == true ) {
                        
                ?>
                    <div class="wws-popup__support-person" data-wws-multi-support-person-id="<?php echo intval( $m_account_id ) ?>">
                        <div class="wws-popup__support-person-img-wrapper">

                            <?php if ( $m_account['image'] ) : ?>
                                <img class="wws-popup__support-person-img" src="<?php echo esc_url( $m_account['image'] ) ?>" alt="WeCreativez WhatsApp Support" width="54">
                            <?php else: ?>
                                <img class="wws-popup__support-person-img" src="<?php echo esc_url( WWS_URL . 'assets/img/user.svg' ); ?>" alt="WeCreativez WhatsApp Support" width="54">
                            <?php endif; ?>

                            <div class="wws-popup__support-person-available"></div>
                        </div>
                        <div class="wws-popup__support-person-info-wrapper">
                            <div class="wws-popup__support-person-title"><?php echo esc_html( $m_account['title'] ) ?></div>
                            <div class="wws-popup__support-person-name"><?php echo esc_html( $m_account['name'] ) ?></div>
                            <div class="wws-popup__support-person-status"><?php esc_html_e( 'Available', 'wc-wws' ) ?></div>
                        </div>
                    </div>
                <?php
                    } else { // not available
                ?>
                    <div class="wws-popup__support-person">
                        <div class="wws-popup__support-person-img-wrapper">
                            <?php if ( $m_account['image'] ) : ?>
                                <img class="wws-popup__support-person-img" src="<?php echo esc_url( $m_account['image'] ) ?>" alt="WeCreativez WhatsApp Support" width="54">
                            <?php else: ?>
                                <img class="wws-popup__support-person-img" src="<?php echo esc_url( WWS_URL . 'assets/img/user.svg' ); ?>" alt="WeCreativez WhatsApp Support" width="54">
                            <?php endif; ?>
                            <div class="wws-popup__support-person-away"></div>
                        </div>
                        <div class="wws-popup__support-person-info-wrapper">
                            <div class="wws-popup__support-person-title"><?php echo esc_html( $m_account['title'] ) ?></div>
                            <div class="wws-popup__support-person-name"><?php echo esc_html( $m_account['name'] ) ?></div>
                            <div class="wws-popup__support-person-status"><?php esc_html_e( 'Away', 'wc-wws' ) ?></div>
                        </div>
                    </div>
                <?php
                    }

                endforeach; ?>

            </div>
            
            <!-- Support person form -->
            <div class="wws-popup__support-person-form">

                
                
            </div>
            <!-- .Support person form -->

            </div>
            <!-- .Popup support person -->

        </div>
        <!-- .Popup body -->

    </div>
    <!-- .Popup -->

    <!-- .Popup footer -->
    <div class="wws-popup__footer">

        <!-- Popup open button -->
        <div class="wws-popup__open-btn wws--bg-color wws--text-color wws-shadow">
            <i class="wc-fa wc-fa-whatsapp wws-popup__open-icon" aria-hidden="true"></i> <span><?php echo esc_html( $this->_get_setting('text_trigger_btn') ) ?></span>
        </div>
        <div class="wws-clearfix"></div>
        <!-- .Popup open button -->

    </div>
    <!-- Popup footer -->

</div>