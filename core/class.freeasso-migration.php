<?php

/**
 * FreeAsso migration tools
 *
 * @author jeromeklam
 *
 */
class Freeasso_Migration
{

    /**
     * Instance
     * @var Freeasso_Migration
     */
    private static $instance = null;

    /**
     * Wordpress DB
     * @var unknown
     */
    protected $wpdb = null;

    /**
     * Config
     * @var Freeasso_Config
     */
    protected $config = null;

    /**
     * Constructor
     */
    protected function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->config = Freeasso_Config::getInstance();
    }

    /**
     * Get instance
     *
     * @return Freeasso_Migration
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Ugly upgrade function
     *
     * @param string $p_from
     * @param string $p_to
     */
    public function upgrade($p_from, $p_to)
    {
        if ($p_from == '') {
            $p_from = '1.0.0';
        }
        // No break to upgrade from first matching version
        switch ($p_from) {
            case '1.0.0':
                $table_name = $this->wpdb->prefix . 'freeasso_log';
                $sql = "CREATE TABLE $table_name (
                    log_id bigint(20) NOT NULL AUTO_INCREMENT,
                    log_level tinyint(2) NOT NULL DEFAULT 0,
                    log_function varchar(255) DEFAULT NULL,
                    log_message varchar(255) DEFAULT NULL,
                    log_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                    log_data longtext DEFAULT NULL,
                    PRIMARY KEY  (log_id)
                );";
                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                $result = dbDelta($sql);
                if (count($result) <= 0) {
                    // Error
                    Freeasso_Tools::throwException('Error version 1.0.0');
                }
                $this->getConfig()->setDbVersion('V1.0.0')->saveConfig();
            default;
                break;
        }
        return true;
    }

    /**
     * Get config
     * @return unknown
     */
    public function getConfig()
    {
        return $this->config;
    }
}
