<?php

/**
 * The member (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Member_Sponsorships extends Freeasso_Api_Base
{

    /**
     * Behaviour
     */
    use Freeasso_View;
    use Freeasso_User;

    /**
     * Sponsorships
     * @var []
     */
    protected $sponsorships = null;

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $email = $this->getCurrentUserEmail();
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/member/' . $email . '/sponsorships');
        $this->addSortField('spo_to', self::SORT_DOWN);
        $this->setPrivate();
    }

    /**
     * Get sponsorships
     *
     * @return array
     */
    public function getSponsorships()
    {
        if ($this->sponsorships === null) {
            $this->getWS();
        }
        return $this->sponsorships;
    }

    /**
     * Set sponsorships infos
     *
     * @param array $p_sponsorships
     *
     * @return Array
     */
    protected function setSponsorships($p_sponsorships)
    {
        $this->sponsorships = [];
        if ($p_sponsorships) {
            foreach ($p_sponsorships as $oneSponsorship) {
                $sponsorship          = new StdClass();
                $sponsorship->id      = $oneSponsorship->spo_id;
                $sponsorship->cause   = $oneSponsorship->cau_name;
                $sponsorship->mnt     = $oneSponsorship->spo_mnt;
                $sponsorship->money   = $oneSponsorship->spo_money;
                $sponsorship->from    = $oneSponsorship->spo_from;
                $sponsorship->to      = $oneSponsorship->spo_to;
                //
                $this->sponsorships[] = $sponsorship;
            }
        }
        return $this;
    }

    /**
     * Call WS
     *
     * @return boolean
     */
    protected function getWS()
    {
        $result = $this->call();
        if ($result) {
            if (isset($result->data)) {
                $sponsorships = $result->data;
            } else {
                $sponsorships = $result;
            }
            $this->setSponsorships($sponsorships);
            return true;
        }
        $this->setSponsorships(null);
        return false;
    }
}
