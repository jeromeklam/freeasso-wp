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
     * Config
     * @var Freeasso_Config
     */
    protected $config = null;

    /**
     * Causes
     * @var array
     */
    protected $causes = null;

    /**
     * Gender
     * @var array
     */
    protected $genders = null;

    /**
     * Sites
     * @var array
     */
    protected $sites = null;

    /**
     * Species
     * @var array
     */
    protected $species = null;

    /**
     * Names
     * @var array
     */
    protected $names = null;

    /**
     * Total causes
     * @var integer
     */
    protected $total_causes = 0;

    /**
     * Current page
     * @var integer
     */
    protected $param_page = 1;

    /**
     * page length
     * @var integer
     */
    protected $param_length = 16;

    /**
     * Selected gender
     * @var string
     */
    protected $param_gender = '';

    /**
     * Selected site
     * @var string
     */
    protected $param_site = '';

    /**
     * Selected species
     * @var string
     */
    protected $param_species = '';

    /**
     * Specific Gibbon
     * @var string
     */
    protected $param_names = '';

    /**
     * Current lang
     * @var string
     */
    protected $param_lang = 'fr_FR';

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
    {
        $this->param_lang = get_locale();
        $this->config     = Freeasso_Config::getInstance();
    }

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
     * Get config
     *
     * @return Freeasso_Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Load datas
     *
     * @return Freeasso_Causes_Search
     */
    protected function loadDatas()
    {
        // Gender
        $myGendersApi = FreeAsso_Api_Genders::getFactory();
        $this->genders = $myGendersApi->getGenders();
        // Species
        $mySpeciesApi = FreeAsso_Api_Species::getFactory();
        $this->species = $mySpeciesApi->getMainSpecies();
        // Sites
        $mySitesApi = FreeAsso_Api_Sites::getFactory();
        $this->sites = $mySitesApi->getSites();
        // Names
        $myNamesApi = FreeAsso_Api_Names::getFactory();
        $this->names = $myNamesApi->getNames();
        // Params
        $this->param_page    = $this->getParam('freeasso-cause-search-page', 1);
        $this->param_length  = $this->getParam('freeasso-cause-search-length', 16);
        $this->param_gender  = $this->getparam('freeasso-cause-search-gender', '');
        $this->param_site    = $this->getparam('freeasso-cause-search-site', '');
        $this->param_species = $this->getparam('freeasso-cause-search-species', '');
        $this->param_names   = $this->getparam('freeasso-cause-search-names', '');
        // Filters
        $myCausesApi = FreeAsso_Api_Causes::getFactory();
        $myCausesApi->setPagination($this->param_page, $this->param_length);
        // If specific Gibbon, prioritary, no other filters, but keeped
        if ($this->param_names != '') {
            $myCausesApi->setId($this->param_names);
        } else {
            //
            if ($this->param_gender != '') {
                $myCausesApi->addSimpleFilter('cau_sex', $this->param_gender);
            }
            if ($this->param_site != '') {
                $myCausesApi->addSimpleFilter('site.id', $this->param_site);
            }
            if ($this->param_species != '') {
                foreach ($this->species as $oneSpecies) {
                    if ($oneSpecies->id == $this->param_species) {
                        $myCausesApi->addSimpleFilter('subspecies.id', $oneSpecies->all, Freeasso_Api_Base::OPER_IN);
                        break;
                    }
                }
            }
        }
        $updateCauses = true;
        if ($this->causes === null || $updateCauses) {
            $this->causes       = $myCausesApi->getCauses();
            $this->total_causes = $myCausesApi->getTotalCauses();
        }
        var_dump($this->param_lang);
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
