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
            (object)['id' => 'young'     , 'label' => esc_html('Moins de 5 ans','freeasso'), 'lte' => 5],
            (object)['id' => 'youngAdult', 'label' => esc_html('De 5 à 10 ans' ,'freeasso'), 'lte' => 10, 'gte'=>5],
            (object)['id' => 'adult'     , 'label' => esc_html('De 10 à 15 ans','freeasso'), 'lte' => 15, 'gte'=>10],
            (object)['id' => 'old'       , 'label' => esc_html('Plus de 15 ans','freeasso'), 'gte'=>15]
        ];
    }
}