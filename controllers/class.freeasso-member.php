<?php

/**
 *
 * @author jeromeklam
 *
 */
class Freeasso_Member
{

    /**
     * Behaviour
     */
    use Freeasso_View;

    /**
     * Instance
     *
     * @var Freeasso_Member
     */
    private static $instance = null;

    /**
     * @var \StdClass
     */
    protected $member = null;

    /**
     * @var Array
     */
    protected $categories = null;

    /**
     * @var Array
     */
    protected $langs = null;

    /**
     * @var Array
     */
    protected $countries = null;

    /**
     * @var array
     */
    protected $gibbons = [];

    /**
     * @var array
     */
    protected $receipts = [];

    /**
     * @var array
     */
    protected $certificates = [];

    /**
     * Constructor
     */
    protected function __construct()
    {
    }

    /**
     * Get instance
     *
     * @return Freeasso_Member
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function isKalaweitMember() {
        return ($this->member == true);
    }

    /**
     * Echo Amis
     *
     * @param boolean $p_formated
     *
     * @return void
     */
    public function echoInfos($p_formated = true)
    {
        $freeMember = Freeasso_Api_Member::getFactory();
        $freeCat    = Freeasso_Api_Categories::getFactory();
        $freeLang   = Freeasso_Api_Langs::getFactory();
        $freeCoun   = Freeasso_Api_Countries::getFactory();
        $this->member     = $freeMember->getMember();
        $this->categories = $freeCat->getCategories();
        $this->langs      = $freeLang->getLangs();
        $this->countries  = $freeCoun->getCountries();
        //var_export($this->member);die('dfsfsdfds');
        if ($this->member) {
            $this->includeView('member-infos', 'freeasso-member-infos');
        } else {
            $this->includeView('member-none', 'freeasso-member-infos');
        }
    }

    /**
     * Receipts
     */
    public function echoReceipts($p_formated = true)
    {
        $freeMember = Freeasso_Api_Member::getFactory();
        if ($this->member) {
            /**
             * @var Freeasso_Api_Member_Receipts $freereceipts
             */
            $freereceipts = Freeasso_Api_Member_Receipts::getFactory();
            $this->receipts = $freereceipts->getReceipts();
            $this->includeView('member-receipts', 'freeasso-member-receipts');
        } else {
            $this->includeView('member-none', 'freeasso-member-infos');
        }
    }

    /**
     * Certificates
     */
    public function echoCertificates($p_formated = true)
    {
        $freeMember = Freeasso_Api_Member::getFactory();
        if ($this->member) {
            /**
             * @var Freeasso_Api_Member_Certificates $freecerts
             */
            $freecerts = Freeasso_Api_Member_Certificates::getFactory();
            $this->certificates = $freecerts->getCertificates();
            $this->includeView('member-certificates', 'freeasso-member-certificates');
        } else {
            $this->includeView('member-none', 'freeasso-member-infos');
        }
    }

    /**
     * Gibbons
     */
    public function echoGibbons($p_formated = true)
    {
        $freeMember = Freeasso_Api_Member::getFactory();
        if ($this->member) {
            /**
             * @var Freeasso_Api_Member_Gibbons $freegibbons
             */
            $freegibbons = Freeasso_Api_Member_Gibbons::getFactory();
            $this->gibbons = $freegibbons->getGibbons();
            $this->includeView('member-gibbons', 'freeasso-member-gibbons');
        } else {
            $this->includeView('member-none', 'freeasso-member-infos');
        }
    }

    /**
     * Tabs
     */
    public function echoTabs($p_formated = true)
    {
        $uri = $this->getCurrentUrl();
        $tabs = [
            "infos"       => "Mes informations",
            "parrainages" => "Mes parrainages",
            "certificats" => "Mes certificats",
            "recus"       => "Mes reçus",
            "dons"        => "Mes dons",
            "gibbons"     => "Animaux parrainés"
        ];
        /**
         * @var Freeasso_Api_Member $freemember
         */
        $freemember = Freeasso_Api_Member::getFactory();
        $this->member = $freemember->getMember();
        if ($this->member) {
            $tab = $this->getParam("member_tab", "infos");
            echo "<div class=\"freeasso-member-tab-wrapper\">";
            echo "    <div class=\"freeasso-member-tab-header\">";
            foreach ($tabs as $key => $label) {
                $active = $key == $tab ? "freeasso-member-tab-active" : "";
                $url = $this->addCurrentUrlParam('member_tab', $key);
                echo "        <div class=\"freeasso-member-tab-choice " . $active . "\">";
                echo "            <a href=\"" . $url . "\">" . esc_html__($label, 'freeasso') . "</a>";
                echo "        </div>";
            }
            echo "    </div>";
            echo "    <div class=\"freeasso-member-tab-content\">";
            switch ($tab) {
                case 'gibbons':
                    $this->echoGibbons($p_formated);
                    break;
                case 'certificats':
                    $this->echoCertificates($p_formated);
                    break;
                case 'recus':
                    $this->echoReceipts($p_formated);
                    break;
                case 'dons':
                    break;
                default:
                    $this->echoInfos($p_formated);
                    break;
            }
            echo "    </div>";
            echo "</div>";
        } else {
            $this->includeView('member-none', 'freeasso-member-infos');
        }
    }
}
