<?php

namespace Training\Blog\Model\ResourceModel\CategoryTag;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('Training\Blog\Model\CategoryTag', 'Training\Blog\Model\ResourceModel\CategoryTag');
    }

}
