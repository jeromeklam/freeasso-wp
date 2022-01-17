<?php

/**
 * The causes (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Cause extends Freeasso_Api_Base
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
    protected $cause = null;

    /**
     * Get all causes
     *
     * @return array
     */
    public function getCause()
    {
        if ($this->cause === null) {
            $this->getWS();
        }
        return $this->cause;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        if ($this->getConfig()->getVersion() == 'v1') {
            $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/gibbon');
            $this->setPrivate();
            $this
                ->addSortField('cau_name')
                ->setPagination(1, 16)
            ;
        } else {
            $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/cause');
            $this->setPrivate();
            $this
                ->addSortField('cau_name')
                ->addRelation('subspecies')
                ->addRelation('site')
                ->addRelation('fulltext')
                ->addRelation('vignettes')
                ->addRelation('sponsors')
                ->addFixedFilter('cau_family', 'ANIMAL', self::OPER_EQUAL)
                ->addFixedFilter('cau_to', Freeasso_Tools::getCurrentDateAsString(), self::OPER_GREATER_OR_NULL)
            ;
        }
    }

    /**
     * Set cause
     *
     * @param array $p_cause
     *
     * @return Freeasso_Api_Causes
     */
    protected function setCause($p_cause)
    {
        $this->cause = null;
        $year        = intval(date('Y'));
        if ($p_cause) {
            $oneCause    = $p_cause;
            $cause       = new StdClass();
            $cause->id   = $oneCause->cau_id;
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
                if (is_array($oneCause->sponsors)) {
                    $list = [];
                    foreach ($oneCause->sponsors as $oneSponsor) {
                        if (isset($oneSponsor->name)) {
                            $list[] = $oneSponsor->name;
                        }
                    }
                    $cause->sponsors = implode(', ', $list);
                } else {
                    $cause->sponsors = $oneCause->sponsors;
                }
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
            $cause->raised  = $oneCause->cau_mnt_raised;
            $cause->left    = $oneCause->cau_mnt_left;
            $this->cause    = $cause;
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
            $this->setCause($causes);
            return true;
        }
        $this->setCause(null);
        return false;
    }
}