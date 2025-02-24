<?php
/**
 * Plugin Name: WP Caching Plugin
 * Description: A simple caching plugin with a Vue.js admin panel.
 * Version: 1.0
 * Author: Your Name
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/cache-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/api.php';

// Register admin menu
function wp_cache_admin_menu() {
    add_menu_page(
        'WP Cache Settings',
        'WP Cache',
        'manage_options',
        'wp-caching-plugin',
        'wp_cache_admin_page',
        'dashicons-dashboard',
        100
    );
}
add_action('admin_menu', 'wp_cache_admin_menu');

function wp_cache_admin_page() {
    ?>
    <div id="wp-cache-app"></div> <!-- Vue mounts here -->
    <script src="<?php echo plugin_dir_url(__FILE__) . 'admin/assets/app.js'; ?>"></script>
    <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) . 'admin/assets/style.css'; ?>">
    <?php
}

// Enqueue scripts
function wp_cache_enqueue_admin_scripts() {
    wp_enqueue_script(
        'wp-cache-app',
        plugin_dir_url(__FILE__) . 'admin/assets/app.js',
        array('wp-element'), // Load after React for compatibility
        '1.0',
        true
    );
}
add_action('admin_enqueue_scripts', 'wp_cache_enqueue_admin_scripts');
?>