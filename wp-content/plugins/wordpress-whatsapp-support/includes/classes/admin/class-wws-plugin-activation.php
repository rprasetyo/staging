<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );


class WWS_Plugin_Activation {

    public $message;

    public $response;

    public $plugin_admin_url;

    public $purchase_code;

    public function __construct() {

        $this->plugin_admin_url = admin_url( 'admin.php?page=wc-whatsapp-support' );
        $this->purchase_code    = get_option( 'sk_wws_license_key' );

        add_action( 'wws_plugin_activation_form', array( $this, 'plugin_activation_form' ) );

        add_action( 'admin_init', array( $this, 'plugin_activation' ) );
        add_action( 'admin_init', array( $this, 'plugin_deactivation' ) );

    }


    public function plugin_activation_form() {

        ?>
    
        <div class="wecreativez-card">
            <h2><?php esc_html_e( 'Activate Plugin', 'wc-wws' ) ?></h2>
            <p><?php echo wp_kses_post( __( 'Please enter your purchase code. Purchasing plugin license also grants access to premium support. <br>Use one license per domain please!', 'wc-wws') ) ?></p>

            <form action="#" method="post">
                <p>
                    <input type="text" class="regular-text" name="purchase_code" placeholder="<?php esc_attr_e( 'Enter Envato Purchase Code' ) ?>" value="<?php echo $this->purchase_code; ?>" required>

                    <?php if ( ! $this->purchase_code ) : ?>
                        <input type="submit" class="button button-primary" name="wws_plugin_activation_submit" value="<?php esc_attr_e( 'Activate', 'wc-wws' ) ?>">
                    <?php else: ?>
                        <a href="<?php echo esc_url( admin_url( 'admin.php?wws_plugin_deactivation=1' ) ) ?>" class="button button-secondary"><?php esc_attr_e( 'Deactivate', 'wc-wws' ) ?></a>
                    <?php  endif; ?>
                </p>
            </form>
            
            <?php if ( $this->message ) : ?>
                <p class="message"><?php echo $this->message; ?></p>
            <?php endif; ?>

            <p>
                <?php printf( wp_kses_post( __( '<a href="%s" target="_blank">Where is my purchase code?</a>', 'wc-wws' ) ), '//help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-' ) ?>
                    &#183;
                <?php printf( wp_kses_post( __( '<a href="%s">Need our help?</a>', 'wc-wws' ) ), admin_url( 'admin.php?page=wc-whatsapp-support-plugin-support' ) ) ?>
            </p>

        </div>


        <?php

    }


    public function plugin_activation() {

        if ( ! isset( $_POST['wws_plugin_activation_submit'] ) ) {
            return;
        }

        $license_key = trim( $_POST['purchase_code'] );

        $params = array(
            'body' => array(
                'license_user'  => site_url(),
                'license_key'   => $license_key,
            ),
        );

        // Make the POST request
        $request = wp_remote_post('http://envato.wecreativez.com/plugin-verification/whatsapp-support', $params);

        // Check if response is valid
        if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {

            $this->response = json_decode( $request['body'] );

            switch ( $this->response->code ) {

                case '100':
                        
                    update_option('sk_wws_license_key', $license_key);
                    wp_redirect( $this->plugin_admin_url );

                    break;

                case '200':
                    
                    $this->message = esc_html__( 'Invalid Purchase Code', 'wc-wws' );
                    update_option( 'sk_wws_license_key', '' );

                    break;

                case '210':

                    $this->message = esc_html__( 'Your key is blocked. Please contact us.', 'wc-wws' );

                    break;
                
                default:
                    
                    $this->message = sprintf( esc_html__( "Error Code: %s. Please contact us.", 'wc-wws' ), $this->response->code );

                    break;

            }
            
            
        } else {

            $this->message = esc_html__( 'Server error. Please contact us.', 'wc-wws' );

        }

    }


    public function plugin_deactivation() {

        if ( ! is_admin() ) {
            return;
        }

        if ( ! isset( $_GET['wws_plugin_deactivation'] ) ) {
            return;
        }

        update_option( 'sk_wws_license_key', '' );

        wp_redirect( $this->plugin_admin_url );

    }





} // end of class WWS_Plugin_Activation;

$wws_plugin_activation = new WWS_Plugin_Activation;