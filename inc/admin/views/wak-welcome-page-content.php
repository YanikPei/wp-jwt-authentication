<div class="wrap wak-center-wrapper">
    <h2><?php _e('Welcome to WP Authentication Kit', 'wp-authentication-kit'); ?></h2>

    <p>
        <?php _e('Thank you for installing WP Authentication Kit! Now start by setting everything up and your users can login via social networks.', 'wp-authentication-kit'); ?>
    </p>

    <ol>
        <li>
            <div class="wak-section">
                <label>Generate a secret to keep your data safe</label>
                <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" id="wak_generate_secret">
                    <div class="wak-secret-input">
                        <input type="text" class="regular-text" name="secret" placeholder="XXXXXXXXXXXX" />
                        <button class="wak-generate-secret"><?php _e('Generate', 'wp-authentication-kit'); ?></button>
                    </div>
                    <input type="submit" class="button-primary" value="<?php _e('Save secret', 'wp-authentication-kit'); ?>" />
                </form>
            </div>
        </li>
        <li>
            <div class="wak-section">
                <label>Activate AccountKit</label>
                <a href="#" class="button-primary"><?php _e('Show me how', 'wp-authentication-kit'); ?></a>
            </div>
        </li>
        <li>
            <div class="wak-section">
                <label>Activate Facebook</label>
                <a href="#" class="button-primary"><?php _e('Show me how', 'wp-authentication-kit'); ?></a>
            </div>
        </li>
        <li>
            <div class="wak-section">
                <label>Have fun!</label>
            </div>
        </li>
    </ol>

</div>