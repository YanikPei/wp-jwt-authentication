<?php

/*
 * Plugin Name: WP-JSON-Web-Token Authentication
 * Description: This plugin creates endpoints for wp-rest-api (v2) in order to use JSON-Web-Token as an authentication-method.
 * Version:     1.2.0
 * Author:      Yanik Peiffer
 * Text Domain: wp_jwt_auth
 * Domain Path: /languages/
*/

defined( 'ABSPATH' ) or die( 'No!' );

define( 'WP_JWT_PLUGIN_DIR', plugin_dir_path(__FILE__) );
define( 'WP_JWT_PLUGIN_DIR_URL', plugin_dir_url(__FILE__) );
define( 'WP_JWT_ENDPOINT_NAMESPACE', 'wp-jwt/v1' );

/**
  * Require composer autoload to load necessary classes.
*/
if (!file_exists(WP_JWT_PLUGIN_DIR . '/vendor/autoload.php')) {
  throw new Error('Please execute `composer install` in ' . WP_JWT_PLUGIN_DIR . ' and try again! | ');
} else {
  require_once WP_JWT_PLUGIN_DIR . '/vendor/autoload.php';
}

class WP_JWT_Authentication {

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
    require_once WP_JWT_PLUGIN_DIR.'inc/class-jwt-functions.php';

    /**
    * Require jwt-admin if user is in backend
    */
    if( is_admin() ) {
      require_once WP_JWT_PLUGIN_DIR.'inc/class-jwt-admin.php';
    }

    /**
      * Require jwt-login-endpoint to register endpoint.
    */
    require_once WP_JWT_PLUGIN_DIR.'inc/class-jwt-login-endpoint.php';
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
    // load_plugin_textdomain( 'wp_jwt_auth', false, WP_JWT_PLUGIN_DIR . '/languages' );

    $domain = 'wp_jwt_auth';
    // The "plugin_locale" filter is also used in load_plugin_textdomain()
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
    $jwt_functions = new JWT_Functions();

    $jwt_return = $jwt_functions->validate_token();

    if( ! $jwt_return ) {
      return $user;
    }

    return $jwt_return;
  }

}

if( class_exists( 'WP_JWT_Authentication' ) ) {
    $wp_jwt_auth = new WP_JWT_Authentication();
}

?>
