<?php

define('JWT_FACEBOOK_META_KEY', '_jwt_facebook_userid');

class JWT_Facebook_Login {
  private $token;
  private $code;
  private $user_id;
  private $access_token;

  function __construct($token = null, $code = null) {
    $this->token = $token;
    $this->code = $code;
  }

  public function create_jwt_token() {
    $identity = $this->check_identity();

    if( is_wp_error($identity) ) {
      return $identity;
    }

    $jwt_functions = new JWT_Functions();

    $this->check_user_status();

    return $jwt_functions->create_token($this->user_id);
  }

  private function check_user_status() {
    $user = get_users(array('meta_key' => JWT_FACEBOOK_META_KEY, 'meta_value' => $this->user_id, 'fields' => 'ID'));

    if( ! empty($user) ) { // User does exist

    } else { // User does NOT exist

    }
  }

  private function check_identity() {

    if( $this->token == null && $this->code == null ) {
      return new WP_Error('no_token_or_code', 'No token or code available');
    }

    if( $this->token != null ) {
      $return = $this->debug_token($this->token);

      if( is_wp_error($return) ) {
        return $return;
      }
    }

    if( $this->code != null ) {
      $token = $this->code_to_token($this->code);
      $return = $this->debug_token($token);

      if( is_wp_error($return) ) {
        return $return;
      }
    }

    return true;

  }

  private function debug_token($token) {
    if( is_wp_error($token) ) {
      return $token;
    }

    $response_json = Requests::get("https://graph.facebook.com/debug_token?input_token=$token&access_token=".FB_APP_ID.urlencode('|').FB_APP_SECRET);

    $response = json_decode($response_json->body);

    if( isset($response->error) ) {
      return new WP_Error('fb_error', $response->error->message);
    }

    if( $this->token != null && $this->token != $response->user_id ) {
      return new WP_Error('userids_not_matching', 'User-IDs do not math');
    }

    $this->access_token = $token;
    $this->user_id = $response->data->user_id;

  }

  private function code_to_token() {
    $response_json = Requests::get("https://graph.facebook.com/v2.3/oauth/access_token?client_id=".FB_APP_ID."&redirect_uri=".urlencode(JWT_SOCIAL_REDIRECT)."%3Fmethod%3Dfacebook&client_secret=".FB_APP_SECRET."&code=$this->code");

    $response = json_decode($response_json->body);

    if( isset($response->error) ) {
      return new WP_Error('fb_error', $response->error->message);
    }

    return $response->access_token;
  }

}

?>
