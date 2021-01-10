<?php

/**
 * Api base class
 *
 * @author jeromeklam
 *
 */
class Freeasso_Api_Base
{

    /**
     * Methods
     *
     * @var string
     */
    const FREEASSO_METHOD_GET = 'get';
    const FREEASSO_METHOD_PUT = 'put';
    const FREEASSO_METHOD_POST = 'post';
    const FREEASSO_METHOD_DELETE = 'delete';
    const FREEASSO_METHOD_HEAD = 'head';
    const FREEASSO_METHOD_OPTIONS = 'options';

    /**
     * Sort options
     *
     * @var string
     */
    const SORT_UP = '';
    const SORT_DOWN = '-';

    /**
     * Operators
     *
     * @var string
     */
    const OPER_EQUAL                 = 'eq';
    const OPER_EQUAL_OR_NULL         = 'eqn';
    const OPER_NOT_EQUAL             = 'neq';
    const OPER_NOT_EQUAL_OR_NULL     = 'neqn';
    const OPER_GREATER               = 'gt';
    const OPER_GREATER_OR_NULL       = 'gtn';
    const OPER_GREATER_EQUAL         = 'gte';
    const OPER_GREATER_EQUAL_OR_NULL = 'gten';
    const OPER_LOWER                 = 'ltw';
    const OPER_LOWER_OR_NULL         = 'ltwn';
    const OPER_LOWER_EQUAL           = 'ltwe';
    const OPER_LOWER_EQUAL_OR_NULL   = 'ltwen';
    const OPER_LIKE                  = 'contains';
    const OPER_NOT_LIKE              = 'ncontains';
    const OPER_IN                    = 'in';
    const OPER_NOT_IN                = 'nin';
    const OPER_EMPTY                 = 'empty';
    const OPER_NOT_EMPTY             = 'nempty';
    const OPER_BETWEEN               = 'between';
    const OPER_BEGIN_WITH            = 'containsb';
    const OPER_END_WITH              = 'containse';
    const OPER_GLOBAL_MAX            = 'gmax';
    const OPER_GLOBAL_MIN            = 'gmin';

    /**
     * Config
     *
     * @var Freeasso_Config
     */
    private $config = null;

    /**
     * Method
     *
     * @var FREEASSO_METHOD_*
     */
    private $method = null;

    /**
     * Url to call
     *
     * @var string
     */
    private $url = null;

    /**
     * Private or public route ?
     *
     * @var boolean
     */
    private $public = false;

    /**
     * Sort fields
     *
     * @var array
     */
    private $sort = null;

    /**
     * Include relations, default none
     *
     * @var array
     */
    private $include = [];

    /**
     * Filter
     *
     * @var array
     */
    private $filters = [];

    /**
     * Page
     *
     * @var integer
     */
    private $page = 1;

    /**
     * Page size, 0 for unlimited
     *
     * @var integer
     */
    private $page_size = 0;

    /**
     * Get factory
     *
     * @return Freeasso_Api_Base
     */
    public static function getFactory()
    {
        $ws = new static();
        return $ws;
    }

    /**
     * Replace pattern
     *
     * @param string $p_string
     * @param string $p_regex
     *
     * @return string
     */
    public function regExpReplace($p_string, $p_regex = null)
    {
        if ($p_regex === null) {
            $p_regex = Freeasso_Tools::REGEX_PARAM_PLACEHOLDER;
        }
        $matches = [];
        if (0 < preg_match_all($p_regex, $p_string, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $replace = '';
                $method = $this->getMethodFromMatch($match[1]);
                if (method_exists($this, $method)) {
                    $replace = $this->{$method}();
                }
                $p_string = str_replace($match[0], $replace, $p_string);
            }
        }
        return $p_string;
    }

    /**
     * Add filter
     *
     * @param string $p_name
     * @param mixed  $p_value
     * @param string $p_oper
     * @param mixed  $p_other
     *
     * @return Freeasso_Api_Base
     */
    public function addSimpleFilter($p_name, $p_value, $p_oper = self::OPER_EQUAL, $p_other = null)
    {
        return $this->hAddFilter('simple', $p_name, $p_value, $p_oper, $p_other);
    }

    /**
     * Flush filters
     *
     * @return Freeasso_Api_Base
     */
    public function flushFilters()
    {
        return $this->hFlushFilters(false);
    }

    /**
     * Get filters as string
     *
     * @return string | false
     */
    protected function getFiltersForQuery()
    {
        $filters = false;
        $part1 = false;
        if (is_array($this->filters) && array_key_exists('fixed', $this->filters)) {
            $fixed = $this->filters['fixed'];
            if (is_array($fixed) && count($fixed) > 0) {
                $part1 = [];
                foreach ($fixed as $oneCrit) {
                    $part1[] = 'filter[and][' . $oneCrit->field . '][' . $oneCrit->oper . ']=' . $oneCrit->val1;
                }
            }
        }
        if (is_array($part1) && count($part1) > 0) {
            if ($filters === false) {
                $filters = '';
            }
            $filters .= implode('&', $part1);
        }
        return $filters;
    }

    /**
     * Get method from matching pattern
     *
     * @param string $p_match
     *
     * @return string
     */
    protected function getMethodFromMatch($p_match)
    {
        $p_match = strtolower($p_match);
        $p_match = str_replace('freeasso', '', $p_match);
        $p_match = trim($p_match, '_');
        return 'get' . Freeasso_Tools::toCamelCase($p_match, true);
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        $freeasso = Freeasso::getInstance();
        $this->config = $freeasso->getConfig();
        if (! $this->config instanceof Freeasso_Config) {
            throw new \Exception("Class Freeasso_Config not found !");
        }
    }

    /**
     * Get config
     *
     * @return Freeasso_Config
     */
    protected function getConfig()
    {
        return $this->config;
    }

    /**
     * Get Full WS url
     *
     * @return string
     */
    protected function getFullUrl()
    {
        $url = rtrim($this->getConfig()->getWsBaseUrl(), "/");
        $url = $url . '/' . ltrim($this->url, '/');
        $params = [];
        if (is_array($this->sort)) {
            $params['sort'] = implode(',', $this->sort);
        }
        if (is_array($this->include)) {
            $params['include'] = implode(',', $this->include);
        }
        if (count($params) > 0) {
            $url = $url . '?' . http_build_query($params);
        }
        $filters = $this->getFiltersForQuery();
        if ($filters) {
            if (count($params) > 0) {
                $url .= '&' . $filters;
            } else {
                $url .= '?' . $filters;
            }
        }
        return $url;
    }

    /**
     * Set method
     *
     * @param string $p_method
     *
     * @return Freeasso_Api_Base
     */
    protected function setMethod($p_method)
    {
        $this->method = $p_method;
        return $this;
    }

    /**
     * Get method
     *
     * @return FREEASSO_METHOD_*
     */
    protected function getMethod()
    {
        return $this->method;
    }

    /**
     * Set url
     *
     * @param string $p_url
     *
     * @return Freeasso_Api_Base
     */
    protected function setUrl($p_url)
    {
        $this->url = $p_url;
        return $this;
    }

    /**
     * Return url
     *
     * @return string
     */
    protected function getUrl()
    {
        return $this->url;
    }

    /**
     * Set public route
     *
     * @param boolean $p_public
     *
     * @return Freeasso_Api_Base
     */
    protected function setPublic($p_public = true)
    {
        $this->public = $p_public;
        return $this;
    }

    /**
     * Set private route
     *
     * @param boolean $p_public
     *
     * @return Freeasso_Api_Base
     */
    protected function setPrivate($p_public = false)
    {
        $this->public = $p_public;
        return $this;
    }

    /**
     * Get public
     *
     * @return boolean
     */
    protected function getPublic()
    {
        return $this->public;
    }

    /**
     * Public ??
     *
     * @return boolean
     */
    protected function isPublic()
    {
        return $this->public === true;
    }

    /**
     * Private ??
     *
     * @return boolean
     */
    protected function isPrivate()
    {
        return $this->public === false;
    }

    /**
     * Get Hawk auth header
     *
     * @return string
     */
    protected function getHawkAuth()
    {
        $ts = $this->getTs();
        $nonce = $this->getNonce();
        $hawk = $this->getHawkArray($ts, $nonce);
        $hawkStr = implode("\n", $hawk) . "\n";
        $hash = hash_hmac('sha256', $hawkStr, $this->getConfig()->getHawkKey(), true);
        $auth = 'Hawk ' . 'id=' . $this->getConfig()->getHawkUser() . ', ' . 'ts=' . $ts . ', ' . 'nonce=' . $nonce . ', ' . 'mac=' . base64_encode($hash);
        return $auth;
    }

    /**
     * Get base url scheme
     *
     * @return string
     */
    protected function getUrlScheme()
    {
        $url = strtolower($this->getConfig()->getWsBaseUrl());
        $parts = parse_url($url);
        if (is_array($parts) && array_key_exists('scheme', $parts)) {
            return strtolower($parts['scheme']);
        }
        return 'http';
    }

    /**
     * Get base url host
     *
     * @return string
     */
    protected function getUrlHost()
    {
        $url = $this->getConfig()->getWsBaseUrl();
        $parts = parse_url($url);
        if (is_array($parts) && array_key_exists('host', $parts)) {
            return strtolower($parts['host']);
        }
        return '';
    }

    /**
     * Get base url path
     *
     * @param boolean $p_with_query
     *
     * @return string
     */
    protected function getUrlPath($p_with_query = false)
    {
        $url = $this->getFullUrl();
        $parts = parse_url($url);
        $result = '';
        if (is_array($parts) && array_key_exists('path', $parts)) {
            $result = trim($parts['path']);
            if ($p_with_query && array_key_exists('query', $parts)) {
                $result = $result . '?' . trim($parts['query']);
            }
        }
        return $result;
    }

    /**
     * Get base url path
     *
     * @return string
     */
    protected function getUrlPathWithQuery()
    {
        return $this->getUrlPath(true);
    }

    /**
     * Get base url port
     *
     * @return number
     */
    protected function getUrlPort()
    {
        $url = $this->getConfig()->getWsBaseUrl();
        $parts = parse_url($url);
        $port = false;
        if (is_array($parts) && array_key_exists('port', $parts)) {
            $port = $parts['port'];
        }
        if ($port === false) {
            $port = 80;
            if ($this->getUrlScheme() === 'https') {
                $port = 443;
            }
        }
        return intval($port);
    }

    /**
     * Get TS
     *
     * @return string
     */
    protected function getTs()
    {
        $parts = explode('.', microtime(true));
        return $parts[0];
    }

    /**
     * Get nonce
     *
     * @return string
     */
    protected function getNonce()
    {
        return substr(md5(microtime()), 0, 6);
    }

    /**
     * get Hawk parts as array
     *
     * @param string $p_ts
     * @param string $p_nonce
     *
     * @return array
     */
    protected function getHawkArray($p_ts, $p_nonce)
    {
        $hawk = [];
        $hawk[] = 'hawk.1.header';
        $hawk[] = $p_ts;
        $hawk[] = $p_nonce;
        $hawk[] = strtoupper($this->getMethod());
        $hawk[] = urldecode($this->getUrlPathWithQuery());
        $hawk[] = $this->getUrlHost();
        $hawk[] = $this->getUrlPort();
        $hawk[] = '';
        $hawk[] = '';
        return $hawk;
    }

    /**
     * Call WS
     */
    protected function call()
    {
        $args = [
            'timeout' => 20,
            'headers' => [
                'Api-Id' => $this->getConfig()->getApiId(),
                'Accept' => 'application/json', // Just accept json result, no jsonapi
                'Content-Type' => 'application/json' // Force json content
            ]
        ];
        if ($this->isPrivate()) {
            $args['headers']['Authorization'] = $this->getHawkAuth();
        }
        $result = wp_remote_get($this->getFullUrl(), $args);
        if ($result && array_key_exists('response', $result)) {
            $response = $result['response'];
            if (array_key_exists('code', $response) && intval($response['code']) < 300) {
                if (array_key_exists('body', $result)) {
                    $json = $result['body'];
                    return json_decode($json);
                }
            }
        }
        return false;
    }

    /**
     * Flush sort fields
     *
     * @return Freeasso_Api_Base
     */
    protected function flushSort()
    {
        $this->sort = null;
        return $this;
    }

    /**
     * Add sort field
     *
     * @param string $p_field
     * @param string $p_way
     *
     * @return Freeasso_Api_Base
     */
    protected function addSortField($p_field, $p_way = self::SORT_UP)
    {
        if (!is_array($this->sort)) {
            $this->sort = [];
        }
        $this->sort[] = $p_way . $p_field;
        return $this;
    }

    /**
     * Flush relations
     *
     * @return Freeasso_Api_Base
     */
    protected function flushRelations()
    {
        $this->include = [];
        return $this;
    }

    /**
     * Add relation
     *
     * @param string $p_relation
     *
     * @return Freeasso_Api_Base
     */
    protected function addRelation($p_relation)
    {
        if (!is_array($this->include)) {
            $this->include = [];
        }
        $this->include[] = $p_relation;
        return $this;
    }

    /**
     * Flush filters
     *
     * @param boolean $p_all
     *
     * @return Freeasso_Api_Base
     */
    protected function hFlushFilters($p_all = false)
    {
        $filters = [];
        if (is_array($this->filters) && array_key_exists('fixed', $this->filters)) {
            $filters['fixed'] = $this->filters(['fixed']);
        }
        $this->filters = $filters;
        return $this;
    }

    /**
     * Add fixed filter
     *
     * @param string $p_name
     * @param mixed  $p_value
     * @param string $p_oper
     * @param mixed  $p_other
     *
     * @return Freeasso_Api_Base
     */
    protected function addFixedFilter($p_name, $p_value, $p_oper = self::OPER_EQUAL, $p_other = null)
    {
        return $this->hAddFilter('fixed', $p_name, $p_value, $p_oper, $p_other);
    }

    /**
     * Add filter, simple way
     *
     * @param string $p_type
     * @param string $p_name
     * @param mixed  $p_value
     * @param string $p_oper
     * @param mixed  $p_other
     *
     * @return Freeasso_Api_Base
     */
    private function hAddFilter($p_type, $p_name, $p_value, $p_oper = self::OPER_EQUAL, $p_other = null)
    {
        if (!is_array($this->filters)) {
            $this->filters = [];
        }
        if (!array_key_exists($p_type, $this->filters)) {
            $this->filters[$p_type] = [];
        }
        $crit = new \stdClass();
        $crit->field = $p_name;
        $crit->oper = $p_oper;
        $crit->val1 = $p_value;
        $crit->val2 = $p_other;
        $this->filters[$p_type][] = $crit;
        return $this;
    }
}
