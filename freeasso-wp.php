<?php
/**
 * Plugin Name: FreeAsso
 * Description: Plugin de gestion des liens avec l'administration FreeAsso.
 * Author: KLAM Jérôme
 * Plugin URI: http://github.com/jeromeklam/freeasso-wp
 * Version: 2.1.0
 * Author URI: http://github.com/jeromeklam
 * Text Domain: freeasso-wp
 *
 * ===============================================================================================
 * 2.1.0 : 17/01/2022
 *     Monnaie en option de recherche
 *     Montant parrainé plafonné
 * ===============================================================================================
 * 2.0.3 : 13/10/2021
 *     Ajout de logs
 * ===============================================================================================
 * 2.0.2 : 12/10/2021
 *     Ajout de logs
 * ===============================================================================================
 * 2.0.1 : 10/10/2021
 *     Intégration de la nouvelle version de l'administration freeasso.
 * ===============================================================================================
 * 2.2.0 : 14/05/2022
 *     Test intégration partie membre
 * ===============================================================================================
 * 2.2.1 : 15/05/2022
 *     Suite test intégration partie membre
 * ===============================================================================================
 * 2.2.2 : 26/05/2022
 *     Suite test intégration partie membre
 * ===============================================================================================
 * 2.2.3 : 28/05/2022
 *     Version initiale partie membre
 * ===============================================================================================
 * 2.2.4 : 29/05/2022
 *     Correction problème d'encodage d'url sur l'espace membre
 * ===============================================================================================
 * 2.2.5 : 05/06/2022
 *     Correction problème d'encodage d'url sur l'espace membre
 * ===============================================================================================
 * 2.2.6 : 11/06/2022
 *     Correction hack user
 * ===============================================================================================
 * 2.2.7 : 28/02/2023
 *     Que les paiements OK, donc suppression de la colonne
 * ===============================================================================================
 */

// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
// Write an entry to a log file in the uploads directory.
//
// @since x.x.x
//
// @param mixed $entry String or array of the information to write to the log.
// @param string $file Optional. The file basename for the .log file.
// @param string $mode Optional. The type of write. See 'mode' at https://www.php.net/manual/en/function.fopen.php.
// @return boolean|int Number of bytes written to the lof file, false otherwise.
// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
if (!function_exists('freeasso_wp_log')) {
    function freeasso_wp_log($entry, $mode = 'a', $file = 'freeasso_wp') {
        // Get WordPress uploads directory.
        $upload_dir = wp_upload_dir();
        $upload_dir = $upload_dir['basedir'];
        // If the entry is array, json_encode.
        if (is_array($entry)) {
            $entry = json_encode($entry);
        }
        // Write the log file.
        $file  = $upload_dir . '/' . $file . '.log';
        $file  = fopen($file, $mode);
        $bytes = fwrite($file, current_time('mysql') . "::" . $entry . "\n");
        fclose($file);
        return $bytes;
    }
}

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
define('FREEASSO_VERSION', '2.2.7');
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
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso-user.php';
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso-api-base.php';
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso-config.php';
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso.php';
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso-admin.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-ages.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-amounts.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-auth.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-categories.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-cause.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-causes.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-countries.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-genders.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-langs.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-member.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-member-exists.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-member-certificate.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-member-certificates.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-member-donations.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-member-gibbon.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-member-gibbons.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-member-receipt.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-member-receipts.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-member-sponsorships.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-names.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-payment-type.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-sites.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-species.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-stats.php';
require_once FREEASSO_PLUGIN_DIR . 'controllers/class.freeasso-causes-search.php';
require_once FREEASSO_PLUGIN_DIR . 'controllers/class.freeasso-member.php';
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

add_action('init','freeasso_load_textdomain');
function freeasso_load_textdomain() {
    load_plugin_textdomain('freeasso',false,basename(dirname( __FILE__)).'/languages');
}


// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
// That's All Folks !
// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------