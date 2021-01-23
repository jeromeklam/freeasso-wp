<?php

/**
 * FreeAsso session
 *
 * Store variables in current session
 *
 * @author jeromeklam
 *
 */
class Freeasso_Session
{

    /**
     * Instance
     * @var Freeasso_Session
     */
    private static $instance = null;

    /**
     * Constructor
     */
    protected function __construct()
    {
        if (!session_id()) {
            session_start();
        }
    }

    /**
     * Get instance
     *
     * @return Freeasso_Session
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Verify key exists
     *
     * @param string $p_key
     *
     * @return boolean
     */
    public function has($p_key)
    {
        if (isset($_SESSION[$p_key])) {
            return true;
        }
        return false;
    }

    /**
     * Get a value
     *
     * @param string $p_key
     * @param mixed  $p_default
     *
     * @return mixed
     */
    public function get($p_key, $p_default = false)
    {
        if (isset($_SESSION[$p_key])) {
            return $_SESSION[$p_key];
        }
        return $p_default;
    }

    /**
     * Set a value
     *
     * @param string $p_key
     * @param mixed  $p_value
     *
     * @return Freeasso_Session
     */
    public function set($p_key, $p_value)
    {
        $_SESSION[$p_key] = $p_value;
        return $this;
    }
}
