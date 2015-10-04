<?php

/*
 * Plugin Name: Wordpress Starter Plugin
 * Description: This is a simple starter-plugin that makes it easy to create a new plugin, without setting up everything from scratch.
 * Version:     0.0.1
 * Author:      Yanik Peiffer
*/

defined( 'ABSPATH' ) or die( 'No!' );

class WP_Starter_Plugin {

  public function __construct() {
    $this->add_hooks();
    $this->load_classes();
  }

  /**
   * Activate the plugin
   */
  public static function activate() {
  }

  /**
   * Deactivate the plugin
   */
  public static function deactivate() {

  }

  /**
   * Load classes from ./inc/
   */
  function load_classes() {

  }

  /**
   * Register hooks
   */
  function add_hooks() {
    add_action("admin_menu", array($this,"add_settings_page"));
  }

  /**
   * Add admin-page
   */
  function add_settings_page() {
  	add_options_page("WP Starter", "WP Starter", "manage_options", "wp-starter", array($this, "wp_starter_settings_view"), null, 99);
  }

  /**
   * Admin-page content
   */
  function wp_starter_settings_view()  {
      ?>
  	    <div class="wrap">

          <?php
            if(isset($_GET['msg']) && $_GET['msg'] == 'success_import') { ?>
              <div class="updated">
                  <p><?php _e( 'Success!', 'wp-starter-plugin' ); ?></p>
              </div>
          <?php  }
           ?>

  	    <h1>WP Starter Plugin</h1>
  		</div>
  	<?php
  }

}

if(class_exists('WP_Starter_Plugin'))
{
    register_activation_hook(__FILE__, array('WP_Starter_Plugin', 'activate'));
    register_deactivation_hook(__FILE__, array('WP_Starter_Plugin', 'deactivate'));

    $wp_starter_plugin = new WP_Starter_Plugin();
}

?>
