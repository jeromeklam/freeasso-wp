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
    use Freeasso_User;

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
     * @var Array
     */
    protected $donations = [];

    /**
     * @var Array
     */
    protected $sponsorships = [];
    
    /**
     * @var Array
     */
    protected $payment_types = [];

    /**
     * Current lang
     * @var string
     */
    protected $param_lang = 'fr_FR';

    /**
     * Constructor
     */
    protected function __construct()
    {
        $this->param_lang = get_locale();
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

    /**
     * Echo Amis
     *
     * @param boolean $p_formated
     *
     * @return void
     */
    public function echoInfos($p_formated = true)
    {
        $freeCat    = Freeasso_Api_Categories::getFactory();
        $freeLang   = Freeasso_Api_Langs::getFactory();
        $freeCoun   = Freeasso_Api_Countries::getFactory();
        if ($this->member === null) {
            /**
             * @var Freeasso_Api_Member $freemember
             */
            $freemember = Freeasso_Api_Member::getFactory();
            $this->member = $freemember->getMember();
        }
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
        if ($this->member === null) {
            /**
             * @var Freeasso_Api_Member $freemember
             */
            $freemember = Freeasso_Api_Member::getFactory();
            $this->member = $freemember->getMember();
        }
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
        if ($this->member === null) {
            /**
             * @var Freeasso_Api_Member $freemember
             */
            $freemember = Freeasso_Api_Member::getFactory();
            $this->member = $freemember->getMember();
        }
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
        if ($this->member === null) {
            /**
             * @var Freeasso_Api_Member $freemember
             */
            $freemember = Freeasso_Api_Member::getFactory();
            $this->member = $freemember->getMember();
        }
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
     * Sponsosrships
     */
    public function echoSponsorships($p_formated = true)
    {
        if ($this->member === null) {
            /**
             * @var Freeasso_Api_Member $freemember
             */
            $freemember = Freeasso_Api_Member::getFactory();
            $this->member = $freemember->getMember();
        }
        if ($this->member) {
            /**
             * @var Freeasso_Api_PaymentType $freePtyp
             */
            $freePtyp = Freeasso_Api_PaymentType::getFactory();
            $this->payment_types = $freePtyp->getPaymentTypes();
            /**
             * @var Freeasso_Api_Member_Sponsorships $freeSponsor
             */
            $freeSponsor = Freeasso_Api_Member_Sponsorships::getFactory();
            $this->sponsorships = $freeSponsor->getSponsorships();
            $this->includeView('member-sponsorships', 'freeasso-member-sponsorships');
        } else {
            $this->includeView('member-none', 'freeasso-member-infos');
        }
    }

    /**
     * Donations
     */
    public function echoDonations($p_formated = true)
    {
        if ($this->member === null) {
            /**
             * @var Freeasso_Api_Member $freemember
             */
            $freemember = Freeasso_Api_Member::getFactory();
            $this->member = $freemember->getMember();
        }
        if ($this->member) {
            /**
             * @var Freeasso_Api_PaymentType $freePtyp
             */
            $freePtyp = Freeasso_Api_PaymentType::getFactory();
            $this->payment_types = $freePtyp->getPaymentTypes();
            /**
             * @var Freeasso_Api_Member_Donations $freeDon
             */
            $freeDon = Freeasso_Api_Member_Donations::getFactory();
            $this->donations = $freeDon->getDonations();
            $this->includeView('member-donations', 'freeasso-member-donations');
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
        if ($this->member === null) {
            /**
             * @var Freeasso_Api_Member $freemember
             */
            $freemember = Freeasso_Api_Member::getFactory();
            $this->member = $freemember->getMember();
        }
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
                case 'dons':
                    $this->echoDonations($p_formated);
                    break;
                case 'parrainages':
                    $this->echoSponsorships($p_formated);
                    break;
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

    /**
     * POST to StdClass
     * 
     * @return object
     */
    protected function postMemberToData()
    {
        $data = new \StdClass();
        $type = '@type';
        $data->$type = 'FreeAsso\\Model\\Member';
        $data->mbr_send_receipt = false;
        foreach ($_POST as $name => $value) {
            if (strpos($name, 'freeasso-member-mbr_') !== false) {
                $key = str_replace('freeasso-member-', '', $name);
                if ($key == 'mbr_send_receipt') {
                    if ($value == 'on' || $value == '1') {
                        $data->mbr_send_receipt = true;
                    }
                    continue;
                }
                $data->$key = $value;
            }
        }
        return $data;
    }

    /**
     * Update member infos
     * Handle form submission
     */
    public function updateMember()
    {
        if (isset($_POST['freeasso-member-infos-submit'])) {
            if (wp_verify_nonce($_POST['user'], 'freeasso-infos')) {
                // get new record from POST....
                // Tout bon...
                $data = $this->postMemberToData();
                $data->mbr_email = $this->getCurrentUserEmail();
                /**
                 * @var Freeasso_Api_Member $memberApi;
                 */
                $memberApi = \Freeasso_Api_Member::getFactory();
                $result = $memberApi->updateMember($data);
                $this->member = $result;
                if (!empty($result->errors)) {
                    // Send errors to view...
                    foreach ($result->errors as $oneError) {
                        $oneError = (array)$oneError;
                        $this->addError($oneError['code'], esc_html($oneError['message'], 'freeasso'), $oneError['field']);
                    }
                } else {
                    // saved in freeasso
                    wp_redirect( add_query_arg( array('updated' => 'true') ) );
                }
            }
        }
    }

    /**
     * Update email 
     */
    public function updateMemberEmail($p_mbr_id, $p_new_email)
    {
        $type = '@type';
        //
        $data            = new \StdClass();
        $data->$type     = 'FreeAsso\\Model\\Member';
        $data->mbr_id    = $p_mbr_id;
        $data->mbr_email = $p_new_email;
        $result = $memberApi->updateMemberEmail($data);
        $this->member = $result;
        if (isset($result->errors)) {
            // Send errors to view...
            foreach ($result->errors as $oneError) {
                $oneError = (array)$oneError;
                $this->addError($oneError['code'], esc_html($oneError['message'], 'freeasso'), $oneError['field']);
            }
            return false;
        } else {
            // @todo OK
            return true;
        }
    }
}
