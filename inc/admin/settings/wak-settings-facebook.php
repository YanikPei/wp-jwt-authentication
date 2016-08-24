<?php

if ( ! defined( 'ABSPATH' ) ) exit; 

/**
 * Settings for facebook authorization
 *
 * @since 1.1.0
 * @access public
 *
 */

class WAK_Settings_Facebook extends WAK_Settings {

  /**
  * constructor adds tab, registers settings, prints settings
  */
  public function __construct() {
    $this->id = 'facebook';
    $this->label = 'Facebook';

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
        'id'    =>  'wak_facebook',
        'title' =>  __('Facebook Settings', 'wp-authentication-kit')
      ),
      array(
        'id'    =>  'wak_facebook_button',
        'title' =>  __('Facebook Login Button', 'wp-authentication-kit')
      )
    );
  }

  /**
  * define setting fields
  */
  public function get_settings() {
    return array(
      array(
        'id'      =>  'wak_fb_active',
        'title'   =>  __('Activate', 'wp-authentication-kit'),
        'type'    =>  'checkbox',
        'section' =>  'wak_facebook',
        'label'   =>  __('Activate facebook authentication', 'wp-authentication-kit')
      ),
      array(
        'id'      =>  'wak_fb_app_id',
        'title'   =>  __('App ID', 'wp-authentication-kit'),
        'type'    =>  'text',
        'section' =>  'wak_facebook'
      ),
      array(
        'id'      =>  'wak_fb_app_secret',
        'title'   =>  __('App Secret', 'wp-authentication-kit'),
        'type'    =>  'text',
        'section' =>  'wak_facebook'
      ),
      array(
        'id'      =>  'wak_fb_create_user',
        'title'   =>  __('Registration', 'wp-authentication-kit'),
        'type'    =>  'checkbox',
        'section' =>  'wak_facebook',
        'label'   =>  __('Create a new user if no user matching the facebook id was found.', 'wp-authentication-kit')
      ),
      array(
        'id'      =>  'wak_fb_login_button',
        'title'   =>  __('Show button', 'wp-authentication-kit'),
        'type'    =>  'checkbox',
        'section' =>  'wak_facebook_button',
        'label'   =>  __('Show a "Login with facebook" button.', 'wp-authentication-kit')
      ),
    );
  }

}

return new WAK_Settings_Facebook();


?>
