<?php

/**
 * FreeAsso view
 *
 * @author jeromeklam
 *
 */
trait Freeasso_View
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
     * Params
     * @var array
     */
    protected $params = null;

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
     * Get params from query
     *
     * @return Freeasso_View
     */
    protected function loadParams()
    {
        $this->params = $_GET;
        return $this;
    }

    /**
     * Return param
     *
     * @param string $p_name
     * @param mixed  $p_default
     *
     * @return mixed
     */
    protected function getParam($p_name, $p_default = null)
    {
        if ($this->params === null) {
            $this->loadParams();
        }
        if (isset($this->params[$p_name])) {
            return $this->params[$p_name];
        }
        return $p_default;
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

    /**
     * Format number, forced, does not use global currency, ...
     * @see _freeasso_amount_format if updated
     * 
     * @param float  $p_amount
     * @param string $p_currency
     * @param int    $p_decimals
     * 
     * @return string
     */
    public static function formatAmountAsHtml($p_amount, $p_currency, $p_decimals = 2)
    {
        if (($p_amount - floor($p_amount)) < .005) {
            $p_amount = floor($p_amount);
        } else {
            $p_amount = number_format($p_amount, $p_decimals,".","");
        }
        $amount = '<span class="value">' . $p_amount . '</span>';
        $before = false;
        if (strtoupper($p_currency) == 'CHF') {
            $before = true;
        }
        $symbol = $p_currency;
        if (strtoupper($symbol) == 'EUR') {
            $symbol = '&euro;';
        }
        $currency = '<span class="currency">' . $symbol . '</span>';
        if ($before) {
            return $currency . $p_amount;
        }
        return $p_amount . $currency;
    }

    /**
     * Format date
     * 
     * @param string $p_date;
     * 
     * return string
     */
    public function formatDate($p_date)
    {
        $formatted = '';
        if ($p_date) {
            $date = new \DateTime($p_date);
            if ($date) {
                return $date->format('d/m/Y');
            }
        }
        return $formatted;
    }

    /**
     * Get status formated
     * 
     * @param string $p_status
     * 
     * @return string
     */
    public function formatStatus($p_status)
    {
        $formated = esc_html('OK', 'freeasso');
        if ($p_status != "OK") {
            $formated = esc_html('KO', 'freeasso');
        }
        return $formated;
    }

    /**
     * Return url
     * 
     * @return string
     */
    public function getCurrentUrl()
    {
        global $wp;
        $qst = $wp->query_string;
        $url = home_url($pw->request) . ($qst != '' ? '?' : '') . $qst;
        return $url;
    }

    /**
     * Add param tu current url
     * 
     * @param string $p_name
     * @param mixed  $p_value
     * 
     * @return string
     */
    public function addCurrentUrlParam($p_name, $p_value)
    {
        global $wp;
        $old = $this->getCurrentUrl();
        $url = add_query_arg($p_name, $p_value, $old);
        return $url;
    }

    /**
     * Add param tu current url
     * 
     * @param array $p_params
     * 
     * @return string
     */
    public function addCurrentUrlParams($p_params)
    {
        global $wp;
        $old = $this->getCurrentUrl();
        $url = add_query_arg($p_params, '', $old);
        return $url;
    }
}
