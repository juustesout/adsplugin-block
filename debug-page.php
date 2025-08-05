<?php
/**
 * Simple debug page for blocks
 * Visit: yoursite.com/wp-content/plugins/ads-general/adsplugin-block/debug-page.php
 */

// Load WordPress
define('WP_USE_THEMES', false);
$wp_load_path = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/wp-load.php';
if (file_exists($wp_load_path)) {
    require_once($wp_load_path);
} else {
    die('WordPress not found. Make sure this file is in the correct plugin directory.');
}

// Check if user is admin
if (!current_user_can('manage_options')) {
    die('Access denied. You must be an administrator.');
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Block Debug Info</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .success { color: green; }
        .error { color: red; }
        .info { background: #f0f0f0; padding: 15px; margin: 10px 0; border-left: 4px solid #0073aa; }
    </style>
</head>
<body>
    <h1>Adsplugin Block Debug Information</h1>
    
    <?php
    $registry = WP_Block_Type_Registry::get_instance();
    $blocks = $registry->get_all_registered();
    
    echo '<div class="info">';
    echo '<h2>Block Registration Status</h2>';
    
    $our_blocks = array(
        'adsplugin/adsplugin-block',
        'adsplugin/contact-block', 
        'adsplugin/hero-block'
    );
    
    foreach ($our_blocks as $block_name) {
        if (isset($blocks[$block_name])) {
            echo '<p class="success">✅ <strong>' . $block_name . '</strong> - REGISTERED</p>';
            echo '<ul>';
            echo '<li>Title: ' . $blocks[$block_name]->title . '</li>';
            echo '<li>Category: ' . $blocks[$block_name]->category . '</li>';
            echo '<li>Description: ' . $blocks[$block_name]->description . '</li>';
            echo '</ul><br>';
        } else {
            echo '<p class="error">❌ <strong>' . $block_name . '</strong> - NOT FOUND</p>';
        }
    }
    
    echo '<h2>All blocks containing "adsplugin":</h2>';
    $found_any = false;
    foreach ($blocks as $name => $block) {
        if (strpos($name, 'adsplugin') !== false) {
            echo '<p>- ' . $name . ' (' . $block->title . ')</p>';
            $found_any = true;
        }
    }
    if (!$found_any) {
        echo '<p class="error">No blocks containing "adsplugin" found.</p>';
    }
    
    echo '<h2>Block Categories:</h2>';
    $categories = get_default_block_categories();
    if (function_exists('get_block_categories')) {
        $post = get_post();
        if (!$post) {
            // Create a dummy post for getting categories
            $post = new WP_Post((object)array('ID' => 0, 'post_type' => 'page'));
        }
        $categories = get_block_categories($post);
    }
    
    foreach ($categories as $category) {
        echo '<p>- ' . $category['slug'] . ': ' . $category['title'];
        if ($category['slug'] === 'ads-general') {
            echo ' <span class="success">✅ Our custom category!</span>';
        }
        echo '</p>';
    }
    
    echo '<h2>Plugin Status:</h2>';
    $plugin_file = 'ads-general/adsplugin-block/adsplugin-block.php';
    if (is_plugin_active($plugin_file)) {
        echo '<p class="success">✅ Plugin is ACTIVE</p>';
    } else {
        echo '<p class="error">❌ Plugin is NOT ACTIVE</p>';
    }
    
    echo '<h2>WordPress Version:</h2>';
    echo '<p>WordPress: ' . get_bloginfo('version') . '</p>';
    echo '<p>PHP: ' . PHP_VERSION . '</p>';
    
    echo '</div>';
    ?>
    
    <p><a href="<?php echo admin_url(); ?>">← Back to WordPress Admin</a></p>
</body>
</html>
