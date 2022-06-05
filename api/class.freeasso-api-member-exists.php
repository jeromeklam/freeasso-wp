<?php

/**
 * Check if a member exists with the specified email address
 *
 */
class Freeasso_Api_Member_Exists extends Freeasso_Api_Base
{
    /**
     * Get member to check if exists
     *
     * @return array
     */
    public function existsMember($email)
    {
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/member/' . urlencode($email) . '/infos');
        $this->setPrivate();
        $result = $this->call();
        return ($result == true);
    }
}
