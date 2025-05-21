<?php

add_action('wp_ajax_wte_save_estimate', 'wte_save_estimate');
add_action('wp_ajax_nopriv_wte_save_estimate', 'wte_save_estimate');

function wte_save_estimate() {
    $people = intval($_POST['people']);
    $type = sanitize_text_field($_POST['type']);
    $drinks = intval($_POST['drinks']);
    $email = sanitize_email($_POST['email']);

    $base = floatval(get_option('wte_base_rate', 25));
    $drink = floatval(get_option('wte_drink_rate', 10));

    $total = ($people * $base) + ($drinks * $drink);

    // Save to DB
    global $wpdb;
    $table = $wpdb->prefix . 'wte_leads';
    $wpdb->insert($table, [
        'email' => $email,
        'people' => $people,
        'type' => $type,
        'drinks' => $drinks,
        'total_cost' => $total,
        'created_at' => current_time('mysql')
    ]);

    // Send email
    wp_mail($email, "Your Wine Tasting Estimate", "Thank you! Your estimated cost is £" . number_format($total, 2));

    echo json_encode(['success' => true]);
    wp_die();
}

// DB Table
register_activation_hook(__FILE__, function () {
    global $wpdb;
    $table = $wpdb->prefix . 'wte_leads';
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table (
        id INT NOT NULL AUTO_INCREMENT,
        email VARCHAR(255),
        people INT,
        type VARCHAR(50),
        drinks INT,
        total_cost FLOAT,
        created_at DATETIME,
        PRIMARY KEY (id)
    ) $charset;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
});
