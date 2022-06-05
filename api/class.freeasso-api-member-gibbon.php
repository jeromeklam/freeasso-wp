<?php

/**
 * The member (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Member_Gibbon extends Freeasso_Api_Base
{

    /**
     * Behaviour
     */
    use Freeasso_View;
    use Freeasso_User;

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
    }

    /**
     * Get Edition
     *
     * @return array
     */
    public function download($p_cau_id)
    {
        $email = $this->getCurrentUserEmail();
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/member/' . urlencode($email) . '/cause/' . $p_cau_id);
        $this->setPrivate();
        $this->setRaw(true);
        return $this->call();
    }
}
