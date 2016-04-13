<?php

define('JWT_FACEBOOK_META_KEY', '_jwt_facebook_userid');

class JWT_Facebook_Login {
  private $token;
  private $code;
  private $user_id;
  private $access_token;
  private $fb_graph;

  function __construct($token = null, $code = null) {
    $this->token = $token;
    $this->code = $code;

    $this->fb_graph = new Facebook\Facebook([
      'app_id' => FB_APP_ID,
      'app_secret' => FB_APP_SECRET,
      'default_graph_version' => 'v2.5',
    ]);
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

      $this->user_id = $user[0];

    } else { // User does NOT exist

      // fetch user information
      try {
        $response = $this->fb_graph->get('/me?fields=email,first_name,last_name', $this->access_token);
      } catch(Facebook\Exceptions\FacebookResponseException $e) {
        return new WP_Error('fb_graph_error', 'Graph returned an error: ' . $e->getMessage());
        exit;
      } catch(Facebook\Exceptions\FacebookSDKException $e) {
        return new WP_Error('fb_sdk_error', 'Facebook SDK returned an error: ' . $e->getMessage());
        exit;
      }

      $fb_user = $response->getGraphUser();

      // create wp-user
      $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
	    $user_id = wp_create_user( $fb_user['email'], $random_password, $fb_user['email'] );

      if( is_numeric($user_id) ) {
        wp_update_user( array( 'ID' => $user_id, 'first_name' => $fb_user['first_name'], 'last_name' => $fb_user['last_name'], 'role' => 'editor' ) );
        update_user_meta( $user_id, JWT_FACEBOOK_META_KEY, $this->user_id );
      } else {
        return new WP_Error('registration_error', $user_id->get_error_message());
      }

      $this->user_id = $user_id;

      return true;
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
