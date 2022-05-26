<?php

/**
 * The langs (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Langs extends Freeasso_Api_Base
{

    /**
     * Langs
     *
     * @var array
     */
    protected $langs = null;

    /**
     * Get all langs
     *
     * @return array
     */
    public function getLangs()
    {
        if ($this->langs === null) {
            $this->getWS();
        }
        return $this->langs;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/core/lang');
        $this->setPagination(1, 999);
        $this->setPrivate();
    }

    /**
     * Set langs
     *
     * @param array $p_langs
     *
     * @return Freeasso_Api_Langs
     */
    protected function setLangs($p_langs)
    {
        $this->langs = [];
        foreach ($p_langs as $oneLang) {
            $lang = new StdClass();
            $lang->id = $oneLang->lang_id;
            $lang->code = $oneLang->lang_code;
            if ($lang->code == '') {
                $lang->code = $oneLang->lang_id;
            }
            $lang->label = $oneLang->lang_name;
            $this->langs[] = $lang;
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
                $langs = $result->data;
            } else {
                $langs = $result;
            }
            $this->setLangs($langs);
            return true;
        }
        $this->setLangs([]);
        return false;
    }
}