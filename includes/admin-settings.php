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
     register_setting('wte-settings-group', 'wte_email_template');

      add_settings_section('wte_main', 'Main Settings', null, 'wte-settings');
      

       add_settings_field('wte_email_template', 'Email Template', function () {
    $value = get_option('wte_email_template', "Hi {name},\n\nThank you for your interest in our tasting event {type}.\nYou requested {people} People, having {drinks} person.\nYour location: {location}\nYour estimated cost is £{cost}.\n\nCheers,\nThe Team");

    echo "<textarea id='wte_email_template' name='wte_email_template' rows='6' cols='60'>" . esc_textarea($value) . "</textarea>";
    echo "<p><small>Use placeholders: <code>{name}</code>, <code>{cost}</code>, <code>{type}</code>, <code>{people}</code>, <code>{drinks}</code>, <code>{reason}</code>, <code>{location}</code></small></p>";
    
    echo "<h4>Email Preview:</h4>";
    echo "<div id='wte_email_preview' style='white-space: pre-wrap; background: #f9f9f9; border: 1px solid #ccc; padding: 10px;'></div>";

    // Add inline JS to update preview
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.getElementById('wte_email_template');
            const preview = document.getElementById('wte_email_preview');

            const sampleData = {
                name: 'Sophie Sparkle',
                cost: '150.00',
                type: 'champagne',
                people: '8',
                drinks: '12',
                reason: 'Corporate Event',
                location: 'London',
            };

            function updatePreview() {
                let text = textarea.value;
                for (const key in sampleData) {
                    const regex = new RegExp('{' + key + '}', 'g');
                    text = text.replace(regex, sampleData[key]);
                }
                preview.textContent = text;
            }

            textarea.addEventListener('input', updatePreview);
            updatePreview();
        });
    </script>
    <?php
}, 'wte-settings', 'wte_main');

add_settings_field(
    'wte_email_subject',
    'Email Subject',
    function () {
        $value = esc_attr(get_option('wte_email_subject', 'Your Wine Tasting Estimate'));
        echo '<input type="text" name="wte_email_subject" value="' . $value . '" class="regular-text">';
    },
    'wte-settings',
    'wte_main'
);

register_setting('wte-settings-group', 'wte_email_subject');

// From Name
add_settings_field(
    'wte_email_from_name',
    'Email From Name',
    function () {
        $value = esc_attr(get_option('wte_email_from_name', 'Wine Tasting Events'));
        echo '<input type="text" name="wte_email_from_name" value="' . $value . '" class="regular-text">';
    },
    'wte-settings',
    'wte_main'
);
register_setting('wte-settings-group', 'wte_email_from_name');

// From Email
add_settings_field(
    'wte_email_from_email',
    'Email From Address',
    function () {
        $value = esc_attr(get_option('wte_email_from_email', 'no-reply@yourdomain.com'));
        echo '<input type="email" name="wte_email_from_email" value="' . $value . '" class="regular-text">';
    },
    'wte-settings',
    'wte_main'
);
register_setting('wte-settings-group', 'wte_email_from_email');


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

    add_settings_section('wte_style_section', 'Form Styling', null, 'wte-settings');

    register_setting('wte-settings-group', 'wte_form_bg');
    register_setting('wte-settings-group', 'wte_form_text');
    register_setting('wte-settings-group', 'wte_button_color');
    register_setting('wte-settings-group', 'wte_button_text_color');
    register_setting('wte-settings-group', 'wte_border_radius');
    register_setting('wte-settings-group', 'wte_form_padding');
    register_setting('wte-settings-group', 'wte_form_border_color');
    register_setting('wte-settings-group', 'wte_form_border_width');

    add_settings_field('wte_form_bg', 'Form Background Color', 'wte_color_field_cb', 'wte-settings', 'wte_style_section', ['id' => 'wte_form_bg']);
    add_settings_field('wte_form_text', 'Text Color', 'wte_color_field_cb', 'wte-settings', 'wte_style_section', ['id' => 'wte_form_text']);
    add_settings_field('wte_button_color', 'Button Color', 'wte_color_field_cb', 'wte-settings', 'wte_style_section', ['id' => 'wte_button_color']);
    add_settings_field('wte_button_text_color', 'Button Text Color', 'wte_color_field_cb', 'wte-settings', 'wte_style_section', ['id' => 'wte_button_text_color']);
    add_settings_field('wte_border_radius', 'Form Border Radius (px)', 'wte_input_field_cb', 'wte-settings', 'wte_style_section', ['id' => 'wte_border_radius']);
    add_settings_field('wte_form_padding', 'Form Padding (px)', 'wte_input_field_cb', 'wte-settings', 'wte_style_section', ['id' => 'wte_form_padding']);
    add_settings_field('wte_form_border_color', 'Form Border Color', 'wte_color_field_cb', 'wte-settings', 'wte_style_section', ['id' => 'wte_form_border_color']);
    add_settings_field('wte_form_border_width', 'Form Border Width (px)', 'wte_input_field_cb', 'wte-settings', 'wte_style_section', ['id' => 'wte_form_border_width']);

    function wte_color_field_cb($args) {
        $value = esc_attr(get_option($args['id'], '#ffffff'));
        echo "<input type='color' name='{$args['id']}' value='{$value}'>";
    }
    
    function wte_input_field_cb($args) {
        $value = esc_attr(get_option($args['id'], '4'));
        echo "<input type='number' name='{$args['id']}' value='{$value}' min='0'>";
    }

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
