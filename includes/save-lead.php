<?php

// Handle AJAX estimate saving
add_action('wp_ajax_wte_save_estimate', 'wte_save_estimate');
add_action('wp_ajax_nopriv_wte_save_estimate', 'wte_save_estimate');

function wte_save_estimate() {
    $people = intval($_POST['people']);
    $type = sanitize_text_field($_POST['type']);
    $drinks = intval($_POST['drinks']);
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $reason = sanitize_text_field($_POST['reason'] ?? '');
    $drink_type = sanitize_text_field($_POST['drink_type'] ?? 'wine');

    $base = floatval(get_option('wte_base_rate', 25));
    $drink_rate = ($drink_type === 'champagne')
        ? floatval(get_option('wte_champagne_rate', 15))
        : floatval(get_option('wte_wine_rate', 10));

    $total = ($people * $base) + ($drinks * $drink_rate);

    // Save as post
    $post_id = wp_insert_post([
        'post_type' => 'wte_lead',
        'post_title' => 'Estimate from ' . $email . ' Name ' . $name . ' ',
        'post_status' => 'publish',
    ]);

    if ($post_id) {
          update_post_meta($post_id, 'wte_name', $name);
        update_post_meta($post_id, 'wte_email', $email);
        update_post_meta($post_id, 'wte_people', $people);
        update_post_meta($post_id, 'wte_type', $type);
        update_post_meta($post_id, 'wte_drinks', $drinks);
        update_post_meta($post_id, 'wte_reason', $reason);
        update_post_meta($post_id, 'wte_drink_type', $drink_type);
        update_post_meta($post_id, 'wte_total_cost', $total);
    }

    // Send email
    wp_mail($email, "Your Wine Tasting Estimate", "Thank you! Your estimated cost is £" . number_format($total, 2));

    echo json_encode(['success' => true]);
    wp_die();
}
