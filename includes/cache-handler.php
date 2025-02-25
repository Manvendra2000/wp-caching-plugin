<?php
if (!defined('ABSPATH')) {
    exit;
}

// Define cache directory
define('WP_CACHE_DIR', WP_CONTENT_DIR . '/cache/wp-caching-plugin/');

/**
 * Create cache directory if not exists.
 */
function wp_custom_cache_init() {
    if (!file_exists(WP_CACHE_DIR)) {
        mkdir(WP_CACHE_DIR, 0755, true);
    }
}
add_action('init', 'wp_custom_cache_init');

/**
 * Generate a cache key based on the requested URL.
 */
function wp_custom_cache_get_cache_file() {
    $url = strtok($_SERVER['REQUEST_URI'], '?'); // Remove query string
    $hash = md5($url);
    return WP_CACHE_DIR . $hash . '.html';
}

/**
 * Serve cached page if exists.
 */
function wp_custom_cache_serve_cache() {
    if (is_user_logged_in() || is_admin()) {
        return; // Do not cache for logged-in users or admins
    }

    $cache_file = wp_custom_cache_get_cache_file();
    
    // Ensure the file exists and is readable
    if ($cache_file && file_exists($cache_file) && filesize($cache_file) > 0) {
        header("Content-Type: text/html; charset=UTF-8");
        header("Cache-Control: max-age=3600, must-revalidate");

        readfile($cache_file);
        exit;
    }
}
add_action('template_redirect', 'wp_custom_cache_serve_cache', 0);

/**
 * Start output buffering to cache page content.
 */
function wp_custom_cache_start() {
    if (!is_admin() && !is_user_logged_in()) {
        ob_start();
    }
}
add_action('template_redirect', 'wp_custom_cache_start', 1);

/**
 * Save buffered content to file cache.
 */
function wp_custom_cache_end() {
    if (!is_admin() && !is_user_logged_in()) {
        $output = ob_get_contents();
        ob_end_clean(); // Use ob_end_clean() instead of ob_end_flush() to avoid empty output
        
        $cache_file = wp_custom_cache_get_cache_file();
        
        // Save only if content is valid and cache file is correctly identified
        if ($cache_file && !empty(trim($output))) {
            file_put_contents($cache_file, $output);
            echo $output; // Ensure the output is printed after saving
        }
    }
}
add_action('shutdown', 'wp_custom_cache_end', 0);

/**
 * Clear cache (delete all cached files).
 */
function wp_custom_cache_clear() {
    if (!file_exists(WP_CACHE_DIR)) {
        return;
    }

    $files = glob(WP_CACHE_DIR . '*.html'); // Get all cache files

    if ($files) {
        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
}
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