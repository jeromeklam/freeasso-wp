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
     * Cause
     * @var object
     */
    protected $cause = null;

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
     * Ages
     * @var array
     */
    protected $ages = null;

    /**
     * Montants
     * @var array
     */
    protected $amounts = null;

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
     * Ammount
     * @var string
     */
    protected $param_amounts = '';

    /**
     * Filtred age range
     * @var string
     */
    protected $param_age = '';

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
        // Amounts
        $myAmountsApi = FreeAsso_Api_Amounts::getFactory();
        $this->amounts = $myAmountsApi->getAmounts();
        // Age ranges
        $myAgesApi = FreeAsso_Api_Ages::getFactory();
        $this->ages = $myAgesApi->getAgeRanges();
        // Params
        $this->param_page    = $this->getParam('freeasso-cause-search-page', 1);
        $this->param_length  = $this->getParam('freeasso-cause-search-length', 16);
        $this->param_gender  = $this->getparam('freeasso-cause-search-gender', '');
        $this->param_site    = $this->getparam('freeasso-cause-search-site', '');
        $this->param_species = $this->getparam('freeasso-cause-search-species', '');
        $this->param_names   = $this->getparam('freeasso-cause-search-names', '');
        $this->param_amounts = $this->getparam('freeasso-cause-search-amounts', '');
        $this->param_age     = $this->getparam('freeasso-cause-search-age', '');
        
        // Filters
        $myCausesApi = FreeAsso_Api_Causes::getFactory();
        $myCausesApi->setPagination($this->param_page, $this->param_length);
        $myCausesApi->addOption('lang', $this->param_lang);
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
        if ($this->param_amounts != '') {
            foreach ($this->amounts as $oneAmount) {
                if ($oneAmount->id == $this->param_amounts) {
                    $lte=null; $gte=null;
                    if(isset($oneAmount->lte))    $lte=$oneAmount->lte;
                    elseif(isset($oneAmount->lt)) $lte=$oneAmount->lt-.005;
                    if(isset($oneAmount->gte))     $gte=$oneAmount->gte;
                    elseif(isset($oneAmount->gt))  $gte=$oneAmount->gt+.005;
                    if($lte!==null && $gte!==null) {
                        $myCausesApi->addSimpleFilter('cau_mnt_left', $gte, Freeasso_Api_Base::OPER_BETWEEN, $lte);
                    } elseif($lte!==null) {
                        $myCausesApi->addSimpleFilter('cau_mnt_left', $lte, Freeasso_Api_Base::OPER_LOWER_EQUAL);
                    } elseif($gte!==null) {
                        $myCausesApi->addSimpleFilter('cau_mnt_left', $gte, Freeasso_Api_Base::OPER_GREATER_EQUAL);
                    }
                    break;
                }
            }
        }
        if($this->param_age != '' && $this->param_age != '-') {
            foreach ($this->ages as $oneAge) {
                if ($oneAge->id == $this->param_age) {
                    $year = intval(date('Y'));
                    $lte=null; $gte=null;
                    if(isset($oneAge->lte))    $gte=($year - $oneAge->lte);
                    elseif(isset($oneAge->lt)) $gte=($year - $oneAge->lt + 1);
                    if(isset($oneAge->gte))     $lte=($year - $oneAge->gte);
                    elseif(isset($oneAge->gt))  $lte=($year - $oneAge->gt - 1);
                    if($lte!==null && $gte!==null) {
                        $myCausesApi->addSimpleFilter('cau_year', $gte, Freeasso_Api_Base::OPER_BETWEEN, $lte);
                    } elseif($lte!==null) {
                        $myCausesApi->addSimpleFilter('cau_year', $lte, Freeasso_Api_Base::OPER_LOWER_EQUAL);
                    } elseif($gte!==null) {
                        $myCausesApi->addSimpleFilter('cau_year', $gte, Freeasso_Api_Base::OPER_GREATER_EQUAL);
                    }
                    break;
                }
            }
        }
        $updateCauses = true;
        if ($this->causes === null || $updateCauses) {
            $this->causes       = $myCausesApi->getCauses();
            $this->total_causes = $myCausesApi->getTotalCauses();
        }
        // End
        return $this;
    }

    /**
     * Load one cause
     *
     * @param mixed $p_id
     *
     * @return Freeasso_Causes_Search
     */
    public function loadData($p_id)
    {
        $myCausesApi = FreeAsso_Api_Cause::getFactory();
        $myCausesApi->setId($p_id);
        $myCausesApi->addOption('lang', $this->param_lang);
        $this->cause = $myCausesApi->getCause();
        return $this;
    }

    /**
     * Display searchform
     *
     * @return void
     */
    public function echoForm()
    {
		if(!defined('CURRENCY_SYMBOL'))      define('CURRENCY_SYMBOL','€');
		if(!defined('CURRENCY_BEFORE'))      define('CURRENCY_BEFORE',false);
		if(!defined('INCLUDE_FULLYRAISED'))  define('INCLUDE_FULLYRAISED',true);
		if(!defined('INCLUDE_TORAISE'))      define('INCLUDE_TORAISE',true);
		if(!defined('INCLUDE_SPONSOR_ONCE')) define('INCLUDE_SPONSOR_ONCE',true);
		$sel_amounts=$_GET['freeasso-cause-search-amounts'];
		if(empty($sel_amounts)) {
			if(INCLUDE_FULLYRAISED && !INCLUDE_TORAISE) {
				$_GET['freeasso-cause-search-amounts']='Z';
			} elseif(!INCLUDE_FULLYRAISED && INCLUDE_TORAISE && !INCLUDE_SPONSOR_ONCE) {
				$_GET['freeasso-cause-search-amounts']='F';
			} elseif(!INCLUDE_FULLYRAISED && INCLUDE_TORAISE) {
				$_GET['freeasso-cause-search-amounts']='C';
			}
		}
        $this->loadParams();
		
		
        $mode = $this->getParam('freeasso-cause-mode', 'search');
        if ($mode == 'detail') {
            $this->loadData($this->getParam('freeasso-cause-id'));
            $this->includeView('cause-detail', 'freeasso-causes-search');
        } else {
            $this->loadDatas();
            $this->includeView('cause-search', 'freeasso-causes-search');
        }
    }
}


// lib form views
function _freeasso_amount_format($amount) {
	$amount='<span class="value">'.$amount.'</span>';
	$currency='<span class="currency">'.CURRENCY_SYMBOL.'</span>';
	if(CURRENCY_BEFORE) return $currency.$amount;
	return $amount.$currency;
}
