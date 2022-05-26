<?php

/**
 * The members categories
 *
 * @author jeromeklam
 */
class Freeasso_Api_Categories extends Freeasso_Api_Base
{

    /**
     * Categories
     *
     * @var array
     */
    protected $categories = null;

    /**
     * Get all categories
     *
     * @return array
     */
    public function getCategories()
    {
        if ($this->categories === null) {
            $this->getWS();
        }
        return $this->categories;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/asso/client_category');
        $this->setPagination(1, 9999);
        $this->setPrivate();
    }

    /**
     * Set categories
     *
     * @param array $p_categories
     *
     * @return Freeasso_Api_Categories
     */
    protected function setCategories($p_categories)
    {
        $this->categories = [];
        foreach ($p_categories as $oneCategory) {
            $category = new StdClass();
            $category->id = $oneCategory->clic_id;
            $category->code = $oneCategory->clic_code;
            if ($category->code == '') {
                $category->code = $oneCategory->clic_id;
            }
            $category->label = $oneCategory->clic_name;
            $this->categories[] = $category;
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
                $categories = $result->data;
            } else {
                $categories = $result;
            }
            $this->setCategories($categories);
            return true;
        }
        $this->setCategories([]);
        return false;
    }
}