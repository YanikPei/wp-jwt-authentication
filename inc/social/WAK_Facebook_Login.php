<?php

/**
 * JWT-Facebook_Login class, handle Facebook-authentication
 *
 * This class validates a facebook-code/-token and checks if a wp-user
 * linked to the Facebook-account exists. If not, a new user will be registered.
 *
 * @package wp-jwt-authentication
 * @subpackage wp-jwt-authentication/inc/social
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; 

define('WAK_FACEBOOK_META_KEY', '_wak_facebook_userid');

class WAK_Facebook_Login {
  /* @var string Token that has to be validated */
  private $token;

  /* @var string Code that has to be converted and validated */
  private $code;

  /* @var int WP-userid */
  private $user_id;

  /* @var string FB-access-token */
  private $access_token;

  /* @var Object FB-graph  */
  private $fb_graph;

  /**
  * Constructor for the facebook class. Registers auth handler and includes settings.
  */
  function __construct() {
    add_filter('wak_login_method_facebook', array($this, 'handle_authentication'), 10, 2);

    if( is_admin() ) {
      include(WAK_PLUGIN_DIR.'/inc/admin/settings/wak-settings-facebook.php');
    }

    if( get_option('wak_fb_login_button') ) {
      add_action('login_head', array($this, 'login_form_head'));
      add_action( 'login_form', array($this, 'login_form_button') );
    }

  }

  /**
  * Handles authentication
  */
  public function handle_authentication($return, $request) {
    if( ! get_option('wak_fb_active') ) {
      return $return;
    }

    if( isset($request['error']) ) {
      return new WP_Error('gb_error', 'FB-Error: '.$request['error_description'].' ('.$request['error_reason'].')');
    }

    $this->token = null;
    $this->code = null;

    if( isset($request['token']) ) {
      $this->token = $request['token'];
    }
    if( isset($request['code']) ) {
      $this->code = $request['code'];
    }

    $this->fb_graph = new Facebook\Facebook([
      'app_id' => get_option('wak_fb_app_id'),
      'app_secret' => get_option('wak_fb_app_secret'),
      'default_graph_version' => 'v2.5',
    ]);

    return $this->create_jwt_token();

  }

  /**
  * Create a jwt for current user
  *
  * @return string|WP_Error
  */
  public function create_jwt_token() {
    $identity = $this->check_identity();

    if( is_wp_error($identity) ) {
      return $identity;
    }

    $jwt_functions = new WAK_Functions();

    $this->user_id = $this->check_user_status();

    if( ! $this->user_id || is_wp_error($this->user_id) ) {
      return new WP_Error('no_user_found', __('No user matching the facebook id was found', 'wp-authentication-kit'));
    }

    return $jwt_functions->create_token($this->user_id);
  }

  /**
  * Checks if a user linked to fb-account exists. If not it will create a new user
  * and fetch the required data from facebook (e.g. email, first_name, last_name)
  */
  private function check_user_status() {
    $user = get_users(array('meta_key' => WAK_FACEBOOK_META_KEY, 'meta_value' => $this->user_id, 'fields' => 'ID'));

    if( ! empty($user) ) { // User does exist

      return $user[0];

    } else { // User does NOT exist

      if( ! get_option('wak_fb_create_user') ) {
        return false;
      }

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
        update_user_meta( $user_id, WAK_FACEBOOK_META_KEY, $this->user_id );
      } else {
        return new WP_Error('registration_error', $user_id->get_error_message());
      }

      return $user_id;
    }

    return false;
  }

  /**
  * checks if the token is valid
  */
  private function check_identity() {

    if( $this->token == null && $this->code == null ) {
      return new WP_Error('no_token_or_code', __('No token or code available', 'wp-authentication-kit'));
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

  /**
  * sends token to facebook and fetches fb-id if token is valid.
  */
  private function debug_token($token) {
    if( is_wp_error($token) ) {
      return $token;
    }

    $response_json = Requests::get("https://graph.facebook.com/debug_token?input_token=$token&access_token=".get_option('wak_fb_app_id').urlencode('|').get_option('wak_fb_app_secret'));

    $response = json_decode($response_json->body);

    if( isset($response->error) ) {
      return new WP_Error('fb_error', $response->error->message);
    }

    $this->access_token = $token;
    $this->user_id = $response->data->user_id;

  }

  /**
  * converts a fb-code to a fb-token by using Graph-API
  */
  private function code_to_token() {
    $redirect_uri = urlencode(get_bloginfo('url') . '/wp-json/wp-jwt/v1/login?method=facebook');

    var_dump($_GET);

    $response_json = Requests::get("https://graph.facebook.com/v2.3/oauth/access_token?client_id=".get_option('wak_fb_app_id')."&redirect_uri=".$redirect_uri."&client_secret=".get_option('wak_fb_app_secret')."&code=$this->code");

    $response = json_decode($response_json->body);

    if( isset($response->error) ) {
      return new WP_Error('fb_error', $response->error->message);
    }

    return $response->access_token;
  }

  public function login_form_head() {
    echo '<link rel="stylesheet" type="text/css" href="'.WAK_PLUGIN_DIR_URL.'assets/css/facebook_login.css" />';
    echo '<script>
              (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/'.get_locale().'/sdk.js";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, "script", "facebook-jssdk"));


        window.fbAsyncInit = function() {
          FB.init({
            appId      : "'.get_option('wak_fb_app_id').'",
            cookie     : true,
            xfbml      : true,
            version    : "v2.2"
          });

        };
          </script>';
    echo '<script src="'.WAK_PLUGIN_DIR_URL.'assets/js/facebook_login.js"></script>';
  }

  public function login_form_button() {

    $redirect_uri = urlencode(get_bloginfo('url') . '/wp-json/wp-jwt/v1/login?method=facebook');

    echo '<a href="#" onclick="fbLoginButton(\''.get_bloginfo('url').'/wp-json/wp-jwt/v1/login?method=facebook&redirect_to='.urlencode(get_bloginfo('url')).'&set_wp_cookie=true\');" class="button-secondary facebook-btn">'.__('Login with facebook', 'wp-authentication-kit').'</a><br />';

  }

}

return new WAK_Facebook_Login();

?>
