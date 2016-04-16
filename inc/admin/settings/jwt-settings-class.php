<?php

abstract class JWT_Settings {

  protected $id;
  protected $label;

  public function __construct() {
    add_filter('jwt_settings_tabs_array', array($this, 'add_settings_tab'), 20);
  }

  public function add_settings_tab($tabs) {
    $tabs[$this->id] = $this->label;

    return $tabs;
  }

  public function get_settings() {
    return array();
  }

  public function output() {
    $settings = $this->get_settings();

    // output settings
  }

  public function save() {
    $settings = $this->get_settings();

    // save settings
  }

}

 ?>
