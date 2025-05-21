<?php

add_action('admin_menu', function () {
    add_options_page('Wine Tasting Estimator Settings', 'Wine Estimator', 'manage_options', 'wte-settings', 'wte_render_settings_page');
});

add_action('admin_init', function () {
    register_setting('wte-settings-group', 'wte_base_rate');
    register_setting('wte-settings-group', 'wte_drink_rate');
});

function wte_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>Wine Tasting Estimator Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('wte-settings-group'); ?>
            <?php do_settings_sections('wte-settings-group'); ?>

            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Base Rate Per Person (£)</th>
                    <td><input type="number" step="0.01" name="wte_base_rate" value="<?php echo esc_attr(get_option('wte_base_rate', 25)); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Rate Per Drink (£)</th>
                    <td><input type="number" step="0.01" name="wte_drink_rate" value="<?php echo esc_attr(get_option('wte_drink_rate', 10)); ?>" /></td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
