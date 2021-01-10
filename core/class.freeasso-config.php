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
    private $ws_base_url = 'http://kalaweit-bo-dev.freeasso.fr:8180/api';

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
        $datas = new \stdClass();
        $datas->wsBaseurl = $this->getWsBaseUrl();
        $datas->apiId = $this->getApiId();
        $datas->hawkUser = $this->getHawkUser();
        $datas->hawkKey = $this->getHawkKey();
        $rawConfig = json_encode($datas);
        return add_option(self::FREEASSO_CONFIG, $rawConfig);
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
}
