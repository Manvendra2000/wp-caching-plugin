<?php
if (!defined('ABSPATH')) {
    exit;
}

// Register API routes
add_action('rest_api_init', function () {
    register_rest_route('wp-cache/v1', '/status', array(
        'methods' => 'GET',
        'callback' => function () {
            return rest_ensure_response(['status' => get_transient('wp_cache_status') ?: 'Empty']);
        },
    ));

    register_rest_route('wp-cache/v1', '/clear', array(
        'methods' => 'POST',
        'callback' => function () {
            delete_transient('wp_cache_status');
            return rest_ensure_response(['message' => 'Cache Cleared']);
        },
        'permission_callback' => function () {
            return current_user_can('manage_options');
        }
    ));
});
?>