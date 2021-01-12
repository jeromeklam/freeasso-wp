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
        if (! self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * init hooks
     *
     * @return Freeasso
     */
    public function initHooks()
    {
        // Filters
        $this->initFilters();
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
        return $this;
    }
}
