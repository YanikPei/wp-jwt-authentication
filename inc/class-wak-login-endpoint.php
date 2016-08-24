<?php

/**
 * Rest-API-Endpoint to receive a token.
 *
 * This endpoint handles the authentication and returns a jwt-token to access
 * API-functions.
 *
 * @since 0.0.1
 * @access public
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; 

define('JWT_SOCIAL_REDIRECT', get_bloginfo('url').'/wp-json/wp-jwt/v1/login');

class JWT_Login_Endpoint {

  function __construct() {
    add_action( 'rest_api_init', array($this, 'register') );

    require_once WAK_PLUGIN_DIR.'inc/social/WAK_Account_Kit_Login.php';
    require_once WAK_PLUGIN_DIR.'inc/social/WAK_Facebook_Login.php';
  }

  /**
   * Register the endpoint.
   *
   * Uses 'register_rest_route' to register the endpoint /wp-jwt/v1/login
   *
   * @since 4.3.0
   *
   * @return void
   */
  function register() {
    register_rest_route( WAK_JWT_ENDPOINT_NAMESPACE, '/login', array(
        'methods' => 'GET',
        'callback' => array($this, 'action'),
        'args' => array(

        )
    ) );
  }

  /**
   * Generates token.
   *
   * Uses 'create_token' to create a token.
   *
   * @since 4.3.0
   *
   * @param string $request The rest-api request that contains all parameters.
   * @return array The token and expiration-timestamp
   */
  function action(WP_REST_Request $request) {
    $return = new WP_Error('400', __('Authentication failed.', 'wp_jwt_auth'));

    if( isset($request['method']) ) { // if user wants to login by social-media-account

      $return = apply_filters('wak_login_method_'.$request['method'], $return, $request);

    } else { // if user wants to login by username/password
      $username = $request['username'];
      $password = $request['password'];

      $jwt_functions = new WAK_Functions();

      $user = get_user_by( 'login', $username );

      if ( $user && wp_check_password( $password, $user->data->user_pass, $user->ID ) ) {
        $return = $jwt_functions->create_token( $user->ID );
      } else {
        $return = new WP_Error( 'credentials_invalid', __( 'Username/Password combination is invalid', 'wp_jwt_auth' ) );
      }
    }

    if( isset($request['set_wp_cookie']) && $request['set_wp_cookie'] == 'true' && !is_wp_error($return) ) {
      wp_set_auth_cookie( $return['userid'], true );
    }

    if( isset($request['redirect_to']) && !is_wp_error($return) ) {
      $location = $request['redirect_to'];

      if( is_wp_error($return) ) {
        $location .= '?error=true&msg='.urlencode($return->get_error_message());
      }

      wp_redirect($location);
      exit;
      return;
    }

    return $return;

  }


}
$jwt_login_endpoint = new JWT_Login_Endpoint();

?>
