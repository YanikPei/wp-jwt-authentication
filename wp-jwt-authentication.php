<?php

/*
 * Plugin Name: WP-JSON-Web-Token Authentication
 * Description: This plugin creates endpoints for wp-rest-api (v2) in order to use JSON-Web-Token as an authentication-method.
 * Version:     0.0.1
 * Author:      Yanik Peiffer
*/

defined( 'ABSPATH' ) or die( 'No!' );

define( 'WP_JWT_PLUGIN_DIR', plugin_dir_path(__FILE__) );
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
   * @since 4.3.0
   *
   * @return void
   */
  function load_classes() {

    require_once WP_JWT_PLUGIN_DIR.'config.php';

    /**
      * Require jwt-functions to use them in this plugin.
    */
    require_once WP_JWT_PLUGIN_DIR.'inc/class-jwt-functions.php';

    /**
      * Require jwt-login-endpoint to register endpoint.
    */
    require_once WP_JWT_PLUGIN_DIR.'inc/class-jwt-login-endpoint.php';
  }

  /**
   * Add wp-hooks.
   *
   * @since 4.3.0
   *
   * @return void
   */
  function add_hooks() {
    add_filter( 'determine_current_user', array($this, 'rest_jwt_auth_handler'), 20 );
  }

  /**
   * Add jwt-validation to wp-authorization.
   *
   * Uses 'validate_token' in order to validate the token from the current request.
   *
   * @since 4.3.0
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
