<?php

/**
 * The member (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Member extends Freeasso_Api_Base
{

    /**
     * Behaviour
     */
    use Freeasso_View;
    use Freeasso_User;

    /**
     * Member
     * @var \StdClass
     */
    protected $member = null;

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $email = $this->getCurrentUserEmail();
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/member/' . $email . '/infos');
        $this->setPrivate();
    }

    /**
     * Get member
     *
     * @return array
     */
    public function getMember()
    {
        if ($this->member === null) {
            $this->getWS();
        }
        return $this->member;
    }

    /**
     * Set member infos
     *
     * @param array $p_member
     *
     * @return Freeasso_Api_Member
     */
    protected function setMember($p_member)
    {
        $this->member = null;
        if ($p_member) {
            $this->member = $p_member;
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
                $member = $result->data;
            } else {
                $member = $result;
            }
            $this->setMember($member);
            return true;
        }
        $this->setMember(null);
        return false;
    }

    /**
     * Specific call for update
     * 
     * @param object $p_member 
     */
    public function updateMember($p_member)
    {
        $email = $this->getCurrentUserEmail();
        $this->setMethod(self::FREEASSO_METHOD_PUT)->setUrl('/asso/member/' . $email . '/infos');
        $this->setDatas($p_member);
        $this->setPrivate();
        return $this->call();
    }

        /**
     * Specific call for update
     * 
     * @param object $p_member 
     */
    public function updateMemberEmail($p_member)
    {
        $email = $this->getCurrentUserEmail();
        $this->setMethod(self::FREEASSO_METHOD_PUT)->setUrl('/asso/member/' . $email . '/email');
        $this->setDatas($p_member);
        $this->setPrivate();
        return $this->call();
    }
}
