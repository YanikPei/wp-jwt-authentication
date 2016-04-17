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

define('JWT_SOCIAL_REDIRECT', get_bloginfo('url').'/wp-json/wp-jwt/v1/login');

class JWT_Login_Endpoint {

  function __construct() {
    add_action( 'rest_api_init', array($this, 'register') );
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
    register_rest_route( WP_JWT_ENDPOINT_NAMESPACE, '/login', array(
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
    $return = null;

    if( isset($request['method']) ) { // if user wants to login by social-media-account

      switch($request['method']) {
        case 'facebook':
          if( get_option('jwt_fb_active') ) {
            $return = $this->handle_facebook($request);
          } else {
            $return = new WP_Error('400', __('Authentication failed.', 'wp_jwt_authentication'));
          }

          break;
        case 'account_kit':
          if( get_option('jwt_account_kit_active') ) {
            $return = $this->handle_account_kit($request);
          } else {
            $return = new WP_Error('400', __('Authentication failed.', 'wp_jwt_authentication'));
          }

          break;
        default:
          $return = new WP_Error('400', __('Authentication failed.', 'wp_jwt_authentication'));
      }

    } else { // if user wants to login by username/password
      $username = $request['username'];
      $password = $request['password'];

      $jwt_functions = new JWT_Functions();

      $user = get_user_by( 'login', $username );

      if ( $user && wp_check_password( $password, $user->data->user_pass, $user->ID ) ) {
        $return = $jwt_functions->create_token( $user->ID );
      } else {
        return new WP_Error( 'credentials_invalid', __( 'Username/Password combination is invalid', 'wp_jwt_authentication' ) );
      }
    }

    return $return;

  }

  /**
  * Handles Facebook-authentication
  *
  * @param array $request:
  *   @type string $token Contains FB-token
  *   @type string $token Contains FB-token
  *
  * @return string|WP_Error returns token on authentication success
  */
  private function handle_facebook($request) {
    if( isset($request['error']) ) {
      return new WP_Error('gb_error', 'FB-Error: '.$request['error_description'].' ('.$request['error_reason'].')');
    }

    $token = null;
    $code = null;

    require_once WP_JWT_PLUGIN_DIR.'/inc/social/JWT_Facebook_Login.php';

    if( isset($request['token']) ) {
      $token = $request['token'];
    }
    if( isset($request['code']) ) {
      $code = $request['code'];
    }

    $facebook_login = new JWT_Facebook_Login($token, $code);

    return $facebook_login->create_jwt_token();
  }

  private function handle_account_kit($request) {

    if( !isset($request['token']) ) {
      return new WP_Error('token_missing', 'No token available');
    }

    require_once WP_JWT_PLUGIN_DIR.'/inc/social/JWT_Account_Kit_Login.php';

    $account_kit = new JWT_Account_Kit_Login($request['token']);

    return $account_kit->create_jwt_token();
  }

}
$jwt_login_endpoint = new JWT_Login_Endpoint();

?>
