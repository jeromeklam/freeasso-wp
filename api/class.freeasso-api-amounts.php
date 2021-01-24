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
            (object)['id' => 'A', 'label' => 'A parrainer en totalité', 'gte' => 280],
            (object)['id' => 'B', 'label' => 'Restant à parrainer au maximum 50€', 'ltwe' => 50],
            (object)['id' => 'E', 'label' => 'Restant à parrainer entre 50€ et 100€', 'ltwe' => 100, 'gte' => 50],
            (object)['id' => 'H', 'label' => 'Restant à parrainer entre 100€ et 200€', 'ltwe' => 200, 'gte' => 100],
            (object)['id' => 'K', 'label' => 'Restant à parrainer entre 200€ et 280€', 'ltwe' => 280, 'gte' => 200],
            (object)['id' => 'Z', 'label' => 'Parrainé en totalité', 'ltwe' => 0]
        ];
    }
}