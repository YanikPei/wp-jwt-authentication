<?php

/**
 * Settings for facebook authorization
 *
 * @since 1.1.0
 * @access public
 *
 */

class JWT_Settings_Facebook extends JWT_Settings {

  /**
  * constructor adds tab, registers settings, prints settings
  */
  public function __construct() {
    $this->id = 'facebook';
    $this->label = 'Facebook';

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
        'id'    =>  'jwt_facebook',
        'title' =>  __('Facebook Settings', 'wp_jwt_auth')
      ),
      array(
        'id'    =>  'jwt_facebook_button',
        'title' =>  __('Facebook Login Button', 'wp_jwt_auth')
      )
    );
  }

  /**
  * define setting fields
  */
  public function get_settings() {
    return array(
      array(
        'id'      =>  'jwt_fb_active',
        'title'   =>  __('Activate', 'wp_jwt_auth'),
        'type'    =>  'checkbox',
        'section' =>  'jwt_facebook',
        'label'   =>  __('Activate facebook authentication', 'wp_jwt_auth')
      ),
      array(
        'id'      =>  'jwt_fb_app_id',
        'title'   =>  __('App ID', 'wp_jwt_auth'),
        'type'    =>  'text',
        'section' =>  'jwt_facebook'
      ),
      array(
        'id'      =>  'jwt_fb_app_secret',
        'title'   =>  __('App Secret', 'wp_jwt_auth'),
        'type'    =>  'text',
        'section' =>  'jwt_facebook'
      ),
      array(
        'id'      =>  'jwt_fb_create_user',
        'title'   =>  __('Registration', 'wp_jwt_auth'),
        'type'    =>  'checkbox',
        'section' =>  'jwt_facebook',
        'label'   =>  __('Create a new user if no user matching the facebook id was found.', 'wp_jwt_auth')
      ),
      array(
        'id'      =>  'jwt_fb_login_button',
        'title'   =>  __('Show button', 'wp_jwt_auth'),
        'type'    =>  'checkbox',
        'section' =>  'jwt_facebook_button',
        'label'   =>  __('Show a "Login with facebook" button.', 'wp_jwt_auth')
      ),
    );
  }

}

return new JWT_Settings_Facebook();


?>
