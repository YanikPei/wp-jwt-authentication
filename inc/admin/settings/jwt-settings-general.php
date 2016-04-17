<?php

/**
 * General settings
 *
 * @since 1.1.0
 * @access public
 *
 */

class JWT_Settings_General extends JWT_Settings {

  /**
  * constructor adds tab, registers settings, prints settings
  */
  public function __construct() {
    $this->id = 'general';
    $this->label = 'General';

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
        'id'    =>  'jwt_general',
        'title' =>  __('General', 'wp_jwt_auth')
      )
    );
  }

  /**
  * define setting fields
  */
  public function get_settings() {
    return array(
      array(
        'id'          =>  'jwt_secret',
        'title'       =>  __('Secret', 'wp_jwt_auth'),
        'type'        =>  'text',
        'section'     =>  'jwt_general',
        'description' =>  '<a href="'.WP_JWT_PLUGIN_DIR_URL.'/create_secret.php" target="_blank">'.__('Generate a secret', 'wp_jwt_auth'). '</a> ' . __('and copy it in here', 'wp_jwt_auth') . '.'
      ),
      array(
        'id'      =>  'jwt_expiration_time',
        'title'   =>  __('Expiration (in seconds)', 'wp_jwt_auth'),
        'type'    =>  'text',
        'default' =>  '86400',
        'section' =>  'jwt_general'
      ),
    );
  }

}

return new JWT_Settings_General();


?>
