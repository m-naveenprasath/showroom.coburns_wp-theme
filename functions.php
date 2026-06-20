<?php

namespace Flynt;

use Flynt\Utils\FileLoader;

require_once __DIR__ . '/vendor/autoload.php';

if (!defined('WP_ENV')) {
    define('WP_ENV', 'production');
}

// Check if the required plugins are installed and activated.
// If they aren't, this function redirects the template rendering to use
// plugin-inactive.php instead and shows a warning in the admin backend.
if (Init::checkRequiredPlugins()) {
    FileLoader::loadPhpFiles('inc');
    add_action('after_setup_theme', ['Flynt\Init', 'initTheme']);
    add_action('after_setup_theme', ['Flynt\Init', 'loadComponents'], 101);
}

// Add excerpt support for page post type
add_action('init', function () {
    add_post_type_support('page', 'excerpt');
});

function be_dps_no_results_search( $message ) {

	$message = '<div class="display-posts-listing no-results">';
	$message .= '<p>Interested in learning more? Be sure to check back here for new related content or visit our <a href="https://lightgray-goat-239778.hostingersite.com/blog/" target="_blank">blog<a/> for other project tips and insights.</p>';
	$message .= '</div>';

	return $message;
}