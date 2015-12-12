<?php

/**
 * Functions to work with JWT.
 *
 * These functions make it easier to work with JSON Web Tokens.
 *
 * @since 4.3.0
 * @access public
 *
 */

use Firebase\JWT\JWT;
use Zend\Http\PhpEnvironment\Request;

class JWT_Functions {

  /**
   * Create a token for a user.
   *
   * Checks the login-credentials and creates a json web token for this user.
   *
   * @since 4.3.0
   *
   * @param string $username The username of the current user.
   * @param string $password The password of the current user.
   * @return array|WP_Error Unencoded array with the token and expiration-timestamp
   *  when credentials are valid, error when they are invalid.
   */
  function create_token( $username, $password ) {

    $user = get_user_by( 'login', $username );

    if ( $user && wp_check_password( $password, $user->data->user_pass, $user->ID ) ) {

      $tokenId    = base64_encode( mcrypt_create_iv(32) );
      $issuedAt   = time();
      $notBefore  = $issuedAt + 10;
      $expire     = $notBefore + 86400;
      $serverName = get_bloginfo('url');

      /*
       * Create the token as an array
       */
      $data = [
          'iat'  => $issuedAt,         // Issued at: time when the token was generated
          'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
          'iss'  => $serverName,       // Issuer
          'nbf'  => $notBefore,        // Not before
          'exp'  => $expire,           // Expire
          'data' => [
              'userId'   => $user->ID,
              'userName' => $username,
          ]
      ];

      $secretKey = base64_decode( JWT_SECRET );

      $jwt = JWT::encode(
        $data,
        $secretKey,
        'HS256'
      );

      $unencodedArray = ['jwt' => $jwt, 'expire' => $expire];

      return $unencodedArray;
    } else {
      return new WP_Error( 'credentials_invalid', __( 'Username/Password combination is invalid', 'wp_jwt_authentication' ) );
    }
  }

  /**
   * Creates a random secret.
   *
   * @since 4.3.0
   *
   * @return string random secret.
   */
  function create_secret() {
    return base64_encode( openssl_random_pseudo_bytes(64) );
  }

  /**
   * Validates a token.
   *
   * Automatically validates a token when a request has an header with authorization.
   *
   * @since 4.3.0
   *
   * @return int|false user-id when token is valid, false when it is invalid.
   */
  function validate_token() {
    $request = new Request();

    if ( $request->isGet() || $request->isPost() ) {
      $authHeader = $request->getHeader( 'authorization' );

      /*
       * Look for the 'authorization' header
       */
      if ( $authHeader ) {
        /*
         * Extract the jwt from the Bearer
         */
        list( $jwt ) = sscanf( $authHeader->toString(), 'Authorization: Bearer %s' );

        if ( $jwt ) {
          try {
            /*
             * decode the jwt using the key from config
             */
            $secretKey = base64_decode( JWT_SECRET );

            $token = JWT::decode( $jwt, $secretKey, array('HS256') );

            return $token->data->userId;

          } catch ( Exception $e ) {
            // FALSE if token is invalid
            return false;
          }
        } else {
          //  FALSE if no token was passed
          return false;
        }
      }
    }

    return false;
  }

}

?>
