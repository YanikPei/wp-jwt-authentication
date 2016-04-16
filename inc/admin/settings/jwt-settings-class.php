<?php

abstract class JWT_Settings {

  protected $id;
  protected $label;

  public function __construct() {
    add_filter('jwt_settings_tabs_array', array($this, 'add_settings_tab'), 20);
    add_action('jwt_register_settings', array($this, 'register_settings') );
    add_action('jwt_settings_' . $this->id, array($this, 'output'));
  }

  public function add_settings_tab($tabs) {
    $tabs[$this->id] = $this->label;

    return $tabs;
  }

  public function get_settings() {
    return array();
  }

  public function get_sections() {
    return array();
  }

  public function output() {
    $sections = $this->get_sections();

    // output settings
    foreach($sections as $section) {
      settings_fields($section['id']);
      do_settings_sections($section['id']);
      submit_button();
    }
  }

  public function register_settings() {
    $settings = $this->get_settings();
    $sections = $this->get_sections();

    foreach($sections as $section) {
      add_settings_section($section['id'], $section['title'], null, $section['id']);
    }

    foreach($settings as $setting) {
      $callback = null;

      switch($setting['type']) {
        case 'text': $callback = array($this, 'settings_input_text'); break;
        case 'textarea': $callback = array($this, 'settings_input_textarea'); break;
        case 'checkbox': $callback = array($this, 'settings_input_checkbox'); break;
      }

      add_settings_field($setting['id'], $setting['title'], $callback, $setting['section'], $setting['section'], $setting);
      register_setting($setting['section'], $setting['id']);
    }
  }

  public function settings_input_text($args) {
    $default = (isset($args['default'])) ? $args['default'] : '';
    ?>
    <input type="text" name="<?php echo $args['id']; ?>" value="<?php echo (get_option($args['id'])) ? get_option($args['id']) : $default; ?>" />
    <?php echo (isset($args['description'])) ? $args['description'] : ''; ?>
    <?php
  }

  public function settings_input_textarea($args) {
    ?>
    <textarea name="<?php echo $args['id']; ?>">
      <?php echo get_option($args['id']); ?>
    </textarea>
    <?php
  }

  public function settings_input_checkbox($args) {
    ?>
    <label for="<?php echo $args['id']; ?>">
      <input type="checkbox" name="<?php echo $args['id']; ?>" id="<?php echo $args['id']; ?>" <?php echo (get_option($args['id'])) ? 'checked' : ''; ?> />
       <?php echo $args['label']; ?>
    </label>
    <?php
  }

}

 ?>
