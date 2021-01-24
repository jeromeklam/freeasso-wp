<?php
/**
 * Plugin Name: FreeAsso
 * Description: Plugin de gestion des liens avec l'administration FreeAsso.
 * Author: KLAM Jérôme
 * Plugin URI: http://github.com/jeromeklam/freeasso-wp
 * Version: 1.0.0
 * Author URI: http://github.com/jeromeklam
 */

// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
// Make sure we don't expose any info if called directly
// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
if (! function_exists('add_action')) {
    echo 'I\'m just a plugin !!';
    exit();
}

// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
// Basic constants
// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
define('FREEASSO', 'FreeAsso');
define('FREEASSO_VERSION', '1.0.4');
define('FREEASSO_MINIMUM_WP_VERSION', '5.6');
define('FREEASSO_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FREEASSO_PLUGIN_NAME', 'FreeAsso-WP');

// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
// Ugly way, no PSR, :(
// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso-tools.php';
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso-migration.php';
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso-session.php';
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso-view.php';
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso-api-base.php';
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso-config.php';
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso.php';
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso-admin.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-amounts.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-cause.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-causes.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-genders.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-names.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-sites.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-species.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-stats.php';
require_once FREEASSO_PLUGIN_DIR . 'controllers/class.freeasso-causes-search.php';
require_once FREEASSO_PLUGIN_DIR . 'controllers/class.freeasso-stats.php';
require_once FREEASSO_PLUGIN_DIR . 'widgets/class.freeasso-widget-amis.php';
require_once FREEASSO_PLUGIN_DIR . 'widgets/class.freeasso-widget-causes.php';
require_once FREEASSO_PLUGIN_DIR . 'widgets/class.freeasso-widget-hectares.php';
require_once FREEASSO_PLUGIN_DIR . 'widgets/class.freeasso-widget-gibbons.php';

// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
// All init here
// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
$freeasso = Freeasso::getInstance();

//
add_action('plugins_loaded', [
    &$freeasso,
    'dbCheck'
]);
// Go all
add_action('init', [
    &$freeasso,
    'initHooks'
]);

// Go admin
if (is_admin() || (defined('WP_CLI') && WP_CLI)) {
    $freeassoAdmin = Freeasso_Admin::getInstance();
    add_action('init', [
        &$freeassoAdmin,
        'initHooks'
    ]);
}

// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
// That's All Folks !
// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------