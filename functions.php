<?php
/**
 * Black Brew Coffee Theme Functions
 */

// Theme setup
function blackbrew_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    
    // Register menus
    register_nav_menus([
        'primary' => __('Menu główne', 'blackbrew'),
        'footer' => __('Menu stopka', 'blackbrew'),
    ]);
    
    // Add image sizes
    add_image_size('menu-thumb', 400, 400, true);
    add_image_size('gallery-thumb', 600, 600, true);
    add_image_size('about-image', 800, 1000, true);
}
add_action('after_setup_theme', 'blackbrew_setup');

// Include Custom Post Types
require_once get_template_directory() . '/inc/custom-post-types.php';

// Include ACF Fields (only if ACF is active)
add_action('acf/init', function() {
    require_once get_template_directory() . '/inc/acf-fields.php';
});

// Check if ACF is installed - show admin notice if not
function blackbrew_check_acf() {
    if (!class_exists('ACF') && current_user_can('activate_plugins')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error"><p><strong>Black Brew Theme:</strong> Wtyczka <a href="' . admin_url('plugin-install.php?s=advanced+custom+fields&tab=search&type=term') . '">Advanced Custom Fields</a> jest wymagana do edycji treści strony.</p></div>';
        });
    }
}
add_action('admin_init', 'blackbrew_check_acf');

// Enqueue scripts and styles
function blackbrew_scripts() {
    $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
    
    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), true);
        
        // CSS
        if (isset($manifest['src/css/app.css'])) {
            wp_enqueue_style(
                'blackbrew-style',
                get_template_directory_uri() . '/dist/' . $manifest['src/css/app.css']['file'],
                [],
                null
            );
        }
        
        // JS
        if (isset($manifest['src/ts/app.ts'])) {
            wp_enqueue_script(
                'blackbrew-script',
                get_template_directory_uri() . '/dist/' . $manifest['src/ts/app.ts']['file'],
                [],
                null,
                true
            );
        }
    } else {
        // Development mode - Vite dev server
        wp_enqueue_script(
            'vite-client',
            'https://black-brew.ddev.site:5173/@vite/client',
            [],
            null,
            true
        );
        wp_enqueue_script(
            'blackbrew-script',
            'https://black-brew.ddev.site:5173/src/ts/app.ts',
            [],
            null,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'blackbrew_scripts');

// Disable Gutenberg
add_filter('use_block_editor_for_post', '__return_false');
