<?php

if ( ! defined( 'ABSPATH' ) ) exit; 

/**
 * Settings for facebook authorization
 *
 * @since 1.1.0
 * @access public
 *
 */

class WAK_Settings_Account_Kit extends WAK_Settings {

  /**
  * constructor adds tab, registers settings, prints settings
  */
  public function __construct() {
    $this->id = 'account_kit';
    $this->label = 'Account-Kit';

    add_filter( 'wak_settings_tabs_array', array( $this, 'add_settings_tab' ), 20 );
    add_action('wak_register_settings', array($this, 'register_settings') );
    add_action('wak_settings_' . $this->id, array($this, 'output'));
  }

  /**
  * define sections
  */
  public function get_sections() {
    return array(
      array(
        'id'    =>  'wak_account_kit',
        'title' =>  __('Account-Kit Settings', 'wp-authentication-kit')
      ),
      array(
        'id'    =>  'wak_account_kit_button',
        'title' =>  __('Account-Kit Login Buttons', 'wp-authentication-kit')
      )
    );
  }

  /**
  * define setting fields
  */
  public function get_settings() {
    return array(
      array(
        'id'      =>  'wak_account_kit_active',
        'title'   =>  __('Activate', 'wp-authentication-kit'),
        'type'    =>  'checkbox',
        'section' =>  'wak_account_kit',
        'label'   =>  __('Activate account-kit authentication', 'wp-authentication-kit')
      ),
      array(
        'id'      =>  'wak_account_kit_app_id',
        'title'   =>  __('App ID', 'wp-authentication-kit'),
        'type'    =>  'text',
        'section' =>  'wak_account_kit'
      ),
      array(
        'id'      =>  'wak_account_kit_app_secret',
        'title'   =>  __('Account-Kit App Secret', 'wp-authentication-kit'),
        'type'    =>  'text',
        'section' =>  'wak_account_kit'
      ),
      array(
        'id'      =>  'wak_account_kit_create_user',
        'title'   =>  __('Registration', 'wp-authentication-kit'),
        'type'    =>  'checkbox',
        'section' =>  'wak_account_kit',
        'label'   =>  __('Create a new user if no user matching the account-kit id was found.', 'wp-authentication-kit')
      ),
      array(
        'id'      =>  'wak_account_kit_email_button',
        'title'   =>  __('Email', 'wp-authentication-kit'),
        'type'    =>  'checkbox',
        'section' =>  'wak_account_kit_button',
        'label'   =>  __('Add a login button to login with a e-mail-address.', 'wp-authentication-kit')
      ),
      array(
        'id'      =>  'wak_account_kit_phone_button',
        'title'   =>  __('Phone', 'wp-authentication-kit'),
        'type'    =>  'checkbox',
        'section' =>  'wak_account_kit_button',
        'label'   =>  __('Add a login button to login with a phone number.', 'wp-authentication-kit')
      ),
    );
  }

}

return new WAK_Settings_Account_Kit();


?>
