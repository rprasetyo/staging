<div id="wws-layout-4" class="wws-popup-container wws-popup-container--position">

    <input type="hidden" class="wws-popup__input" value="<?php echo esc_html( $this->_get_setting('text_welcome_msg') ) ?>">

    <!-- .Popup footer -->
    <div class="wws-popup__footer">

        <!-- Popup open button -->
        <div class="wws-popup__open-btn wws-popup__send-btn wws-shadow wws--text-color wws--bg-color">
            <i class="wc-fa wc-fa-whatsapp wws-popup__open-icon" aria-hidden="true"></i> <span><?php echo esc_html( $this->_get_setting('text_trigger_btn') ) ?></span>
        </div>
        <div class="wws-clearfix"></div>
        <!-- .Popup open button -->

    </div>
    <!-- Popup footer -->

</div>
