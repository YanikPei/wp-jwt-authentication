<?php

class JWT_Settings_General extends JWT_Settings {

  public function __construct() {
    $this->id = 'general';
    $this->label = 'General';

    add_filter( 'jwt_settings_tabs_array', array( $this, 'add_settings_tab' ), 20 );
  }

}

return new JWT_Settings_General();


?>
