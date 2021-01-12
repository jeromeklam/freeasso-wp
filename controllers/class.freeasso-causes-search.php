<?php

/**
 *
 * @author jeromeklam
 *
 */
class Freeasso_Causes_Search
{

    /**
     * Behaviour
     */
    use Freeasso_View;

    /**
     * Causes
     * @var array
     */
    protected $causes = null;

    /**
     * Gender
     * @var array
     */
    protected $gender = null;

    /**
     * Sites
     * @var array
     */
    protected $sites = null;

    /**
     * Instance
     *
     * @var Freeasso_Causes_Search
     */
    private static $instance = null;

    /**
     * Constructor
     */
    protected function __construct()
    {}

    /**
     * Get instance
     *
     * @return Freeasso_Causes_Search
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Load datas
     *
     * @return Freeasso_Causes_Search
     */
    protected function loadDatas()
    {
        // Ugly cache in session...
        $wp_session = WP_Session::get_instance();
        // Gender
        if ($this->gender === null) {
            if (!isset($wp_session['freeasso_gender'])) {
                $wp_session['freeasso_gender'] = [
                    (object)['id' => 'F', 'label' => 'Femelle'],
                    (object)['id' => 'M', 'label' => 'Mâle']
                ];
                $wp_session['freeasso_gender.ts'] = microtime(true); // @todo, cache delay in admin field
            }
            $this->gender = $wp_session['freeasso_gender'];
        }
        // Causes & Filters
        $myCausesApi = FreeAsso_Api_Causes::getFactory();
        $gender = $this->getParam('freeasso-cause-search-gender');
        if ($gender != '') {
            $myCausesApi->addSimpleFilter('cau_sex', $gender);
        }
        $site = $this->getParam('freeasso-cause-search-site');
        if ($site != '') {
            $myCausesApi->addSimpleFilter('site.id', $site);
        }
        $species = $this->getParam('freeasso-cause-search-species');
        if ($species != '') {
            $mySpeciesApi = FreeAsso_Api_Species::getFactory();
            foreach ($mySpeciesApi->getMainSpecies() as $oneSpecies) {
                if ($oneSpecies->id == $species) {
                    $myCausesApi->addSimpleFilter('subspecies.id', $oneSpecies->all, Freeasso_Api_Base::OPER_IN);
                    break;
                }
            }
        }
        $updateCauses = true;
        if ($this->causes === null || $updateCauses) {
            if ($updateCauses || !isset($wp_session['freeasso_causes'])) {
                $wp_session['freeasso_causes'] = $myCausesApi->getCauses();
                $wp_session['freeasso_causes.ts'] = microtime(true); // @todo, cache delay in admin field
            }
            $this->causes = $wp_session['freeasso_causes'];
        }
        // Sites
        if ($this->sites === null) {
            if (true || !isset($wp_session['freeasso_sites'])) {
                $mySitesApi = FreeAsso_Api_Sites::getFactory();
                $wp_session['freeasso_sites'] = $mySitesApi->getSites();
                $wp_session['freeasso_sites.ts'] = microtime(true); // @todo, cache delay in admin field
            }
            $this->sites = $wp_session['freeasso_sites'];
        }
        // Species
        if ($this->species === null) {
            if (!isset($wp_session['freeasso_species'])) {
                $mySpeciesApi = FreeAsso_Api_Species::getFactory();
                $wp_session['freeasso_species'] = $mySpeciesApi->getMainSpecies();
                $wp_session['freeasso_species.ts'] = microtime(true); // @todo, cache delay in admin field
            }
            $this->species = $wp_session['freeasso_species'];
        }
        // End
        return $this;
    }

    /**
     * Display searchform
     *
     * @return void
     */
    public function echoForm()
    {
        $this
            ->loadParams()
            ->loadDatas()
        ;
        $this->includeView('cause-search', 'freeasso-causes-search');
    }
}
