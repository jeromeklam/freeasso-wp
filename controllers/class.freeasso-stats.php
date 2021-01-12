<?php

/**
 *
 * @author jeromeklam
 *
 */
class Freeasso_Stats
{

    /**
     * Instance
     *
     * @var Freeasso_Causes_Search
     */
    private static $instance = null;

    /**
     * Constructor
     */
    protected function __construct()
    {}

    /**
     * Get instance
     *
     * @return Freeasso_Causes_Search
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Echo Amis
     *
     * @param boolean $p_formated
     *
     * @return void
     */
    public function echoAmis($p_formated = true)
    {
        $freestats = Freeasso_Api_Stats::getFactory();
        echo $freestats->getAmis($p_formated);
    }

    /**
     * Echo Gibbons
     *
     * @param boolean $p_formated
     *
     * @return void
     */
    public function echoGibbons($p_formated = true)
    {
        $freestats = Freeasso_Api_Stats::getFactory();
        echo $freestats->getGibbons($p_formated);
    }

    /**
     * Echo Hectares
     *
     * @param boolean $p_formated
     *
     * @return void
     */
    public function echoHectares($p_formated = true)
    {
        $freestats = Freeasso_Api_Stats::getFactory();
        echo $freestats->getHectares($p_formated);
    }
}
