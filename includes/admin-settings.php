<?php

// Add settings page
add_action('admin_menu', function () {
    add_options_page('Wine Tasting Estimator Settings', 'Wine Estimator', 'manage_options', 'wte-settings', 'wte_render_settings_page');
});

// Register settings and fields
add_action('admin_init', function () {
    register_setting('wte-settings-group', 'wte_base_rate');
    register_setting('wte-settings-group', 'wte_drink_rate');
    register_setting('wte-settings-group', 'wte_wine_rate');
    register_setting('wte-settings-group', 'wte_champagne_rate');

    add_settings_section('wte_section', 'Pricing Settings', null, 'wte-settings');

    add_settings_field('wte_base_rate', 'Base Rate per Person (£)', function () {
        $value = get_option('wte_base_rate', 25);
        echo "<input type='number' name='wte_base_rate' value='" . esc_attr($value) . "' step='0.01' />";
    }, 'wte-settings', 'wte_section');

    add_settings_field('wte_drink_rate', 'Default Drink Rate (£)', function () {
        $value = get_option('wte_drink_rate', 10);
        echo "<input type='number' name='wte_drink_rate' value='" . esc_attr($value) . "' step='0.01' />";
    }, 'wte-settings', 'wte_section');

    add_settings_field('wte_wine_rate', 'Wine Rate per Drink (£)', function () {
        $value = get_option('wte_wine_rate', 10);
        echo "<input type='number' name='wte_wine_rate' value='" . esc_attr($value) . "' step='0.01' />";
    }, 'wte-settings', 'wte_section');

    add_settings_field('wte_champagne_rate', 'Champagne Rate per Drink (£)', function () {
        $value = get_option('wte_champagne_rate', 15);
        echo "<input type='number' name='wte_champagne_rate' value='" . esc_attr($value) . "' step='0.01' />";
    }, 'wte-settings', 'wte_section');
});

// Render settings page
function wte_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>Wine Tasting Estimator Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('wte-settings-group');
            do_settings_sections('wte-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
