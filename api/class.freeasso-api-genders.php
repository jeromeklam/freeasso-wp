<?php

/**
 * The gender
 *
 * @author jeromeklam
 */
class Freeasso_Api_Genders extends Freeasso_Api_Base
{

    /**
     * Genders
     *
     * @var array
     */
    protected $genders = null;

    /**
     * Get all sites
     *
     * @return array
     */
    public function getGenders()
    {
        return $this->genders;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $this->genders = [
            (object)['id' => 'F', 'label' => 'Femelle'],
            (object)['id' => 'M', 'label' => 'Mâle']
        ];
    }
}