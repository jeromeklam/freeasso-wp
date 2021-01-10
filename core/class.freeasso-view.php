<?php

/**
 * FreeAsso view
 *
 * @author jeromeklam
 *
 */
class Freeasso_View
{

    /**
     * Plugin name
     * @var string
     */
    protected $pluginName = FREEASSO_PLUGIN_NAME;

    /**
     * Page name
     * @var string
     */
    protected $pluginPage = '';

    /**
     * Message
     * @var string
     */
    protected $message = null;

    /**
     * Message
     * @var string
     */
    protected $errorMessage = null;

    /**
     * Init all
     *
     * @return self
     */
    protected function initView()
    {
        $this->message = null;
        $this->errorMessage = null;
        return $this;
    }

    /**
     * Include view
     *
     * @param string $p_view
     * @param string $p_page
     *
     * return boolean
     */
    protected function includeView($p_view, $p_page)
    {
        $view = FREEASSO_PLUGIN_DIR . '/views/' . $p_view . '.php';
        $this->pluginPage = $p_page;
        if (file_exists($view)) {
            include_once($view);
            return true;
        }
        return false;
    }
}
