<?php

/**
 * The age of the animals
 */
class Freeasso_Api_Ages extends Freeasso_Api_Base
{

    /**
     * Amount
     *
     * @var array
     */
    protected $ageRanges = null;

    /**
     * Get all sites
     *
     * @return array
     */
    public function getAgeRanges()
    {
        return $this->ageRanges;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $this->ageRanges = [
            (object)['id' => 'young'     , 'label' => translate('Moins de 5 ans','freeasso'), 'lt' => 5],
            (object)['id' => 'youngAdult', 'label' => translate('De 5 à 10 ans' ,'freeasso'), 'gte'=>5, 'lt' => 10],
            (object)['id' => 'adult'     , 'label' => translate('De 10 à 15 ans','freeasso'), 'gte'=>10, 'lt' => 15],
            (object)['id' => 'old'       , 'label' => translate('Plus de 15 ans','freeasso'), 'lt'=>1000, 'gte'=>15] // lt 1000 : workaround pour bug
        ];
    }
}