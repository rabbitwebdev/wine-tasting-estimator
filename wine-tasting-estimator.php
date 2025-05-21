<?php
/**
 * Plugin Name: Wine Tasting Estimator
 * Description: Estimate cost for a private wine/champagne tasting party, with lead capture and admin pricing options.
 * Version: 1.1
 * Author: Your Name
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

