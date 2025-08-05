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

//check for OPENAI_API_KEY
if ( ! defined( 'OPENAI_API_KEY' ) || empty( OPENAI_API_KEY ) ) {
	wp_die( __( 'The OPENAI_API_KEY constant is not defined or is empty. Please set it in your wp-config.php file.', 'adsplugin-block' ) );
}
// Define plugin version
if ( ! defined( 'ADPLUGIN_BLOCK_VERSION' ) ) {
	define( 'ADPLUGIN_BLOCK_VERSION', '0.1.0' );
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
            'adsplugin/hero-block',
			'adsplugin/block-ai-product-description'
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

add_action('rest_api_init', function () {
    register_rest_route('adsplugin/v1', '/generate-description', [
        'methods'  => 'POST',
        'callback' => 'adsplugin_generate_description',
        'permission_callback' => '__return_true',
    ]);
});

function adsplugin_generate_description($request) {
    $params = $request->get_json_params();
    $title = sanitize_text_field($params['title'] ?? '');

    if (empty($title)) {
        return new WP_Error('no_title', 'Geen producttitel opgegeven', ['status' => 400]);
    }

    $api_key = defined('OPENAI_API_KEY') ? OPENAI_API_KEY : '';
    if (!$api_key) {
        return new WP_Error('no_key', 'OpenAI API key ontbreekt', ['status' => 500]);
    }

    $prompt = "Schrijf een overtuigende korte productomschrijving voor het volgende product:\n\n"
        . "Product: $title\n\n"
        . "Toon: vriendelijk en inspirerend\n"
        . "Lengte: maximaal 100 woorden\n\n";

    $response = wp_remote_post('https://api.openai.com/v1/chat/completions', [
        'headers' => [
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type'  => 'application/json',
        ],
        'body'    => json_encode([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'Je bent een creatieve copywriter.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7,
        ]),
    ]);

    if (is_wp_error($response)) {
        return new WP_Error('api_error', 'Fout bij OpenAI-aanroep', ['status' => 500]);
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    $text = $body['choices'][0]['message']['content'] ?? '';

    return ['description' => trim($text)];
}
