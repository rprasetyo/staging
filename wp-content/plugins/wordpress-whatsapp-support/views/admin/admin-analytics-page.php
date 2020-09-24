<?php add_thickbox(); ?>

<div class="wrap">

    <h1><?php esc_html_e( 'WeCreativez WhatsApp Support - Analytics', 'wc-wws' ) ?></h1>

    <?php do_action( 'wws_admin_notifications' ); ?>
    
    <hr>

    <h3><?php esc_html_e( 'Total Clicks Analytics', 'wc-wws' ) ?></h3>

    <div class="flex-grid flex-grid-3">
        <div class="col">
            <div class="wecreativez-card filled">
                <h1><?php echo esc_html( $total_clicks ) ?></h1>
                <p><i class="wc-fa wc-fa-mouse-pointer"></i> <?php echo esc_html_e( 'Total Clicks', 'wc-wws' ) ?></p>
            </div>
        </div>
        <div class="col">
            <div class="wecreativez-card filled">
                <h1><?php echo esc_html( $total_clicks_by_desktop ) ?></h1>
                <p><i class="wc-fa wc-fa-desktop"></i> <?php echo esc_html_e( 'Total Clicks By Desktop/ Laptop', 'wc-wws' ) ?></p>
            </div>
        </div>
        <div class="col">
            <div class="wecreativez-card filled">
                <h1><?php echo esc_html( $total_clicks_by_mobile ) ?></h1>
                <p><i class="wc-fa wc-fa-mobile"></i> <?php echo esc_html_e( 'Total Clicks By Mobile', 'wc-wws' ) ?></p>
            </div>
        </div>
    </div>

    <hr>

    <h3><?php esc_html_e( 'Complete Analytics', 'wc-wws' ); ?></h3>

    <table class="wp-list-table widefat fixed striped wws-admin-datatable">
        <thead>
            <tr>
                <th>#</th>
                <th><?php esc_html_e( 'Visitors IP', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'Number', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'Message', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'Referral', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'Device Type', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'OS', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'Browser', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'Date', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'Action', 'wc-wws' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sr = 1;
                foreach ( $analytics as $v ) :
            ?>
                <tr>
                    <td><?php echo $sr ?></td>
                    <td><?php echo esc_html( $v['visitor_ip'] ) ?></td>
                    <td><?php echo esc_html( $v['number'] ) ?></td>
                    <td><?php echo esc_html( $v['message'] ) ?></td>
                    <td><a href="<?php echo esc_url( $v['referral'] ) ?>"><?php echo esc_url( $v['referral'] ) ?></a></td>
                    <td><?php echo esc_html( $v['device_type'] ) ?></td>
                    <td><?php echo esc_html( $v['os'] ) ?></td>
                    <td><?php echo esc_html( $v['browser'] ) ?></td>
                    <td><?php echo esc_html( $v['date'] ) ?></td>
                    <td>
                        <i class="button button-primary wc-fa wc-fa-eye" data-ip="<?php echo esc_html( $v['visitor_ip'] ) ?>"></i>
                        <a href="?wws_delete_analytics=<?php echo intval( $v['id'] ) ?>" class="wecreativez-btn-delete"><i class="wc-fa wc-fa-trash"></i></a>
                    </td>
                </tr>
            <?php
                $sr++;
                endforeach;
            ?>
            
        </tbody>
        <tfoot>
            <tr>
                <th>#</th>
                <th><?php esc_html_e( 'Visitors IP', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'Number', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'Message', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'Referral', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'Device Type', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'OS', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'Browser', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'Date', 'wc-wws' ); ?></th>
                <th><?php esc_html_e( 'Action', 'wc-wws' ); ?></th>
            </tr>
        </tfoot>
    </table>

    <hr>

    <div class="wecreativez-clearfix">
        
        <a href="?wws_delete_complete_analytics=1" class="wecreativez-btn-delete right" onclick="return confirm('<?php esc_html_e( 'Are you sure?', 'wc-wws' ) ?>')">
            <i class="wc-fa wc-fa-trash"></i> <?php esc_html_e( 'Delete Complete Analytics', 'wc-wws' ) ?>
        </a>

    </div>

    <hr>

    <div>
        
        <p><?php  wp_kses_post( _e( '<strong>N/A</strong> means not applicable for the selected layout.', 'wc-wws' ) )?></p>

    </div>

</div>