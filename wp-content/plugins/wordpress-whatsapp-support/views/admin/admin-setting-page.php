<div class="wrap">
    <h1><?php esc_html_e( 'WordPress WhatsApp Support', 'wc-wws' ); ?></h1>

    <?php do_action( 'wws_admin_notifications' ); ?>
    
    <hr>

    <?php 

        // Get WeCreativez admin feild settings
        $field = new Wecreativez_Core_Field;

        // get appearance and basic setting
        $sk_wws_setting = get_option( 'sk_wws_setting', array() );

        // Get product query saved settings
        $wws_product_query_settings = get_option( 'wws_product_query', array() );

        // Get Developer settings
        $wws_developer_settings = get_option( 'wws_developer_settings', array() );
        

        // Get current tab
        $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : '';

    ?>

    <h2 class="nav-tab-wrapper">

        <!-- Appearance Tab -->
        <a href="?page=wc-whatsapp-support" class="nav-tab <?php echo ( ! $tab ) ? 'nav-tab-active' : ''; ?>">
            <i class="wc-fa wc-fa-paint-brush"></i> <?php esc_html_e( 'Appearance', 'wc-wws')?>
        </a><!-- Appearance Tab -->

        <!-- Basic Settings Tab -->
        <a href="?page=wc-whatsapp-support&tab=basic_settings" class="nav-tab <?php echo ( $tab == 'basic_settings' ) ? 'nav-tab-active' : ''; ?>">
            <i class="wc-fa wc-fa-gear"></i> <?php esc_html_e( 'Basic Settings', 'wc-wws' )?>
        </a><!-- Basic Settings Tab -->

        <!-- Manage Support Persons Tab -->
        <a href="?page=wc-whatsapp-support&tab=manage_support_persons" class="nav-tab <?php echo ( $tab == 'manage_support_persons' ) ? 'nav-tab-active' : ''; ?>">
            <i class="wc-fa wc-fa-user"></i> <?php esc_html_e( 'Manage Support Persons', 'wc-wws' )?>
        </a><!-- Manage Support Persons Tab -->

        <!-- Button Generator Tab -->
        <a href="?page=wc-whatsapp-support&tab=button_generator" class="nav-tab <?php echo ( $tab == 'button_generator' ) ? 'nav-tab-active' : ''; ?>">
            <i class="wc-fa wc-fa-code"></i> <?php esc_html_e( 'Button Generator', 'wc-wws' )?>
        </a><!-- Button Generator Tab -->

        <!-- Link Generator Tab -->
        <a href="?page=wc-whatsapp-support&tab=link_generator" class="nav-tab <?php echo ( $tab == 'link_generator' ) ? 'nav-tab-active' : ''; ?>">
            <i class="wc-fa wc-fa-link"></i> <?php esc_html_e( 'Link Generator', 'wc-wws' )?>
        </a><!-- Link Generator Tab -->

        <!-- QR Code Generator Tab -->
        <a href="?page=wc-whatsapp-support&tab=qr_generator" class="nav-tab <?php echo ( $tab == 'qr_generator' ) ? 'nav-tab-active' : ''; ?>">
            <i class="wc-fa wc-fa-qrcode"></i> <?php esc_html_e( 'QR Generator', 'wc-wws' )?>
        </a><!-- QR Code Generator Tab -->

        <!-- Product Query Tab -->
        <a href="?page=wc-whatsapp-support&tab=product_query" class="nav-tab <?php echo ( $tab == 'product_query' ) ? 'nav-tab-active' : ''; ?>">
            <i class="wc-fa wc-fa-tag"></i> <?php esc_html_e( 'Product Query', 'wc-wws' )?>
        </a><!-- Product Query Tab -->

        <!-- Plugin Support Tab -->
        <a href="?page=wc-whatsapp-support&tab=plugin_support" class="nav-tab <?php echo ( $tab == 'plugin_support' ) ? 'nav-tab-active' : ''; ?>">
            <i class="wc-fa wc-fa-question"></i> <?php esc_html_e( 'Plugin Support', 'wc-wws' )?>
        </a><!-- Plugin Support Tab -->


    </h2>
    

    <?php

        if ( $_GET['page'] == 'wc-whatsapp-support' && ! $tab ) {
            require_once WWS_ABSPATH . 'views/admin/admin-appearance.php';
        }

        if ( $_GET['page'] == 'wc-whatsapp-support' && $tab == 'basic_settings' ) {
            require_once WWS_ABSPATH . 'views/admin/admin-basic-settings.php';
        }

        if ( $_GET['page'] == 'wc-whatsapp-support' && $tab == 'manage_support_persons' ) {
            require_once WWS_ABSPATH . 'views/admin/admin-manage-support-persons.php';
        }

        if ( $_GET['page'] == 'wc-whatsapp-support' && $tab == 'button_generator' ) {
            require_once WWS_ABSPATH . 'views/admin/admin-button-generator.php';
        }

        if ( $_GET['page'] == 'wc-whatsapp-support' && $tab == 'link_generator' ) {
            require_once WWS_ABSPATH . 'views/admin/admin-link-generator.php';
        }

        if ( $_GET['page'] == 'wc-whatsapp-support' && $tab == 'qr_generator' ) {
            require_once WWS_ABSPATH . 'views/admin/admin-qr-generator.php';
        }

        if ( $_GET['page'] == 'wc-whatsapp-support' && $tab == 'product_query' ) {
            require_once WWS_ABSPATH . 'views/admin/admin-product-query.php';
        }

        if ( $_GET['page'] == 'wc-whatsapp-support' && $tab == 'plugin_support' ) {
            require_once WWS_ABSPATH . 'views/admin/admin-plugin-support.php';
        }

        if ( $_GET['page'] == 'wc-whatsapp-support' && $tab == 'developer_settings' ) {
            require_once WWS_ABSPATH . 'views/admin/admin-developer-settingspage.php';
        }

    ?>

</div>