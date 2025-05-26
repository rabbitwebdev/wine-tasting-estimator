<?php
/**
 * Plugin Name: Wine Tasting Estimator
 * Plugin URI: https://zapstart.digital/wine-tasting-estimator
 * Description: Estimate cost for a private wine/champagne tasting party, with lead capture and admin pricing options.
 * Text Domain: wine-tasting-estimator
 * Domain Path: /languages
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * Tested up to: 6.5
 * Version: 1.2
 * Author: P York
 */

// Include core components
include_once plugin_dir_path(__FILE__) . 'includes/shortcode-form.php';
include_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
include_once plugin_dir_path(__FILE__) . 'includes/save-lead.php';

// Register shortcode
add_shortcode('wine_tasting_estimator', 'wte_render_estimator_form');

// Enqueue JS/CSS
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('wte-script', plugin_dir_url(__FILE__) . 'assets/script.js', [], false, true);

    wp_localize_script('wte-script', 'wte_ajax', [
        'ajax_url'    => admin_url('admin-ajax.php'),
        'base_rate'        => get_option('wte_base_rate', 25),
    'wine_rate'        => get_option('wte_wine_rate', 10),
    'champagne_rate'   => get_option('wte_champagne_rate', 15),
    ]);

    wp_enqueue_style('wte-style', plugin_dir_url(__FILE__) . 'assets/style.css');
});

add_action('init', function () {
    register_post_type('wte_lead', [
        'label' => 'Wine Tasting Leads',
        'public' => false,
        'show_ui' => true,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title'],
    ]);
});

add_action('add_meta_boxes', function () {
    add_meta_box('wte_lead_details', 'Lead Details', 'wte_render_lead_meta_box', 'wte_lead', 'normal', 'default');
});

function wte_render_lead_meta_box($post) {
    $fields = [
        'wte_name' => 'Full Name',
        'wte_email' => 'Email',
        'wte_location' => 'Event Location',
        'wte_people' => 'Number of People',
        'wte_type' => 'Drink Type',
        'wte_drinks' => 'Number of Drinks',
        'wte_reason' => 'Reason for Tasting',
        'wte_drink_type' => 'Drink Category',
        'wte_total_cost' => 'Total Cost (£)',
    ];

    echo '<table class="form-table">';
    foreach ($fields as $key => $label) {
        $value = esc_html(get_post_meta($post->ID, $key, true));
        echo "<tr>
                <th scope='row'><label for='$key'>$label</label></th>
                <td><input type='text' id='$key' name='$key' value='$value' class='regular-text' readonly></td>
              </tr>";
    }
    echo '</table>';
}
