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
    add_action( 'admin_enqueue_scripts', array($this, 'wak_admin_styles') );
    add_action( 'wp_ajax_wak_generate_secret', array( $this, 'wak_generate_secret' ) );

    include_once(WAK_PLUGIN_DIR.'/inc/admin/settings/wak-settings-class.php');
    include(WAK_PLUGIN_DIR.'/inc/admin/settings/wak-settings-general.php');
    include(WAK_PLUGIN_DIR.'/inc/admin/class-wak-welcome-page.php');
  }

  /**
   * Enqueue admin styles
   */
  function wak_admin_styles() {
    wp_register_style( 'wak_admin_styles', WAK_PLUGIN_DIR_URL . '/assets/css/wak-admin-styles.css', false, '1.0.0' );
    wp_enqueue_style( 'wak_admin_styles' );

    wp_enqueue_script( 'wak_admin_js', WAK_PLUGIN_DIR_URL . '/assets/js/wak-admin.js', array('jquery') );
    wp_localize_script( 'wak_admin_js', 'ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
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

  /**
   * AJAX: Generate random secret
   */
  function wak_generate_secret() {
    $functions = new WAK_Functions();

    echo $functions->create_secret();

    die();
  }

}

return new JWT_Admin();


?>
