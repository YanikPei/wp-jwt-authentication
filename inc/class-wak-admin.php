<?php

/**
 * Handles admin stuff
 *
 * @since 1.1.0
 * @access public
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; 

class JWT_Admin {

  /**
  * Constructor
  */
  public function __construct() {
    add_action( 'admin_menu', array($this, 'wak_register_admin_page') );
    add_action( 'admin_init', array($this, 'wak_register_settings') );

    include_once(WAK_PLUGIN_DIR.'/inc/admin/settings/wak-settings-class.php');
    include(WAK_PLUGIN_DIR.'/inc/admin/settings/wak-settings-general.php');
  }

  /**
  * Register settings page
  */
  function wak_register_admin_page() {
    add_options_page( 'Authentication Kit', 'Authentication Kit', 'manage_options', 'wak_admin_page', array($this, 'wak_admin_page')  );
  }

  /**
  * Register settings
  */
  function wak_register_settings() {
    do_action('wak_register_settings');
  }

  /**
  * Admin page content
  */
  function wak_admin_page() {

    $current_tab = empty( $_GET['tab'] ) ? 'general' : sanitize_title( $_GET['tab'] );
    $tabs = apply_filters( 'wak_settings_tabs_array', array() );

    include('admin/views/wak-admin-page.php');
  }

}

return new JWT_Admin();


?>
