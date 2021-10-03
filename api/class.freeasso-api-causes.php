<?php

/**
 * The causes (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Causes extends Freeasso_Api_Base
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
     * Total causes
     * @var number
     */
    protected $total_causes = 0;

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
     * Total count
     *
     * @return number
     */
    public function getTotalCauses()
    {
        return $this->total_causes;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        if ($this->getConfig()->getVersion() == 'v1') {
            $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/gibbon');
            $this->setPrivate();
            $this
                ->addSortField('cau_name')
                ->setPagination(1, 16)
            ;
        } else {
            $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/cause');
            $this->setPrivate();
            $this
                ->addSortField('cau_name')
                ->addRelation('subspecies')
                ->addRelation('site')
                ->addRelation('vignettes')
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
        $year         = intval(date('Y'));
        if ($this->id != '') {
            $this->total_causes = 1;
            $causes = [$p_causes];
        } else {
            if (isset($p_causes->total)) {
                $this->total_causes = intval($p_causes->total);
            }
            if (isset($p_causes->data)) {
                $causes = $p_causes->data;
            } else {
                $causes = $p_causes;
            }
        }
        foreach ($causes as $oneCause) {
            $cause = new StdClass();
            $cause->id = $oneCause->cau_id;
            $cause->code = $oneCause->cau_code;
            if ($cause->code == '') {
                $cause->code = $oneCause->cau_id;
            }
            $cause->name   = $oneCause->cau_name;
            $cause->gender = $oneCause->cau_sex;
            $cause->born   = $oneCause->cau_year;
            if (isset($oneCause->site->site_name)) {
                $cause->site = $oneCause->site->site_name;
            } else {
                $cause->site = null;
            }
            if (isset($oneCause->fulltext)) {
                $cause->desc = $oneCause->fulltext;
            } else {
                if (isset($oneCause->cau_desc)) {
                    $cause->desc = $oneCause->cau_desc;
                } else {
                    $cause->desc = null;
                }
            }
            if (isset($oneCause->vignettes)) {
                $first = true;
                foreach ($oneCause->vignettes as $oneV) {
                    if ($first) {
                        $cause->photo1 = $oneV;
                        $first = false;
                    } else {
                        $cause->photo2 = $oneV;
                    }
                }
            } else {
                if (isset($oneCause->cau_photo_1)) {
                    $cause->photo1 = $oneCause->cau_photo_1;
                } else {
                    $cause->photo1 = null;
                }
                if (isset($oneCause->cau_photo_2)) {
                    $cause->photo2 = $oneCause->cau_photo_2;
                } else {
                    $cause->photo2 = null;
                }
            }
            if (isset($oneCause->sponsors)) {
                $cause->sponsors = $oneCause->sponsors;
            } else {
                if (isset($oneCause->cau_sponsors)) {
                    $cause->sponsors = $oneCause->cau_sponsors;
                } else {
                    $cause->sponsors = null;
                }
            }
            $cause->age = null;
            if ($cause->born && $cause->born > 1900) {
                $cause->age = $year - $cause->born;
            }
            $cause->species = $oneCause->subspecies->sspe_name;
            $cause->raised  = $oneCause->cau_mnt;
            $cause->left    = $oneCause->cau_mnt_left;
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
        if ($result && is_object($result) || is_array($result)) {
            $this->setCauses($result);
            return true;
        }
        $this->setCauses([]);
        return false;
    }
}