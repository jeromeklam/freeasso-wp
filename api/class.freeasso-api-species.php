<?php

/**
 * The animals species (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Species extends Freeasso_Api_Base
{

    /**
     * Species
     * @var array
     */
    protected $species = null;

    /**
     * Compressed Species
     * @var array
     */
    protected $main_species = null;

    /**
     * Get all species
     *
     * @return array
     */
    public function getSpecies()
    {
        if ($this->species === null) {
            $this->getWS();
        }
        return $this->species;
    }

    /**
     * Get main species
     *
     * @return array
     */
    public function getMainSpecies()
    {
        if ($this->main_species === null) {
            $this->getWS();
        }
        return $this->main_species;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/subspecies');
        $this->setPrivate();
        $this->addSortField('sspe_name');
    }

    /**
     * Set species
     *
     * @param array $p_species
     *
     * @return Freeasso_Api_Species
     */
    protected function setSpecies($p_species)
    {
        $this->species = [];
        $this->main_species = [];
        foreach ($p_species as $oneSpecies) {
            $spe = new StdClass();
            $spe->id = $oneSpecies->sspe_id;
            $spe->code = $oneSpecies->sspe_id;
            $spe->label = $oneSpecies->sspe_name;
            $this->species[] = $spe;
            $name = trim($spe->label);
            if (($pos = strpos($name, '(')) !== false) {
                $name = trim(substr($name, 0, $pos));
            }
            $found = false;
            foreach ($this->main_species as $idx => $value) {
                if (strtolower($value->label) == strtolower($name)) {
                    $found = true;
                    $this->main_species[$idx]->all[] = $spe->id;
                    break;
                }
            }
            if (!$found) {
                $spe->label = $name;
                $spe->all = [];
                $spe->all[] = $spe->id;
                $this->main_species[] = $spe;
            }
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
                $species = $result->data;
            } else {
                $species = $result;
            }
            $this->setSpecies($species);
            return true;
        }
        $this->setSpecies([]);
        return false;
    }
}