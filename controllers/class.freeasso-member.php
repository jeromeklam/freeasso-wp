<?php

/**
 *
 * @author jeromeklam
 *
 */
class Freeasso_Member
{

    /**
     * Behaviour
     */
    use Freeasso_View;

    /**
     * Instance
     *
     * @var Freeasso_Member
     */
    private static $instance = null;

    /**
     * @var \StdClass
     */
    protected $member = null;

    /**
     * Constructor
     */
    protected function __construct()
    {}

    /**
     * Get instance
     *
     * @return Freeasso_Member
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Echo Amis
     *
     * @param boolean $p_formated
     *
     * @return void
     */
    public function echoInfos($p_formated = true)
    {
        $freemember = Freeasso_Api_Member::getFactory();
        $this->member = $freemember->getMember();
        if ($this->member) {
            $this->includeView('member-infos', 'freeasso-member-infos');
        } else {
            $this->includeView('member-none', 'freeasso-member-infos');
        }
        //echo $freestats->getAmis($p_formated);
    }
}
