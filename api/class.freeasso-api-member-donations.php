<?php

/**
 * The member (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Member_Donations extends Freeasso_Api_Base
{

    /**
     * Behaviour
     */
    use Freeasso_View;
    use Freeasso_User;

    /**
     * Donations
     * @var []
     */
    protected $donations = null;

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $email = $this->getCurrentUserEmail();
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/member/' . urlencode($email) . '/donations');
        $this->addSortField('don_ts', self::SORT_DOWN);
        $this->addFixedFilter('don_status', 'OK', self::OPER_EQUAL);
        $this->setPagination(1, 100);
        $this->setPrivate();
    }

    /**
     * Get donations
     *
     * @return array
     */
    public function getDonations()
    {
        if ($this->donations === null) {
            $this->getWS();
        }
        return $this->donations;
    }

    /**
     * Set donations infos
     *
     * @param array $p_donations
     *
     * @return Array
     */
    protected function setDonations($p_donations)
    {
        $this->donations = [];
        if ($p_donations) {
            foreach ($p_donations as $oneDonation) {
                $donation          = new StdClass();
                $donation->id      = $oneDonation->spo_id ?? -1;
                $donation->cause   = $oneDonation->cau_name;
                $donation->mnt     = $oneDonation->don_mnt;
                $donation->money   = $oneDonation->don_money;
                $donation->date    = $oneDonation->don_ts;
                $donation->status  = $oneDonation->don_status;
                $donation->ptyp    = $oneDonation->ptyp_code;
                //
                $this->donations[] = $donation;
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
                $donations = $result->data;
            } else {
                $donations = $result;
            }
            $this->setDonations($donations);
            return true;
        }
        $this->setDonations(null);
        return false;
    }
}
