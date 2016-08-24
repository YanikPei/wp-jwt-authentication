<div class="wrap">

  <h2 class="nav-tab-wrapper">
    <?php foreach($tabs as $key => $tab) { ?>
      <a class="nav-tab <?php echo ($key == $current_tab) ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url(); ?>/options-general.php?page=wak_admin_page&tab=<?php echo $key; ?>"><?php echo $tab; ?></a>
    <?php } ?>
  </h2>


  <?php do_action( 'wak_settings_' . $current_tab ); ?>


</div>
