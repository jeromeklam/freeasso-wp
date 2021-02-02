<?php

/**
 * The gender
 *
 * @author jeromeklam
 */
class Freeasso_Api_Amounts extends Freeasso_Api_Base
{

    /**
     * Amount
     *
     * @var array
     */
    protected $amounts = null;

    /**
     * Get all sites
     *
     * @return array
     */
    public function getAmounts()
    {
        return $this->amounts;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $this->amounts = [
        	(object)['id' => 'C', 'label' => translate('Tous les gibbons à parrainer'            ,'freeasso'), 'gte' => 1],
            (object)['id' => 'A', 'label' => translate('280€ ou 23,33€/mois (parrainage complet)','freeasso'), 'gte' => 280],
            (object)['id' => 'Z', 'label' => translate('Déjà parrainé en totalité'               ,'freeasso'), 'lte' => 0],
            (object)['id' => '-', 'label' => '---'],
            (object)['id' => 'K', 'label' => translate('200 à 279€'       ,'freeasso'), 'lt' => 280, 'gte' => 200],
            (object)['id' => 'H', 'label' => translate('100 à 199€'       ,'freeasso'), 'lt' => 200, 'gte' => 100],
            (object)['id' => 'E', 'label' => translate('50 à 99€'         ,'freeasso'), 'lt' => 100, 'gte' => 50],
            (object)['id' => 'B', 'label' => translate('1 à 49€'          ,'freeasso'), 'lt' => 50,  'gt'  => 0],
            (object)['id' => '-', 'label' => '---'],
            (object)['id' => 'L', 'label' => translate('10 à 23€/mois'    ,'freeasso'), 'lt' => 280, 'gte' => 120],
            (object)['id' => 'I', 'label' => translate('5 à 9€/mois'      ,'freeasso'), 'lt' => 120, 'gte' => 60],
            (object)['id' => 'F', 'label' => translate('5€/mois et plus'  ,'freeasso'), 'gte' => 60]
        ];
    }
}