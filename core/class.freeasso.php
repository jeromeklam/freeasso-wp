<?php

/**
 * FreeAsso generic
 *
 * @author jeromeklam
 *
 */
class Freeasso
{

    /**
     * Instance
     *
     * @var Freeasso
     */
    private static $instance = null;

    /**
     * Config, just for fun, it's a singleton
     *
     * @var Freeasso_Config
     */
    private $config = null;

    /**
     * PHP session
     * @var Freeasso_Session
     */
    private $session = null;

    /**
     * Constructor
     */
    protected function __construct()
    {
        register_setting(FREEASSO, 'manage_options', 'trim');
        $this->config = Freeasso_Config::getInstance();
    }

    /**
     * Get instance
     *
     * @return Freeasso
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Check db version
     */
    public function dbCheck()
    {
        $dbVers = str_replace('V', '', strtoupper($this->getConfig()->getDbVersion()));
        $plVers = str_replace('V', '', strtoupper(FREEASSO_VERSION));
        if ($dbVers == '' || version_compare($dbVers, $plVers) < 0) {
            // Need dbUpgrade
            $updater = Freeasso_Migration::getInstance();
            $updater->upgrade($dbVers, $plVers);
            // no exception, then ok
            $this->getConfig()->setDbVersion(FREEASSO_VERSION)->saveConfig();
        }
    }

    /**
     * Get member from freeAsso
     */
    public function initMember()
    {
        $user  = wp_get_current_user();
        $email = null;
        $jwt   = $this->session->get('client-jwt', null);
        $token = null;
        if ($user && $user->ID) {
            $email = $user->user_email;
            /*
            if (!$jwt) {
                $token = get_user_meta($user->ID, 'freeasso-client-token', true);
                $auth  = Freeasso_Api_Auth::getFactory();
                $auth->login($token, $token . '##' . $user->ID);
            } else {
                $this->session->set('client-jwt', null);
            }
        } else {
            $this->session->set('client-jwt', null);
            */
        }
        $this->session->set('member-email', $email);
    }

    /**
     * init hooks
     *
     * @return Freeasso
     */
    public function initHooks()
    {
        // Sessions
        $this->initSession();
        // Filters
        $this->initFilters();
        // Check user
        $this->initMember();
        // Actions
        $this->initActions();
        // Shortcodes
        $this->initShortcodes();
        // End
        return $this;
    }

    /**
     * Get global FreeAsso config
     *
     * @return Freeasso_Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get PHP Session
     *
     * @return \Freeasso_Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Replace stats placeholders by real content
     *
     * @param string $p_content
     *
     * @return string
     */
    public static function filterStats($p_content)
    {
        if (Freeasso_Tools::isHuman()) {
            $stats = Freeasso_Api_Stats::getFactory();
            $content = $p_content;
            if ($stats) {
                $content = $stats->regExpReplace($content);
            }
            return $content;
        }
        return $p_content;
    }

    /**
     * Start PHP session
     *
     * @return Freeasso
     */
    protected function initSession()
    {
        $this->session = \Freeasso_Session::getInstance();
        return $this;
    }

    /**
     * add_filter
     *
     * @return Freeasso
     */
    protected function initFilters()
    {
        add_filter('the_content', [
            &$this,
            'filterStats'
        ]);
        return $this;
    }

    /**
     * add_action
     *
     * @return Freeasso
     */
    protected function initActions()
    {
        add_action('wp_head', [
            &$this,
            'filterStats'
        ]);
        add_action('wp_footer', [
            &$this,
            'filterStats'
        ]);
        if (Freeasso_Tools::bodyOpenExists()) {
            add_action('wp_body_open', [
                &$this,
                'filterStats'
            ], 1);
        }
        return $this;
    }

    /**
     * add_shortcode
     *
     * @return Freeasso
     */
    protected function initShortcodes()
    {
        $freeStats = Freeasso_Stats::getInstance();
        $freeCauses = Freeasso_Causes_Search::getInstance();
        $freeMember = Freeasso_Member::getInstance();
        add_shortcode('FreeAsso_Gibbons', [
            &$freeStats,
            'echoGibbons'
        ]);
        add_shortcode('FreeAsso_Hectares', [
            &$freeStats,
            'echoHectares'
        ]);
        add_shortcode('FreeAsso_Amis', [
            &$freeStats,
            'echoAmis'
        ]);
        add_shortcode('FreeAsso_Causes', [
            &$freeCauses,
            'echoForm'
        ]);
        add_shortcode('FreeAsso_Member_Infos', [
            &$freeMember,
            'echoInfos'
        ]);
        return $this;
    }
}
