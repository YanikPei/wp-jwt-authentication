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
        'title' =>  'Account-Kit Settings'
      ),
      array(
        'id'    =>  'jwt_account_kit_button',
        'title' =>  'Account-Kit Login Buttons'
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
        'title'   =>  __('Activate', 'jwt'),
        'type'    =>  'checkbox',
        'section' =>  'jwt_account_kit',
        'label'   =>  __('Activate account-kit authentication', 'jwt')
      ),
      array(
        'id'      =>  'jwt_account_kit_app_id',
        'title'   =>  __('App ID', 'jwt'),
        'type'    =>  'text',
        'section' =>  'jwt_account_kit'
      ),
      array(
        'id'      =>  'jwt_account_kit_app_secret',
        'title'   =>  __('Account-Kit App Secret', 'jwt'),
        'type'    =>  'text',
        'section' =>  'jwt_account_kit'
      ),
      array(
        'id'      =>  'jwt_account_kit_create_user',
        'title'   =>  __('Registration', 'jwt'),
        'type'    =>  'checkbox',
        'section' =>  'jwt_account_kit',
        'label'   =>  __('Create a new user if no user matching the account-kit id was found.', 'jwt')
      ),
      array(
        'id'      =>  'jwt_account_kit_email_button',
        'title'   =>  __('Email', 'jwt'),
        'type'    =>  'checkbox',
        'section' =>  'jwt_account_kit_button',
        'label'   =>  __('Add a login button to login with a e-mail-address.', 'jwt')
      ),
      array(
        'id'      =>  'jwt_account_kit_phone_button',
        'title'   =>  __('Phone', 'jwt'),
        'type'    =>  'checkbox',
        'section' =>  'jwt_account_kit_button',
        'label'   =>  __('Add a login button to login with a phone number.', 'jwt')
      ),
    );
  }

}

return new JWT_Settings_Account_Kit();


?>
