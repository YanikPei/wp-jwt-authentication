<div class="wrap">

  <h2 class="nav-tab-wrapper">
    <?php foreach($tabs as $key => $tab) { ?>
      <a class="nav-tab <?php echo ($key == $current_tab) ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url(); ?>/options-general.php?page=jwt_admin_page&tab=<?php echo $key; ?>"><?php echo $tab; ?></a>
    <?php } ?>
  </h2>

  <h1><?php echo $tabs[$current_tab]; ?></h1>

  <?php do_action( 'jwt_settings_' . $current_tab ); ?>

  <p class="submit">
	  <input name="save" class="button-primary jwt-save-button" type="submit" value="<?php esc_attr_e( 'Save changes', 'jwt' ); ?>" />
		<?php wp_nonce_field( 'jwt-settings' ); ?>
	</p>

</div>
