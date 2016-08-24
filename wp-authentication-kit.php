<?php
/*
Plugin Name: WordPress Authentication Kit
Description: Login to WordPress and WP-Rest-API via social networks.
Version:     2.0.0
Author:      Yanik Peiffer
Text Domain: wp_authentication_kit
Domain Path: /languages/
*/

defined( 'ABSPATH' ) or die( 'No!' );

define( 'WAK_PLUGIN_DIR', plugin_dir_path(__FILE__) );
define( 'WAK_PLUGIN_DIR_URL', plugin_dir_url(__FILE__) );
define( 'WAK_JWT_ENDPOINT_NAMESPACE', 'wp-jwt/v1' );

/**
  * Require composer autoload to load necessary classes.
*/
if (!file_exists(WAK_PLUGIN_DIR . '/vendor/autoload.php')) {
  throw new Error('Please execute `composer install` in ' . WAK_PLUGIN_DIR . ' and try again! | ');
} else {
  require_once WAK_PLUGIN_DIR . '/vendor/autoload.php';
}

class WP_Authentication_Kit {

  public function __construct() {
    $this->add_hooks();
    $this->load_classes();
  }

  /**
   * Load all classes.
   *
   * @since 0.0.1
   *
   * @return void
   */
  function load_classes() {

    /**
      * Require jwt-functions to use them in this plugin.
    */
    require_once WAK_PLUGIN_DIR.'inc/class-wak-functions.php';

    /**
    * Require jwt-admin if user is in backend
    */
    if( is_admin() ) {
      require_once WAK_PLUGIN_DIR.'inc/class-wak-admin.php';
    }

    /**
      * Require jwt-login-endpoint to register endpoint.
    */
    require_once WAK_PLUGIN_DIR.'inc/class-wak-login-endpoint.php';
  }

  /**
   * Add wp-hooks.
   *
   * @since 0.0.1
   *
   * @return void
   */
  function add_hooks() {
    add_filter( 'determine_current_user', array($this, 'rest_jwt_auth_handler'), 20 );
    add_action( 'init', array($this, 'load_textdomain') );

    if( empty(get_option('jwt_secret')) ) {
      add_action( 'admin_notices', array($this, 'required_jwt_secret') );
    }
  }

  /**
  * Load textdomain
  */
  function load_textdomain() {
    $domain = 'wp_jwt_auth';
    $locale = apply_filters('plugin_locale', get_locale(), $domain);

    load_textdomain($domain, WP_LANG_DIR.'/wp-jwt-authentication/'.$domain.'-'.$locale.'.mo');
    load_plugin_textdomain($domain, FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
  }

  /**
  * Show error if no secret is set
  *
  * @since 1.1.0
  */
  function required_jwt_secret() {
    $class = 'notice notice-error';
  	$message = __( 'In order to use JWT for the Rest-API you have to set a <strong>secret</strong>. <a href="/wp-admin/options-general.php?page=jwt_admin_page&tab=general">Go to settings</a>', 'wp_jwt_auth' );

  	printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
  }

  /**
   * Add jwt-validation to wp-authorization.
   *
   * Uses 'validate_token' in order to validate the token from the current request.
   *
   * @since 0.0.1
   *
   * @param string $user The user from current authorization.
   * @return int Logged in user id.
   */
  function rest_jwt_auth_handler($user) {
    $jwt_functions = new WAK_Functions();

    $jwt_return = $jwt_functions->validate_token();

    if( ! $jwt_return ) {
      return $user;
    }

    return $jwt_return;
  }

}

if( class_exists( 'WP_Authentication_Kit' ) ) {
    $wp_authentication_kit = new WP_Authentication_Kit();
}

?>
