<div class="wrap wak-center-wrapper">
    <h2><?php _e('Welcome to WP Authentication Kit', 'wp-authentication-kit'); ?></h2>

    <p>
        <?php _e('Thank you for installing WP Authentication Kit! Now start by setting everything up and your users can login via social networks.', 'wp-authentication-kit'); ?>
    </p>

    <ol>
        <li>
            <div class="wak-section">
                <label>Generate a secret to keep your data safe</label>
                <form class="wak-form" action="options.php" id="wak_generate_secret">
                    <?php wp_nonce_field('wak_general-options'); ?>
                    <input type="hidden" name="action" value="update" />
                    <input type="hidden" name="option_page" value="wak_general">

                    <div class="wak-secret-input">
                        <input type="text" class="regular-text" name="jwt_secret" placeholder="XXXXXXXXXXXX" value="<?php echo get_option('jwt_secret'); ?>" />
                        <button class="wak-generate-secret"><?php _e('Generate', 'wp-authentication-kit'); ?></button>
                    </div>
                    <input type="submit" class="button-primary float-left" value="<?php _e('Save secret', 'wp-authentication-kit'); ?>" />
                    <div class="form-status float-left hidden">

                    </div>
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