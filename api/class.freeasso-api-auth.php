<?php

/**
 * Authentication
 *
 * @author jeromeklam
 */
class Freeasso_Api_Auth extends Freeasso_Api_Base
{

    /**
     * User
     *
     * @var object
     */
    protected $user = null;

    /**
     * Get user
     * 
     * @param string $p_login
     * @param string $p_password
     *
     * @return array
     */
    public function login($p_login, $p_password)
    {
        if ($this->user === null) {
            $main = [
                '@type' => 'FreeSSO_Signin',
                'data'  => [
                    'login'    => $p_login,
                    'password' => $p_password,
                ]
            ]; 
            $this->setDatas($main);
            $this->getWS();
        }
        return $this->user;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $this->setMethod(self::FREEASSO_METHOD_POST)->setUrl('/sso/signin');
    }

    /**
     * Set user
     *
     * @param object $p_user
     *
     * @return Freeasso_Api_Auth
     */
    protected function setUser($p_user)
    {
        $this->user = $p_user;
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
            $this->setUser($result->data);
            return true;
        }
        $this->setUser(null);
        return false;
    }
}