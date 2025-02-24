<?php
if (!defined('ABSPATH')) {
    exit;
}

// Basic caching system
function wp_cache_start() {
    ob_start();
}
add_action('wp_head', 'wp_cache_start');

function wp_cache_end() {
    $output = ob_get_clean();
    set_transient('wp_cache_status', 'Cached', 3600); // 1 hour cache
    echo $output;
}
add_action('wp_footer', 'wp_cache_end');
?>