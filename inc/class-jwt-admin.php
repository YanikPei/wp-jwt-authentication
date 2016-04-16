<?php

class JWT_Admin {

  /**
  * Constructor
  */
  public function __construct() {
    add_action( 'admin_menu', array($this, 'jwt_register_admin_page') );
    add_action( 'admin_init', array($this, 'jwt_register_settings') );

    include_once(WP_JWT_PLUGIN_DIR.'/inc/admin/settings/jwt-settings-class.php');
    include(WP_JWT_PLUGIN_DIR.'/inc/admin/settings/jwt-settings-general.php');
  }

  function jwt_register_admin_page() {
    add_options_page( 'JWT', 'JWT', 'manage_options', 'jwt_admin_page', array($this, 'jwt_admin_page')  );
  }

  function jwt_register_settings() {
    do_action('jwt_register_settings');
  }

  function jwt_admin_page() {

    $current_tab = empty( $_GET['tab'] ) ? 'general' : sanitize_title( $_GET['tab'] );
    $tabs = apply_filters( 'jwt_settings_tabs_array', array() );

    include ('admin/views/jwt-admin-page.php');
  }

}

return new JWT_Admin();


?>
