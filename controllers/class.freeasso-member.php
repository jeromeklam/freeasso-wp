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
        $freemember = Freeasso_Api_Member::getFactory();
        $this->member = $freemember->getMember();
        if ($this->member) {
            $this->includeView('member-infos', 'freeasso-member-infos');
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
                    /**
                     * @var Freeasso_Api_Member_Gibbons $freegibbons
                     */
                    $freegibbons = Freeasso_Api_Member_Gibbons::getFactory();
                    $this->gibbons = $freegibbons->getGibbons();
                    $this->includeView('member-gibbons', 'freeasso-member-gibbons');
                    break;
                case 'certificats':
                    /**
                     * @var Freeasso_Api_Member_Certificates $freecerts
                     */
                    $freecerts = Freeasso_Api_Member_Certificates::getFactory();
                    $this->certificates = $freecerts->getCertificates();
                    $this->includeView('member-certificates', 'freeasso-member-certificates');
                    break;
                case 'recus':
                    /**
                     * @var Freeasso_Api_Member_Receipts $freereceipts
                     */
                    $freereceipts = Freeasso_Api_Member_Receipts::getFactory();
                    $this->receipts = $freereceipts->getReceipts();
                    $this->includeView('member-receipts', 'freeasso-member-receipts');
                    break;
                case 'dons':
                    break;
                default:
                    $this->includeView('member-infos', 'freeasso-member-infos');
                    break;
            }
            echo "    </div>";
            echo "</div>";
        } else {
            $this->includeView('member-none', 'freeasso-member-infos');
        }
    }
}
