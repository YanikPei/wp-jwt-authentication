<?php

class JWT_Settings_Facebook extends JWT_Settings {

  public function __construct() {
    $this->id = 'facebook';
    $this->label = 'Facebook';

    add_filter( 'jwt_settings_tabs_array', array( $this, 'add_settings_tab' ), 20 );
    add_action('jwt_register_settings', array($this, 'register_settings') );
    add_action('jwt_settings_' . $this->id, array($this, 'output'));
  }

  public function get_sections() {
    return array(
      array(
        'id'    =>  'jwt_facebook',
        'title' =>  'Facebook Settings'
      )
    );
  }

  public function get_settings() {
    return array(
      array(
        'id'      =>  'jwt_fb_app_id',
        'title'   =>  __('App ID', 'jwt'),
        'type'    =>  'text',
        'section' =>  'jwt_facebook'
      ),
      array(
        'id'      =>  'jwt_fb_app_secret',
        'title'   =>  __('App Secret', 'jwt'),
        'type'    =>  'text',
        'section' =>  'jwt_facebook'
      ),
    );
  }

}

return new JWT_Settings_Facebook();


?>
