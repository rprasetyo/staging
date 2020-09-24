<div class="flex-grid flex-grid-2">
    
    <div class="col">
        
        <div class="wecreativez-card">
            <h2><?php esc_html_e( 'Need Customization? Hire an Expert.', 'wc-wws' ) ?></h2>
            <p><?php esc_html_e( 'We know it’s not easy to find a reliable WordPress expert at a price you can afford. We have a hand-picked team of professional, reliable, experienced and FRIENDLY experts.', 'wc-wws' ) ?></p>
            <a href="<?php echo esc_url( '//wecreativez.com/hire-us/' ) ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'Hire Now', 'wc-wws' ) ?></a>
        </div>

    </div>
    <div class="col">
        
        <div class="wecreativez-card">
            <h2><?php esc_html_e( 'Customer Support.', 'wc-wws' ) ?></h2>
            <p><?php esc_html_e( 'If you need instant support then choose following options. Our support will reply as soon as possible after you send us a message.', 'wc-wws' ) ?></p>
            <p><i class="wc-fa wc-fa-envelope"></i> <a href="mailto:sonukaushalssk@gmail.com">sonukaushalssk@gmail.com</a></p>
            <p><i class="wc-fa wc-fa-link"></i> <a href="<?php echo esc_url( '//codecanyon.net/user/wecreativez' ) ?>" target="_blank"><?php esc_html_e( 'Contact us via Envato', 'wc-wws' ); ?></a></p>
        </div>

    </div>

</div>


<div class="flex-grid flex-grid-2">
    
    <div class="col">

        <?php do_action( 'wws_plugin_activation_form' ); ?>
        
    </div>
    <div class="col">
        <div class="wecreativez-card">
            <h2><?php esc_html_e( 'Share Debug Report With Our Support Team.', 'wc-wws' ) ?></h2>
            <p><?php esc_html_e( 'Generate, download, and share the debug report with our experts. Report contains site URL, WP version, list of activated plugins and plugin options setting.', 'wc-wws' ) ?></p>
            <p><i class="wc-fa wc-fa-envelope"></i> <a href="mailto:sonukaushalssk@gmail.com">sonukaushalssk@gmail.com</a></p>
            <p>
                <?php if ( ! isset( $_GET['debug_report_generated'] ) ) : ?>
                    <a href="?wws_generate_debug_report=1" class="button button-primary"><?php esc_html_e( 'Generate Now', 'wc-wws' ) ?></a>
                <?php else: ?>
                    <a href="<?php echo content_url( 'uploads/wws-debug-report/report.html' ) ?>" class="button button-primary" download><?php esc_html_e( 'Download Report', 'wc-wws' ) ?></a> <i class="wc-fa wc-fa-check"></i>
                <?php endif; ?>
            </p>
       </div>
    </div>

</div>