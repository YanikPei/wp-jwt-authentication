<div class="wrap">
    <h2><?php _e('Welcome to WP Authentication Kit', 'wp-authentication-kit'); ?></h2>

    <p>
        <?php _e('Thank you for installing WP Authentication Kit! Now start by setting everything up and your users can login via social networks.', 'wp-authentication-kit'); ?>
    </p>

    <h2 class="nav-tab-wrapper">
            <a class="nav-tab nav-tab-active" href="#"><?php echo __('Setup', 'wp-authentication-kit'); ?></a>
    </h2>

    <div class="wak-section">
        <h3>1. Generate a secret to keep your data safe</h3>
        <form action="#" id="wak_generate_secret">
            <div class="wak-secret-input">
                <input type="text" class="regular-text" name="secret" placeholder="XXXXXXXXXXXX" />
                <button class="wak-generate-secret"><?php _e('Generate', 'wp-authentication-kit'); ?></button>
            </div>
            <input type="submit" class="button-primary" value="<?php _e('Save secret', 'wp-authentication-kit'); ?>" />
        </form>
    </div>

    <div class="wak-section">
        <h3>2. Activate AccountKit</h3>
        <a href="#" class="button-primary"><?php _e('Show me how', 'wp-authentication-kit'); ?></a>
    </div>

    <div class="wak-section">
        <h3>3. Activate Facebook</h3>
        <a href="#" class="button-primary"><?php _e('Show me how', 'wp-authentication-kit'); ?></a>
    </div>

    <div class="wak-section">
        <h3>4. Have fun!</h3>
    </div>

</div>