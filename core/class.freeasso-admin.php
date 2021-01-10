<?php

/**
 * Administration part
 *
 * @author jeromeklam
 *
 */
class Freeasso_Admin extends Freeasso_View
{

    /**
     * Instance
     * @var Freeasso_Admin
     */
    private static $instance = null;

    /**
     * Config
     * @var Freeasso_Config
     */
    protected $config = null;

    /**
     * Config test
     * @var boolean
     */
    protected $configOK = false;

    /**
     * Get only one instance
     *
     * @return Freeasso_Admin
     */
    public static function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Init hooks
     *
     * @return Freeasso_Admin
     */
    public function initHooks()
    {
        add_action('admin_init', [
            &$this,
            'adminInit'
        ]);
        add_action('admin_menu', [
            &$this,
            'adminMenu'
        ], 5);
        return $this;
    }

    /**
     * Init admin
     */
    public function adminInit()
    {
        $this->config = Freeasso_Config::getInstance();

    }

    /**
     * Test config
     */
    public function testConfig()
    {
        $wsTest = Freeasso_Api_Sites::getFactory();
        $sites = $wsTest->getSites();
        if (is_array($sites) && count($sites) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Init menu
     */
    public function adminMenu()
    {
        if (class_exists('Jetpack')) {
            add_action('jetpack_admin_menu', [
                &$this,
                'loadMenu'
            ]);
        } else {
            $this->loadMenu();
        }
    }

    /**
     * Load Menu
     */
    public function loadMenu()
    {
        if (class_exists('Jetpack')) {
            $hook = add_submenu_page(
                'jetpack',
                __('FreeAsso', 'freeasso'),
                __('FreeAsso', 'freeasso'),
                'manage_options',
                Freeasso_Config::FREEASSO_CONFIG,
                [
                    &$this,
                    'handleConfigPage'
                ]
            );
        } else {
            $hook = add_options_page(
                __('FreeAsso', 'freeasso'),
                __('FreeAsso', 'freeasso'),
                'manage_options',
                Freeasso_Config::FREEASSO_CONFIG,
                [
                    &$this,
                    'handleConfigPage'
                ]
            );
        }
        if ($hook) {
            add_action("load-$hook", [
                &$this,
                'adminHelp'
            ]);
        }
    }

    /**
     * Help
     */
    public function adminHelp()
    {
        $current_screen = get_current_screen();
    }

    /**
     * Display config page
     */
    public function handleConfigPage()
    {
        // Authorized ??
        if (! current_user_can('administrator')) {
            echo '<p>' . __('Sorry, you are not allowed to access this page.', 'freeasso_admin') . '</p>';
            return;
        }
        $this->initView();
        // Save Settings
        if (isset($_REQUEST['submit'])) {
            // Check nonce
            if (! isset($_REQUEST[$this->pluginName . '_nonce'])) {
                // Missing nonce
                $this->errorMessage = __( 'Erreur technique de validation du formulaire.', 'freeasso' );
            } else {
                if (! wp_verify_nonce($_REQUEST[$this->pluginName . '_nonce' ], $this->pluginName)) {
                    // Invalid nonce
                    $this->errorMessage = __( 'Erreur technique de validation du formulaire.', 'freeasso' );
                } else {
                    // Save
                    $this->config->setWsBaseUrl($_REQUEST['freeasso_ws_base_url']);
                    $this->config->setApiId($_REQUEST['freeasso_api_id']);
                    $this->config->setHawkUser($_REQUEST['freeasso_hawk_user']);
                    $key = trim($_REQUEST['freeasso_hawk_key']);
                    if ($key != '') {
                        $this->config->setHawkKey($key);
                    }
                    $this->config->saveConfig();
                    $this->message = __( 'Configuration enregistrée', 'freeasso' );
                }
            }
        }


        $this->configOK = $this->testConfig();
        $this->includeView('config', Freeasso_Config::FREEASSO_CONFIG);
    }
}
