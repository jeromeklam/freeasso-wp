<?php

/**
 * The causes (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Causes extends Freeasso_Api_Base
{

    /**
     * Causes
     *
     * @var array
     */
    protected $causes = null;

    /**
     * Get all causes
     *
     * @return array
     */
    public function getCauses()
    {
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
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/v1/asso/cause');
        $this->setPrivate();
        $this
            ->addSortField('cau_name')
            ->addRelation('subspecies')
            ->addRelation('site')
            ->addFixedFilter('cau_family', 'ANIMAL', self::OPER_EQUAL)
            ->addFixedFilter('cau_to', Freeasso_Tools::getCurrentDateAsString(), self::OPER_GREATER_OR_NULL)
        ;
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
            $cause = new StdClass();
            $cause->id = $oneCause->cau_id;
            $cause->code = $oneCause->cau_code;
            if ($cause->code == '') {
                $cause->code = $oneCause->cau_id;
            }
            $cause->label = $oneCause->cau_name;
            $cause->site = $oneCause->site->site_name;
            $cause->desc = $oneCause->cau_desc;
            $cause->gender = $oneCause->cau_sex;
            $cause->born = $oneCause->cau_year;
            $cause->age = null;
            if ($cause->born && $cause->born > 1900) {
                $cause->age = $year - $cause->born;
            }
            $cause->species = $oneCause->subspecies->sspe_name;
            $cause->raised = $oneCause->cau_mnt;
            $cause->left = $oneCause->cau_mnt_left;
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
        if ($result && is_array($result)) {
            $this->setCauses($result);
            return true;
        }
        $this->setCauses([]);
        return false;
    }
}