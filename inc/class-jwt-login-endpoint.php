<?php

/**
 * Rest-API-Endpoint to receive a token.
 *
 * This endpoint needs a username and password and returns a token.
 *
 * @since 4.3.0
 * @access public
 *
 */

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
        'methods' => 'POST',
        'callback' => array($this, 'action'),
        'args' => array(
          'username' => array(
            'required' => true
          ),
          'password' => array(
            'required' => true
          ),
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

    $username = $request['username'];
    $password = $request['password'];

    $jwt_functions = new JWT_Functions();

    $token = $jwt_functions->create_token( $username, $password );

    return $token;

  }

}
$jwt_login_endpoint = new JWT_Login_Endpoint();

?>
