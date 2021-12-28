<?php

/**
 * The animals locations (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Sites extends Freeasso_Api_Base
{

    /**
     * Sites
     *
     * @var array
     */
    protected $sites = null;

    /**
     * Get all sites
     *
     * @return array
     */
    public function getSites()
    {
        if ($this->sites === null) {
            $this->getWS();
        }
        return $this->sites;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/site');
        $this->setPrivate();
    }

    /**
     * Set sites
     *
     * @param array $p_sites
     *
     * @return Freeasso_Api_Sites
     */
    protected function setSites($p_sites)
    {
        $this->sites = [];
        foreach ($p_sites as $oneSite) {
            $site = new StdClass();
            $site->id = $oneSite->site_id;
            $site->code = $oneSite->site_code;
            if ($site->code == '') {
                $site->code = $oneSite->site_id;
            }
            $site->label = $oneSite->site_name;
            $this->sites[] = $site;
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
                $sites = $result->data;
            } else {
                $sites = $result;
            }
            $this->setSites($sites);
            return true;
        }
        $this->setSites([]);
        return false;
    }
}