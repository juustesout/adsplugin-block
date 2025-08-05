<?php
/**
 * Debug script to check if blocks are registered
 * Add this to your active theme's functions.php temporarily to debug
 */

// Add this function to check registered blocks
function debug_registered_blocks() {
    if ( current_user_can( 'manage_options' ) ) {
        $registry = WP_Block_Type_Registry::get_instance();
        $blocks = $registry->get_all_registered();
        
        echo '<div style="background: #f1f1f1; padding: 20px; margin: 20px 0; border: 1px solid #ccc;">';
        echo '<h3>Debug: Registered Blocks</h3>';
        echo '<h4>Looking for our blocks:</h4>';
        
        $our_blocks = array(
            'adsplugin/adsplugin-block',
            'adsplugin/contact-block', 
            'adsplugin/hero-block'
        );
        
        foreach ( $our_blocks as $block_name ) {
            if ( isset( $blocks[ $block_name ] ) ) {
                echo "✅ <strong>{$block_name}</strong> - REGISTERED<br>";
            } else {
                echo "❌ <strong>{$block_name}</strong> - NOT FOUND<br>";
            }
        }
        
        echo '<h4>All registered blocks containing "adsplugin":</h4>';
        foreach ( $blocks as $name => $block ) {
            if ( strpos( $name, 'adsplugin' ) !== false ) {
                echo "- {$name}<br>";
            }
        }
        
        echo '<h4>Block categories:</h4>';
        $categories = get_default_block_categories();
        if ( function_exists( 'get_block_categories' ) ) {
            $categories = get_block_categories( get_post() );
        }
        
        foreach ( $categories as $category ) {
            echo "- {$category['slug']}: {$category['title']}<br>";
            if ( $category['slug'] === 'ads-general' ) {
                echo "  ✅ Our custom category found!<br>";
            }
        }
        
        echo '</div>';
    }
}

// Hook to display debug info on admin pages
add_action( 'admin_notices', 'debug_registered_blocks' );
