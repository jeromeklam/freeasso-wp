<?php

/**
 * The member (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Member_Receipts extends Freeasso_Api_Base
{

    /**
     * Behaviour
     */
    use Freeasso_View;
    use Freeasso_User;

    /**
     * Receipts
     * @var []
     */
    protected $receipts = null;

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $email = $this->getCurrentUserEmail();
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/member/' . $email . '/receipts');
        $this->addSortField('rec_ts', self::SORT_DOWN);
        $this->setPrivate();
    }

    /**
     * Get receipts
     *
     * @return array
     */
    public function getReceipts()
    {
        if ($this->receipts === null) {
            $this->getWS();
        }
        return $this->receipts;
    }

    /**
     * Set receipts infos
     *
     * @param array $p_receipts
     *
     * @return Array
     */
    protected function setReceipts($p_receipts)
    {
        $this->receipts = [];
        if ($p_receipts) {
            foreach ($p_receipts as $oneReceipt) {
                $receipt         = new StdClass();
                $receipt->id     = $oneReceipt->rec_id;
                $receipt->number = $oneReceipt->rec_number;
                $receipt->year   = $oneReceipt->rec_year;
                $receipt->mnt    = $oneReceipt->rec_mnt;
                $receipt->money  = $oneReceipt->rec_money;
                $receipt->link   = $oneReceipt->file_id > 0 ? $this->addCurrentUrlParams(
                    [
                        'download_receipt_id' => $oneReceipt->rec_id,
                        'download_name' => $oneReceipt->rec_number . '.pdf'
                    ]
                ) : null;
                $receipt->file   = $oneReceipt->rec_number . '.pdf';
                //
                $this->receipts[] = $receipt;
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
                $receipts = $result->data;
            } else {
                $receipts = $result;
            }
            $this->setReceipts($receipts);
            return true;
        }
        $this->setReceipts(null);
        return false;
    }
}
