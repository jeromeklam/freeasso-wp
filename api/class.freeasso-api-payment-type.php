<?php

/**
 * The payment types (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_PaymentType extends Freeasso_Api_Base
{

    /**
     * Payment types
     *
     * @var array
     */
    protected $payment_types = null;

    /**
     * Get all payment types
     *
     * @return array
     */
    public function getPaymentTypes()
    {
        if ($this->payment_types === null) {
            $this->getWS();
        }
        return $this->payment_types;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/payment_type');
        $this->setPagination(1, 999);
        $this->setPrivate();
    }

    /**
     * Set payment types
     *
     * @param array $p_payment_types
     *
     * @return Freeasso_Api_Countries
     */
    protected function setPaymentTypes($p_payment_types)
    {
        $this->payment_types = [];
        foreach ($p_payment_types as $onePtyp) {
            $payment = new StdClass();
            $payment->id = $onePtyp->ptyp_id;
            $payment->code = $onePtyp->ptyp_code;
            if ($payment->code == '') {
                $payment->code = $onePtyp->ptyp_id;
            }
            $payment->label = $onePtyp->ptyp_name;
            $this->payment_types[] = $payment;
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
                $payment_types = $result->data;
            } else {
                $payment_types = $result;
            }
            $this->setPaymentTypes($payment_types);
            return true;
        }
        $this->setPaymentTypes([]);
        return false;
    }
}