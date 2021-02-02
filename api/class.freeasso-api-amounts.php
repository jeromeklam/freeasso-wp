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
        	(object)['id' => 'C', 'label' => esc_html('Tous les gibbons à parrainer'                 ,'freeasso'), 'gte' => 1],
            (object)['id' => 'A', 'label' => esc_html('A parrainer en totalité (280€ ou 23,33€/mois)','freeasso'), 'gte' => 280],
            (object)['id' => 'Z', 'label' => esc_html('Déjà parrainé en totalité'                    ,'freeasso'), 'lte' => 0],
            (object)['id' => '-', 'label' => '---'],
            (object)['id' => 'K', 'label' => esc_html('Restant à parrainer entre 200€ et 279€ '      ,'freeasso'), 'lt' => 280, 'gte' => 200],
            (object)['id' => 'H', 'label' => esc_html('Restant à parrainer entre 100€ et 199€'       ,'freeasso'), 'lt' => 200, 'gte' => 100],
            (object)['id' => 'E', 'label' => esc_html('Restant à parrainer entre 50€ et 99€'         ,'freeasso'), 'lt' => 100, 'gte' => 50],
            (object)['id' => 'B', 'label' => esc_html('Restant à parrainer au maximum 49€'           ,'freeasso'), 'lt' => 50,  'gt'  => 0],
            (object)['id' => '-', 'label' => '---'],
            (object)['id' => 'L', 'label' => esc_html('Restant à parrainer entre 10 et 23€/mois '    ,'freeasso'), 'lt' => 280, 'gte' => 120],
            (object)['id' => 'I', 'label' => esc_html('Restant à parrainer entre 5 et 9€/mois'       ,'freeasso'), 'lt' => 120, 'gte' => 60],
            (object)['id' => 'F', 'label' => esc_html('Restant à parrainer 5€/mois et plus'          ,'freeasso'), 'gte' => 60]
        ];
    }
}