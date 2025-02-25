<?php
if (!defined('ABSPATH')) {
    exit;
}

// Ensure cache-handler is included
require_once plugin_dir_path(__FILE__) . 'cache-handler.php';

// Register API routes
add_action('rest_api_init', function () {
    register_rest_route('wp-cache/v1', '/status', array(
        'methods' => 'GET',
        'callback' => function () {
            $cache_files = glob(WP_CACHE_DIR . '*.html');
            $cache_count = count($cache_files);
            return rest_ensure_response(['status' => $cache_count > 0 ? "Cached ({$cache_count} files)" : "Empty"]);
        },
        'permission_callback' => '__return_true' // No auth needed for checking status
    ));

    register_rest_route('wp-cache/v1', '/clear', array(
        'methods' => 'POST',
        'callback' => function () {
            if (!current_user_can('manage_options')) {
                return new WP_Error('rest_forbidden', 'You do not have permission to clear cache.', ['status' => 403]);
            }

            // Call function to clear cache
            wp_custom_cache_clear();

            // Verify if cache is cleared
            $remaining_files = glob(WP_CACHE_DIR . '*.html');
            if (empty($remaining_files)) {
                return rest_ensure_response(['message' => 'Cache Cleared']);
            } else {
                return rest_ensure_response(['message' => 'Cache not fully cleared', 'files' => $remaining_files]);
            }
        },
        'permission_callback' => function () {
            return current_user_can('manage_options'); // Only admins can clear cache
        }
    ));
});
