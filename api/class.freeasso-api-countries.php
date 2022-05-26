<?php

/**
 * The countries (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Countries extends Freeasso_Api_Base
{

    /**
     * Countries
     *
     * @var array
     */
    protected $countries = null;

    /**
     * Get all countries
     *
     * @return array
     */
    public function getCountries()
    {
        if ($this->countries === null) {
            $this->getWS();
        }
        return $this->countries;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/core/country');
        $this->setPagination(1, 999);
        $this->setPrivate();
    }

    /**
     * Set countries
     *
     * @param array $p_countries
     *
     * @return Freeasso_Api_Countries
     */
    protected function setCountries($p_countries)
    {
        $this->countries = [];
        foreach ($p_countries as $oneCountry) {
            $country = new StdClass();
            $country->id = $oneCountry->cnty_id;
            $country->code = $oneCountry->cnty_code;
            if ($country->code == '') {
                $country->code = $oneCountry->cnty_id;
            }
            $country->label = $oneCountry->cnty_name;
            $this->countries[] = $country;
        }
        return $this;
    }

    /**
     * Call WS
     *
     * @return boolean
     */
    protected function getWS()
    {
        $result = $this->call();
        if ($result) {
            if (isset($result->data)) {
                $countries = $result->data;
            } else {
                $countries = $result;
            }
            $this->setCountries($countries);
            return true;
        }
        $this->setCountries([]);
        return false;
    }
}