<?php

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'WAK_ACCOUNT_KIT_META_KEY', '_jwt_account_kit_userid' );

class WAK_Account_Kit_Login {
	private $token;
	private $user_id;
	private $access_token;

	function __construct() {
		add_filter( 'wak_login_method_account_kit', array( $this, 'handle_authentication' ), 10, 2 );

    if( is_admin() ) {
      include(WAK_PLUGIN_DIR.'/inc/admin/settings/wak-settings-account-kit.php');
    }

    if( get_option('wak_account_kit_email_button') || get_option('wak_account_kit_phone_button') ) {
      add_action('login_head', array($this, 'login_form_head'));
      add_action( 'login_form', array($this, 'login_form_button') );
    }
  }

  public function handle_authentication($return, $request) {
    if( ! get_option('wak_account_kit_active') ) {
      return $return;
    }

    if( !isset($request['token']) ) {
      return new WP_Error('token_missing', __('No token available', 'wp-authentication-kit'));
    }

    $this->token = $request['token'];

    return $this->create_jwt_token();

  }

  public function create_jwt_token() {
		$token_app_id = get_option('wak_account_kit_app_id');
    if( empty($token_app_id) ) {
      return new WP_Error('app_id_missing', __('Account-Kit app id is missing', 'wp-authentication-kit'));
    }

		$token_app_secret = get_option('wak_account_kit_app_secret');
    if( empty($token_app_secret) ) {
      return new WP_Error('app_id_missing', __('Account-Kit app secret is missing', 'wp-authentication-kit'));
    }

    $identity = $this->check_identity();

    if( is_wp_error($identity) ) {
      return $identity;
    }

    $this->user_id = $this->check_user_status();

    if( ! $this->user_id || is_wp_error($this->user_id) ) {
      return new WP_Error('no_user_found', __('No user matching the account kit id was found', 'wp-authentication-kit'));
    }

    $jwt_functions = new WAK_Functions();

    return $jwt_functions->create_token($this->user_id);
  }

  private function check_identity() {
    if( $this->token == null ) {
      return new WP_Error('no_token_or_code', __('No token or code available', 'wp-authentication-kit'));
    }

    $response_json = Requests::get("https://graph.accountkit.com/v1.0/access_token?grant_type=authorization_code&code=".$this->token."&access_token=AA".urlencode('|').get_option('jwt_account_kit_app_id').urlencode('|').get_option('jwt_account_kit_app_secret'));

    $response = json_decode($response_json->body);

    if( isset($response->error) ) {
      return new WP_Error('account_kit_error', $response->error->message);
    }

    $this->user_id = $response->id;
    $this->access_token = $response->access_token;

    return true;
  }

  private function check_user_status() {
    $user = get_users(array('meta_key' => WAK_ACCOUNT_KIT_META_KEY, 'meta_value' => $this->user_id, 'fields' => 'ID'));

    if( ! empty($user) ) { // User does exist

      return $user[0];

    } else { // User does NOT exist

      if( ! get_option('wak_account_kit_create_user') ) {
        return false;
      }

      // create wp-user
      $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );

      $user_data_json = Requests::get("https://graph.accountkit.com/v1.0/me/?access_token=".$this->access_token);
      $user_data = json_decode($user_data_json->body);

      if( isset($user_data->error) ) {
        return new WP_Error('account_kit_error', $user_data->error->message);
      }

      $username = '';
      $email = null;

      if( isset($user_data->phone) ) {
        $username = $user_data->phone->number;
      } else if( isset($user_data->email) ) {
        $username = $user_data->email->address;
        $email = $user_data->email->address;
      } else {
        return false;
      }

	    $user_id = wp_create_user( $username, $random_password, $email );

      if( is_numeric($user_id) ) {
        wp_update_user( array( 'ID' => $user_id, 'first_name' => '', 'last_name' => '', 'role' => 'editor' ) );
        update_user_meta( $user_id, WAK_ACCOUNT_KIT_META_KEY, $this->user_id );
      } else {
        return new WP_Error('registration_error', $user_id->get_error_message());
      }

      return $user_id;
    }
  }

  public function login_form_head() {
    echo '<script src="https://sdk.accountkit.com/en_US/sdk.js"></script>';
    echo '<script>
      AccountKit_OnInteractive = function(){
        AccountKit.init(
          {
            appId:'.get_option('wak_account_kit_app_id').',
            state:"{{csrf}}",
            version:"v1.0"
          }
        );
      };
    </script>';
    echo '<script src="'.WAK_PLUGIN_DIR_URL.'assets/js/account_kit_login.js"></script>';
    echo '<link rel="stylesheet" type="text/css" href="'.WAK_PLUGIN_DIR_URL.'assets/css/account_kit_login.css" />';
  }

  public function login_form_button() {

    echo '<input type="hidden" name="token" id="token" />';
    echo '<input type="hidden" name="method" id="method" value="account_kit" />';
    echo '<input type="hidden" name="set_wp_cookie" value="true" />';
    echo '<input type="hidden" name="redirect_to" value="'.get_bloginfo('url').'" />';

    if( get_option('wak_account_kit_phone_button') ) {
      echo '<a href="#" class="button-secondary account-kit-btn" onclick="phone_btn_onclick();">'.__('Login via SMS', 'wp-authentication-kit').'</a><br />';
    }

    if( get_option('wak_account_kit_email_button') ) {
      echo '<a href="#" class="button-secondary account-kit-btn" onclick="email_btn_onclick();">'.__('Login via Email', 'wp-authentication-kit').'</a><br />';
    }

  }

}

return new WAK_Account_Kit_Login();

?>
