<?php

namespace Training\Blog\Model\ResourceModel\Category;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected $_idFieldName = 'category_id';

    protected function _construct()
    {
        $this->_init('Training\Blog\Model\Category', 'Training\Blog\Model\ResourceModel\Category');
    }

}
