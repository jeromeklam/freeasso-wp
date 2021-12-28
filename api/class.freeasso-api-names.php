<?php

/**
 * The names (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Names extends Freeasso_Api_Base
{

    /**
     * Behaviour
     */
    use Freeasso_View;

    /**
     * Causes
     *
     * @var array
     */
    protected $causes = null;

    /**
     * Get all causes
     * @param $with_mnt_left bool : null=all ; true=only cause with mnt_left>0 ; false=only cause with mnt_left=0
     * @return array
     */
    public function getNames($with_mnt_left=null)
    {
        if($with_mnt_left===true) {
            $this->addFixedFilter('cau_mnt_left', 1, self::OPER_GREATER_EQUAL);
        } elseif($with_mnt_left===false) {
            $this->addFixedFilter('cau_mnt_left', 1, self::OPER_LOWER);
        }
        if ($this->causes === null) {
            $this->getWS();
        }
        return $this->causes;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        if ($this->getConfig()->getVersion() == 'v1') {
            $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/names');
            $this->setPrivate();
            $this
                ->addSortField('cau_name')
                ->setPagination(1, 999999)
            ;
        } else {
            $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/cause');
            $this->setPrivate();
            $this
                ->addSortField('cau_name')
                ->addFixedFilter('cau_family', 'ANIMAL', self::OPER_EQUAL)
                ->addFixedFilter('cau_to', Freeasso_Tools::getCurrentDateAsString(), self::OPER_GREATER_OR_NULL)
            ;
        }
    }

    /**
     * Set causes
     *
     * @param array $p_causes
     *
     * @return Freeasso_Api_Causes
     */
    protected function setCauses($p_causes)
    {
        $this->causes = [];
        $year = intval(date('Y'));
        foreach ($p_causes as $oneCause) {
            $cause          = new StdClass();
            $cause->id      = $oneCause->cau_id;
            $cause->name    = $oneCause->cau_name;
            $this->causes[] = $cause;
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
                $causes = $result->data;
            } else {
                $causes = $result;
            }
            $this->setCauses($causes);
            return true;
        }
        $this->setCauses([]);
        return false;
    }
}