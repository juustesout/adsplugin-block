<?php
/**
 * Plugin Name:       Adsplugin Block
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       adsplugin-block
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Registers the blocks using traditional method for better compatibility
 */
function create_block_adsplugin_block_block_init() {
	// Register each block individually for better compatibility
	$blocks = array(
		'adsplugin-block',
		'block-contact', 
		'block-hero'
	);
	
	foreach ( $blocks as $block ) {
		$block_dir = __DIR__ . "/build/{$block}";
		if ( file_exists( $block_dir . '/block.json' ) ) {
			register_block_type( $block_dir );
		}
	}
}
add_action( 'init', 'create_block_adsplugin_block_block_init' );

/**
 * Register custom block category for ads blocks
 */
function adsplugin_block_categories( $categories ) {
	return array_merge(
		array(
			array(
				'slug'  => 'ads-general',
				'title' => __( 'Ads General', 'adsplugin-block' ),
				'icon'  => 'megaphone',
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'adsplugin_block_categories' );

/**
 * Debug function to check if blocks are registered (temporary)
 */
function debug_adsplugin_blocks() {
    if ( current_user_can( 'manage_options' ) && isset( $_GET['debug_blocks'] ) ) {
        $registry = WP_Block_Type_Registry::get_instance();
        $blocks = $registry->get_all_registered();
        
        echo '<div style="background: #f1f1f1; padding: 20px; margin: 20px 0; border: 1px solid #ccc;">';
        echo '<h3>Debug: Adsplugin Blocks Status</h3>';
        
        $our_blocks = array(
            'adsplugin/adsplugin-block',
            'adsplugin/contact-block', 
            'adsplugin/hero-block'
        );
        
        foreach ( $our_blocks as $block_name ) {
            if ( isset( $blocks[ $block_name ] ) ) {
                echo "✅ <strong>{$block_name}</strong> - REGISTERED<br>";
                echo "   Title: " . $blocks[ $block_name ]->title . "<br>";
                echo "   Category: " . $blocks[ $block_name ]->category . "<br><br>";
            } else {
                echo "❌ <strong>{$block_name}</strong> - NOT FOUND<br><br>";
            }
        }
        
        echo '<p>Add <code>?debug_blocks=1</code> to any admin URL to see this debug info.</p>';
        echo '</div>';
    }
}
add_action( 'admin_notices', 'debug_adsplugin_blocks' );
