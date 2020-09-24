<div id="wws-layout-3" class="wws-popup-container wws-popup-container--position">

    <!-- Popup -->
    <div class="wws-popup" data-wws-popup-status="0">

        <!-- Popup header -->
        <div class="wws-popup__header">

            <!-- Popup close button -->
            <div class="wws-popup__close-btn wws--bg-color wws--text-color">
                <i class="wc-fa wc-fa-close wws-popup__close-icon" aria-hidden="true"></i>
            </div>
            <div class="wws-clearfix"></div>
            <!-- .Popup close button -->

        </div>
        <!-- .Popup header -->

        <!-- Popup body -->
        <div class="wws-popup__body">

            <!-- Popup support -->
            <div class="wws-popup__support-wrapper wws-shadow">
                <div class="wws-popup__support wws--bg-color wws--text-color">
                    <div class="wws-popup__support-about">
                        <div class="wws-popup__support-img-wrapper">
                            <?php if ( $this->_get_setting('ui_support_person_img') == NULL ) : ?>
                                <img class="wws-popup__support-img" src="<?php echo esc_url( WWS_URL . 'assets/img/user.svg' ); ?>" alt="WeCreativez WhatsApp Support" width="50" height="50">
                            <?php else: ?>
                                <img class="wws-popup__support-img" src="<?php echo esc_url( $this->_get_setting( 'ui_support_person_img' ) ); ?>" alt="WeCreativez WhatsApp Support" width="50" height="50">
                            <?php endif; ?>
                        </div>
                    <?php echo esc_html( $this->_get_setting( 'text_about_support' ) ) ?>
                    </div>
                </div>
            </div>
            <!-- Popup support -->

            <!-- Popup input -->
            <div class="wws-popup__input-wrapper wws-shadow">

                <?php do_action( 'wws_action_plugin' ) ?>

                <input type="text" class="wws-popup__input" placeholder="<?php echo esc_attr( $this->_get_setting('text_input_placeholder') ) ?>" autocomplete="off">
                <svg class="wws-popup__send-btn" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 40 40" style="enable-background:new 0 0 40 40;" xml:space="preserve">
                    <style type="text/css">
                        .wws-lau00001{fill:<?php echo esc_html( $this->_get_setting('ui_layout_bg_color') ) ?>80;}
                        .wws-lau00002{fill:<?php echo esc_html( $this->_get_setting('ui_layout_bg_color') ) ?>;}
                    </style>
                    <path id="path0_fill" class="wws-lau00001" d="M38.9,19.8H7.5L2,39L38.9,19.8z"></path>
                    <path id="path0_fill_1_" class="wws-lau00002" d="M38.9,19.8H7.5L2,0.7L38.9,19.8z"></path>
                </svg>
            </div>
            <div class="wws-clearfix"></div>
            <!-- .Popup input --> 

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