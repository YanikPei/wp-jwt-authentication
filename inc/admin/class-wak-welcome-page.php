<?php
/**
 * Created by PhpStorm.
 * User: yanik
 * Date: 24.08.16
 * Time: 21:31
 */

class WAK_Welcome_Page {
    
    public function __construct()
    {

        add_action( 'admin_init', array( $this, 'welcome_screen_do_activation_redirect' ) );
        add_action( 'admin_menu', array( $this, 'welcome_screen_pages' ) );
        add_action( 'admin_head', array( $this, 'welcome_screen_remove_menus' ) );
        
    }
    
    function welcome_screen_do_activation_redirect() {
        // Bail if no activation redirect
        if ( ! get_transient( '_welcome_screen_activation_redirect' ) ) {
            return;
        }

        // Delete the redirect transient
        delete_transient( '_welcome_screen_activation_redirect' );

        // Bail if activating from network, or bulk
        if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
            return;
        }

        // Redirect to bbPress about page
        wp_safe_redirect( add_query_arg( array( 'page' => 'welcome-screen-about' ), admin_url( 'index.php' ) ) );

    }

    function welcome_screen_pages() {
        add_dashboard_page(
            'Welcome To Welcome Screen',
            'Welcome To Welcome Screen',
            'read',
            'welcome-screen-about',
            array( $this, 'welcome_screen_content' )
        );
    }

    function welcome_screen_content() {
        include WAK_PLUGIN_DIR.'/inc/admin/views/wak-welcome-page-content.php';
    }

    function welcome_screen_remove_menus() {
        remove_submenu_page( 'index.php', 'welcome-screen-about' );
    }
    
}

return new WAK_Welcome_Page();