<?php

/*
 * Plugin Name: WP-JSON-Web-Token Authentication
 * Description: This plugin creates endpoints for wp-rest-api (v2) in order to use JSON-Web-Token as an authentication-method.
 * Version:     0.0.1
 * Author:      Yanik Peiffer
*/

defined( 'ABSPATH' ) or die( 'No!' );

define('WP_JWT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_JWT_ENDPOINT_NAMESPACE', 'wp-jwt/v1');

class WP_JWT_Authentication {

  public function __construct() {
    $this->add_hooks();
    $this->load_classes();
  }

  /**
   * Load classes from ./inc/
   */
  function load_classes() {
    require_once WP_JWT_PLUGIN_DIR.'/vendor/autoload.php';
    require_once WP_JWT_PLUGIN_DIR.'/inc/JWT_Functions.php';
    require_once WP_JWT_PLUGIN_DIR.'/inc/JWT_Login_Endpoint.php';
  }

  /**
   * Register hooks
   */
  function add_hooks() {
    add_filter( 'determine_current_user', array($this, 'rest_jwt_auth_handler'), 20 );
  }

  function rest_jwt_auth_handler() {
    $jwt_functions = new JWT_Functions();

    return $jwt_functions->validate_token();
  }

}

if(class_exists('WP_JWT_Authentication')) {
    $wp_jwt_auth = new WP_JWT_Authentication();
}

?>
