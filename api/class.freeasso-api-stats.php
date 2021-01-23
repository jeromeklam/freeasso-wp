<?php

/**
 * Basic staistics (public access)
 *
 * @author jeromeklam
 *
 */
class Freeasso_Api_Stats extends Freeasso_Api_Base {

    /**
     * Amis
     * @var number
     */
    protected $amis = null;

    /**
     * Formated string for "Amis"
     * @var string
     */
    protected $amis_formated = '';

    /**
     * Hectares
     * @var number
     */
    protected $hectares = null;

    /**
     * Formated string for Hectares
     * @var string
     */
    protected $hectares_formated = null;

    /**
     * Gibbons
     * @var number
     */
    protected $gibbons = null;

    /**
     * Formated string for Gibbons
     * @var string
     */
    protected $gibbons_formated = null;

    /**
     * Get Amis
     *
     * @param boolean $p_formated
     *
     * @return string
     */
    public function getAmis($p_formated = true)
    {
        if ($this->amis === null) {
            $this->getWS();
        }
        if ($p_formated === true) {
            return $this->amis_formated;
        }
        return $this->amis;
    }

    /**
     * Get Hectares
     *
     * @param boolean $p_formated
     *
     * @return string
     */
    public function getHectares($p_formated = true)
    {
        if ($this->hectares === null) {
            $this->getWS();
        }
        if ($p_formated === true) {
            return $this->hectares_formated;
        }
        return $this->hectares;
    }

    /**
     * Get Gibbons
     *
     * @param boolean $p_formated
     *
     * @return string
     */
    public function getGibbons($p_formated = true)
    {
        if ($this->gibbons === null) {
            $this->getWS();
        }
        if ($p_formated === true) {
            return $this->gibbons_formated;
        }
        return $this->gibbons;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $this
            ->setMethod(self::FREEASSO_METHOD_GET)
            ->setUrl('/dashboard/stats')
        ;
    }

    /**
     * Set Amis
     *
     * @param mixed $p_amis
     *
     * @return Freeasso_Api_Stats
     */
    protected function setAmis($p_amis)
    {
        $this->amis = intval($p_amis);
        $this->amis_formated = number_format($this->amis, 0, '.', ' ');
        return $this;
    }

    /**
     * Set Hectares
     *
     * @param mixed $p_hectares
     *
     * @return Freeasso_Api_Stats
     */
    protected function setHectares($p_hectares)
    {
        $this->hectares = intval($p_hectares);
        $this->hectares_formated = number_format($this->hectares, 0, '.', ' ');
        return $this;
    }

    /**
     * Set Gibbons
     *
     * @param mixed $p_gibbons
     *
     * @return Freeasso_Api_Stats
     */
    protected function setGibbons($p_gibbons)
    {
        $this->gibbons = intval($p_gibbons);
        $this->gibbons_formated = number_format($this->gibbons, 0, '.', ' ');
        return $this;
    }

    /**
     * Get WS result
     *
     * @return boolean
     */
    protected function getWS()
    {
        $result = $this->call();
        if ($result && is_object($result)) {
            if ($this->getConfig()->getVersion() == 'v1') {
                if (isset($result->amis)) {
                    $this->setAmis($result->amis);
                }
                if (isset($result->gibbons)) {
                    $this->setGibbons($result->gibbons);
                }
                if (isset($result->hectares)) {
                    $this->setHectares($result->hectares);
                }
            } else {
                if (isset($result->total_friends)) {
                    $this->setAmis($result->total_friends);
                }
                if (isset($result->total_cause)) {
                    $this->setGibbons($result->total_cause);
                }
                if (isset($result->hectaresproteges)) {
                    $this->setHectares($result->hectaresproteges);
                }
            }
            return true;
        }
        return false;
    }
}