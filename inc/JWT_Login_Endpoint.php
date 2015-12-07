<?php

class JWT_Login_Endpoint {

  function __construct() {
    add_action( 'rest_api_init', array($this, 'register'));
  }

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

  function action(WP_REST_Request $request) {

    $username = $request['username'];
    $password = $request['password'];

    $jwt_functions = new JWT_Functions();

    $token = $jwt_functions->create_token($username, $password);

    return $token;

  }

}
$jwt_login_endpoint = new JWT_Login_Endpoint();

?>
