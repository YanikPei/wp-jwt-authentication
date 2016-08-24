<?php

/**
 * General settings
 *
 * @since 1.1.0
 * @access public
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; 

class WAK_Settings_General extends WAK_Settings {

  /**
  * constructor adds tab, registers settings, prints settings
  */
  public function __construct() {
    $this->id = 'general';
    $this->label = 'General';

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
        'id'    =>  'wak_general',
        'title' =>  __('General', 'wp-authentication-kit')
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
        'title'       =>  __('Secret', 'wp-authentication-kit'),
        'type'        =>  'text',
        'section'     =>  'wak_general',
        'description' =>  '<a href="'.WAK_PLUGIN_DIR_URL.'/create_secret.php" target="_blank">'.__('Generate a secret', 'wp-authentication-kit'). '</a> ' . __('and copy it in here', 'wp-authentication-kit') . '.'
      ),
      array(
        'id'      =>  'jwt_expiration_time',
        'title'   =>  __('Expiration (in seconds)', 'wp-authentication-kit'),
        'type'    =>  'text',
        'default' =>  '86400',
        'section' =>  'wak_general'
      ),
    );
  }

}

return new WAK_Settings_General();


?>
