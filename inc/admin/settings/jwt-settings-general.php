<?php

class JWT_Settings_General extends JWT_Settings {

  public function __construct() {
    $this->id = 'general';
    $this->label = 'General';

    add_filter( 'jwt_settings_tabs_array', array( $this, 'add_settings_tab' ), 20 );
    add_action('jwt_register_settings', array($this, 'register_settings') );
    add_action('jwt_settings_' . $this->id, array($this, 'output'));
  }

  public function get_sections() {
    return array(
      array(
        'id'    =>  'jwt_general',
        'title' =>  'General'
      )
    );
  }

  public function get_settings() {
    return array(
      array(
        'id'      =>  'jwt_secret',
        'title'   =>  __('Secret', 'jwt'),
        'type'    =>  'text',
        'section' =>  'jwt_general'
      ),
      array(
        'id'      =>  'jwt_expiration_time',
        'title'   =>  __('Expiration (in seconds)', 'jwt'),
        'type'    =>  'text',
        'default' =>  '86400',
        'section' =>  'jwt_general'
      ),
    );
  }

}

return new JWT_Settings_General();


?>
