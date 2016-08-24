<?php

/**
 * Functions to work with JWT.
 *
 * These functions make it easier to work with JSON Web Tokens.
 *
 * @since 0.0.1
 * @access public
 *
 */

use Firebase\JWT\JWT;
use Zend\Http\PhpEnvironment\Request;

class WAK_Functions {

  /**
   * Create a token for a user.
   *
   * @since 0.0.1
   *
   * @return array|WP_Error Unencoded array with the token and expiration-timestamp
   *  when credentials are valid, error when they are invalid.
   */
  function create_token( $user_id ) {

    $expiration_time = (get_option('jwt_expiration_time')) ? intval(get_option('jwt_expiration_time')) : 86400;

    $tokenId    = base64_encode( mcrypt_create_iv(32) );
    $issuedAt   = time();
    $notBefore  = $issuedAt;
    $expire     = $notBefore + $expiration_time;
    $serverName = get_bloginfo('url');

    $data = [
        'iat'  => $issuedAt,
        'jti'  => $tokenId,
        'iss'  => $serverName,
        'nbf'  => $notBefore,
        'exp'  => $expire,
        'data' => [
            'userId'   => $user_id
        ]
    ];

    $secretKey = base64_decode( get_option('jwt_secret') );

    $jwt = JWT::encode(
      $data,
      $secretKey,
      'HS256'
    );

    $unencodedArray = ['jwt' => $jwt, 'expire' => $expire, 'userid' => $user_id];

    return $unencodedArray;
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

      if ( $authHeader ) {

        list( $jwt ) = sscanf( $authHeader->toString(), 'Authorization: Bearer %s' );

        if ( $jwt ) {
          try {

            $secretKey = base64_decode( get_option('jwt_secret') );

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
