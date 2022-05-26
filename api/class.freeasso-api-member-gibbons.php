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
        if ($p_gibbons) {
            foreach ($p_gibbons as $oneGibbon) {
                $oneCause       = $oneGibbon;
                $cause          = new StdClass();
                $cause->id      = $oneCause->cau_id;
                $cause->name    = $oneCause->cau_name;
                $cause->gender  = $oneCause->cau_sex;
                $cause->born    = $oneCause->cau_year;
                $cause->raised  = $oneCause->cau_mnt_raised;
                $cause->left    = $oneCause->cau_mnt_left;
                $cause->link    = $this->addCurrentUrlParams(
                    [
                        'download_cause_id' => $oneCause->cau_id,
                        'download_name'     => $oneCause->cau_name . '.pdf'
                    ]
                );
                //
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
