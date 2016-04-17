<?php

/**
 * Settings for facebook authorization
 *
 * @since 1.1.0
 * @access public
 *
 */

class JWT_Settings_Account_Kit extends JWT_Settings {

  /**
  * constructor adds tab, registers settings, prints settings
  */
  public function __construct() {
    $this->id = 'account_kit';
    $this->label = 'Account-Kit';

    add_filter( 'jwt_settings_tabs_array', array( $this, 'add_settings_tab' ), 20 );
    add_action('jwt_register_settings', array($this, 'register_settings') );
    add_action('jwt_settings_' . $this->id, array($this, 'output'));
  }

  /**
  * define sections
  */
  public function get_sections() {
    return array(
      array(
        'id'    =>  'jwt_account_kit',
        'title' =>  __('Account-Kit Settings', 'wp_jwt_auth')
      ),
      array(
        'id'    =>  'jwt_account_kit_button',
        'title' =>  __('Account-Kit Login Buttons', 'wp_jwt_auth')
      )
    );
  }

  /**
  * define setting fields
  */
  public function get_settings() {
    return array(
      array(
        'id'      =>  'jwt_account_kit_active',
        'title'   =>  __('Activate', 'wp_jwt_auth'),
        'type'    =>  'checkbox',
        'section' =>  'jwt_account_kit',
        'label'   =>  __('Activate account-kit authentication', 'wp_jwt_auth')
      ),
      array(
        'id'      =>  'jwt_account_kit_app_id',
        'title'   =>  __('App ID', 'wp_jwt_auth'),
        'type'    =>  'text',
        'section' =>  'jwt_account_kit'
      ),
      array(
        'id'      =>  'jwt_account_kit_app_secret',
        'title'   =>  __('Account-Kit App Secret', 'wp_jwt_auth'),
        'type'    =>  'text',
        'section' =>  'jwt_account_kit'
      ),
      array(
        'id'      =>  'jwt_account_kit_create_user',
        'title'   =>  __('Registration', 'wp_jwt_auth'),
        'type'    =>  'checkbox',
        'section' =>  'jwt_account_kit',
        'label'   =>  __('Create a new user if no user matching the account-kit id was found.', 'wp_jwt_auth')
      ),
      array(
        'id'      =>  'jwt_account_kit_email_button',
        'title'   =>  __('Email', 'wp_jwt_auth'),
        'type'    =>  'checkbox',
        'section' =>  'jwt_account_kit_button',
        'label'   =>  __('Add a login button to login with a e-mail-address.', 'wp_jwt_auth')
      ),
      array(
        'id'      =>  'jwt_account_kit_phone_button',
        'title'   =>  __('Phone', 'wp_jwt_auth'),
        'type'    =>  'checkbox',
        'section' =>  'jwt_account_kit_button',
        'label'   =>  __('Add a login button to login with a phone number.', 'wp_jwt_auth')
      ),
    );
  }

}

return new JWT_Settings_Account_Kit();


?>
