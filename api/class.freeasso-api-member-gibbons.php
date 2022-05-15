<?php

/**
 * The member (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Member_Gibbons extends Freeasso_Api_Base
{

    /**
     * Behaviour
     */
    use Freeasso_View;
    use Freeasso_User;

    /**
     * Gibbons
     * @var []
     */
    protected $gibbons = null;

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $email = $this->getCurrentUserEmail();
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/member/' . $email . '/gibbons');
        $this->addSortField('cau_name', self::SORT_UP);
        $this->setPrivate();
    }

    /**
     * Get gibbons
     *
     * @return array
     */
    public function getGibbons()
    {
        if ($this->gibbons === null) {
            $this->getWS();
        }
        return $this->gibbons;
    }

    /**
     * Set gibbons infos
     *
     * @param array $p_gibbons
     *
     * @return Array
     */
    protected function setGibbons($p_gibbons)
    {
        $this->gibbons = [];
        $year          = intval(date('Y'));
        if ($p_gibbons) {
            foreach ($p_gibbons as $oneGibbon) {
                $oneCause    = $oneGibbon;
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
                $this->gibbons[] = $cause;
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
                $gibbons = $result->data;
            } else {
                $gibbons = $result;
            }
            $this->setGibbons($gibbons);
            return true;
        }
        $this->setGibbons(null);
        return false;
    }
}
