<?php

/**
 * FreeAsso config
 *
 * Config load, save, ...
 * Getters and Setters for config vars
 *
 * @author jeromeklam
 *
 */
class Freeasso_Config
{

    /**
     * Constants
     * @var string
     */
    const FREEASSO_CONFIG = 'freeasso-config';

    /**
     * Local instance, singleton
     * @var Freeasso_Config
     */
    private static $instance = null;

    /**
     * Base url, no / at end and no version
     * @var string
     */
    private $ws_base_url = 'http://kalaweit-bo-dev.freeasso.fr:8180/api/v1/asso';

    /**
     * Api ID, see FreeAsso
     * @var string
     */
    private $api_id = 'kalaweit';

    /**
     * Hawk User, see FreeAsso
     * @var string
     */
    private $hawk_user = 'kalaweit-site';

    /**
     * Hawk key, see FreeAsso
     * @var string
     */
    private $hawk_key = '30964d295d6f673df7dc75600ac6f345';

    /**
     * Admin version
     * @var string
     */
    private $version = 'v2';

    /**
     * Small image prefix (url)
     * @var string
     */
    private $image_small_prefix = null;

    /**
     * Standard image prefix
     * @var string
     */
    private $image_standard_prefix = null;

    /**
     * Small images suffix
     * @var string
     */
    private $image_small_suffix = null;

    /**
     * Standard image suffix
     * @var string
     */
    private $image_standard_suffix = null;

    /**
     * Database vesion
     * @var string
     */
    private $db_version = null;

    /**
     * Log level
     * @var integer
     */
    private $db_log_level = 0;

    /**
     * Constructor, only global class and uniq instance
     */
    protected function __construct()
    {
        $this->loadConfig();
    }

    /**
     * Load config
     *
     * @return Freeasso_Config
     */
    public function loadConfig()
    {
        $rawConfig = get_option(self::FREEASSO_CONFIG);
        if ($rawConfig) {
            $datas = json_decode($rawConfig);
            if ($datas && is_object($datas)) {
                if ($datas->wsBaseUrl) {
                    $this->setWsBaseUrl($datas->wsBaseUrl);
                }
                if ($datas->apiId) {
                    $this->setApiId($datas->apiId);
                }
                if ($datas->hawkUser) {
                    $this->setHawkUser($datas->hawkUser);
                }
                if ($datas->hawkKey) {
                    $this->setHawkKey($datas->hawkKey);
                }
                if ($datas->version) {
                    $this->setVersion($datas->version);
                }
                if ($datas->image_small_prefix) {
                    $this->setImageSmallPrefix($datas->image_small_prefix);
                }
                if ($datas->image_standard_prefix) {
                    $this->setImageStandardPrefix($datas->image_standard_prefix);
                }
                if ($datas->image_small_suffix) {
                    $this->setImageSmallSuffix($datas->image_small_suffix);
                }
                if ($datas->image_standard_suffix) {
                    $this->setImageStandardSuffix($datas->image_standard_suffix);
                }
                if ($datas->db_version) {
                    $this->setDbVersion($datas->db_version);
                }
                if ($datas->db_log_level) {
                    $this->setDbLogLevel($datas->db_log_level);
                }
            }
        }
        return $this;
    }

    /**
     * Save config
     *
     * @return boolean
     */
    public function saveConfig()
    {
        $datas                        = new \stdClass();
        $datas->wsBaseUrl             = $this->getWsBaseUrl();
        $datas->apiId                 = $this->getApiId();
        $datas->hawkUser              = $this->getHawkUser();
        $datas->hawkKey               = $this->getHawkKey();
        $datas->version               = $this->getVersion();
        $datas->image_small_prefix    = $this->getImageSmallPrefix();
        $datas->image_standard_prefix = $this->getImageStandardPrefix();
        $datas->image_small_suffix    = $this->getImageSmallSuffix();
        $datas->image_standard_suffix = $this->getImageStandardSuffix();
        $datas->db_version            = $this->getDbVersion();
        $datas->db_log_level          = $this->getDbLogLevel();
        $rawConfig                    = json_encode($datas);
        return update_option(self::FREEASSO_CONFIG, $rawConfig);
    }

    /**
     * Get instance
     *
     * @return Freeasso_Config
     */
    public static function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Get ws base url
     *
     * @return string
     */
    public function getWsBaseUrl()
    {
        return $this->ws_base_url;
    }

    /**
     * Set ws base url
     *
     * @param string $p_url
     *
     * @return Freeasso_Config
     */
    public function setWsBaseUrl($p_url)
    {
        $this->ws_base_url = $p_url;
        return $this;
    }

    /**
     * Get ws Api Id
     *
     * @return string
     */
    public function getApiId()
    {
        return $this->api_id;
    }

    /**
     * Set ws Api Id
     *
     * @param string $p_id
     *
     * @return Freeasso_Config
     */
    public function setApiId($p_id)
    {
        $this->api_id = $p_id;
        return $this;
    }

    /**
     * Get Hawk user
     *
     * @return string
     */
    public function getHawkUser()
    {
        return $this->hawk_user;
    }

    /**
     * Set Hawk user
     *
     * @param string $p_user
     *
     * @return Freeasso_Config
     */
    public function setHawkUser($p_user)
    {
        $this->hawk_user = $p_user;
        return $this;
    }

    /**
     * Get Hawk key
     *
     * @return string
     */
    public function getHawkKey()
    {
        return $this->hawk_key;
    }

    /**
     * Set hawk key
     *
     * @param string $p_key
     *
     * @return Freeasso_Config
     */
    public function setHawkKey($p_key)
    {
        $this->hawk_key = $p_key;
        return $this;
    }

    /**
     * Set version
     *
     * @param string $p_vers
     *
     * @return Freeasso_Config
     */
    public function setVersion($p_vers)
    {
        if (strtolower($p_vers) == 'v1') {
            $this->version = 'v1';
        } else {
            $this->version = 'v2';
        }
        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set image prefix
     *
     * @param string $p_prefix
     *
     * @return Freeasso_Config
     */
    public function setImageSmallPrefix($p_prefix)
    {
        $this->image_small_prefix = $p_prefix;
        return $this;
    }

    /**
     * Get image prefix
     *
     * @return string
     */
    public function getImageSmallPrefix()
    {
        return $this->image_small_prefix;
    }

    /**
     * Set standard image prefix
     *
     * @param string $p_prefix
     *
     * @return Freeasso_Config
     */
    public function setImageStandardPrefix($p_prefix)
    {
        $this->image_standard_prefix = $p_prefix;
        return $this;
    }

    /**
     * Get image standard prefix
     *
     * @return string
     */
    public function getImageStandardPrefix()
    {
        return $this->image_standard_prefix;
    }

    /**
     * Set image small suffix
     *
     * @param unknown $p_suffix
     *
     * @return Freeasso_Config
     */
    public function setImageSmallSuffix($p_suffix)
    {
        $this->image_small_suffix = $p_suffix;
        return $this;
    }

    /**
     * Get small image suffix
     *
     * @return string
     */
    public function getImageSmallSuffix()
    {
        return $this->image_small_suffix;
    }

    /**
     * Set image standard suffix
     *
     * @param string $p_suffix
     *
     * @return Freeasso_Config
     */
    public function setImageStandardSuffix($p_suffix)
    {
        $this->image_standard_suffix = $p_suffix;
        return $this;
    }

    /**
     * Get image standard suffix
     *
     * @return string
     */
    public function getImageStandardSuffix()
    {
        return $this->image_standard_suffix;
    }

    /**
     * Set db version
     *
     * @param string $p_version
     *
     * @return Freeasso_Config
     */
    public function setDbVersion($p_version)
    {
        $this->db_version = $p_version;
        return $this;
    }

    /**
     * Get Db version
     *
     * @return string
     */
    public function getDbVersion()
    {
        return $this->db_version;
    }

    /**
     * Set Db log level
     *
     * @param integer $p_level
     *
     * @return Freeasso_Config
     */
    public function setDbLogLevel($p_level)
    {
        $this->db_log_level = intval($p_level);
        return $this;
    }

    /**
     * Get Db log level
     *
     * @return integer
     */
    public function getDbLogLevel()
    {
        return $this->db_log_level;
    }
}
