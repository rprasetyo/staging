<div id="wws-layout-7" class="wws-popup-container wws-popup-container--position">

    <?php if ( $this->_get_setting( 'ui_layout_gradient' ) == '1' ) : ?>
        <div class="wws-gradient wws-gradient--position"></div>
    <?php endif; ?>

    <!-- Popup -->
    <div class="wws-popup" data-wws-popup-status="0">

        <!-- Popup header -->
        <div class="wws-popup__header">

            <!-- Popup close button -->
            <div class="wws-popup__close-btn wws--text-color wws--bg-color wws-shadow">
                <i class="wc-fa wc-fa-close wws-popup__close-icon" aria-hidden="true"></i>
            </div>
            <div class="wws-clearfix"></div>
            <!-- .Popup close button -->

        </div>
        <!-- .Popup header -->

        <!-- Popup body -->
        <div class="wws-popup__body">

            <!-- Popup support -->
            <div class="wws-popup__support-wrapper">
                <div class="wws-popup__support wws-shadow">
                    <div class="wws-popup__support-about wws--text-color wws--bg-color">
                        <div class="wws-popup__support-img-wrapper">
                            <?php if ( $this->_get_setting('ui_support_person_img') == NULL ) : ?>
                                <img class="wws-popup__support-img" src="<?php echo esc_url( WWS_URL . 'assets/img/user.svg' ); ?>" alt="WeCreativez WhatsApp Support" width="50" height="50">
                            <?php else: ?>
                                <img class="wws-popup__support-img" src="<?php echo esc_url( $this->_get_setting( 'ui_support_person_img' ) ) ?>" alt="WeCreativez WhatsApp Support" width="50" height="50">
                            <?php endif; ?>
                        </div>
                        <?php echo esc_html( $this->_get_setting( 'text_about_support' ) ) ?>
                    </div>
                    <div class="wws-popup__fields_wrapper">

                        <div class="wws-popup__support-welcome">
                            <?php echo esc_html( $this->_get_setting( 'text_welcome_msg' ) ) ?>
                        </div>

                        <div class="wws-popup__fields">
                            
                            <input type="tel" class="wws-popup__fields-number" placeholder="<?php echo esc_attr( $this->_get_setting( 'text_number_placeholder' ) ) ?>">
                            
                            <div class="wws-popup__fields-textarea-wrapper">
                                
                                <textarea name="" class="wws-popup__input wws-popup__fields-textarea" placeholder="<?php echo esc_attr( $this->_get_setting('text_input_placeholder') ) ?>"></textarea>
                                
                                <svg class="wws-popup__send-btn" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 40 40" style="enable-background:new 0 0 40 40;" xml:space="preserve">
                                    <style type="text/css">
                                        .wws-lau00001{fill:<?php echo esc_html( $this->_get_setting('ui_layout_bg_color') ) ?>80;}
                                        .wws-lau00002{fill:<?php echo esc_html( $this->_get_setting('ui_layout_bg_color') ) ?>;}
                                    </style>
                                    <path id="path0_fill" class="wws-lau00001" d="M38.9,19.8H7.5L2,39L38.9,19.8z"></path>
                                    <path id="path0_fill_1_" class="wws-lau00002" d="M38.9,19.8H7.5L2,0.7L38.9,19.8z"></path>
                                </svg>

                                <div class="wws-clearfix"></div>

                            </div>

                        </div>

                    </div>
                    <?php do_action( 'wws_action_plugin' ) ?>
                </div>
            </div>
            <!-- Popup support -->

        </div>
        <!-- .Popup body -->

    </div>
    <!-- .Popup -->
    
    <div class="wws-clearfix"></div>

    <!-- .Popup footer -->
    <div class="wws-popup__footer">

        <!-- Popup open button -->
        <div class="wws-popup__open-btn wws--text-color wws--bg-color wws-shadow">
            <i class="wc-fa wc-fa-whatsapp wws-popup__open-icon" aria-hidden="true"></i> <span><?php echo esc_html( $this->_get_setting('text_trigger_btn') ) ?></span>
        </div>
        <div class="wws-clearfix"></div>
        <!-- .Popup open button -->

    </div>
    <!-- Popup footer -->


</div>