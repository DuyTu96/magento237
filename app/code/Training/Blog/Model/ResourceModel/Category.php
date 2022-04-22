<?php

namespace Training\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\AbstractModel;

class Category extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('categories', 'category_id');
    }

    protected function _afterSave(AbstractModel $object)
    {
        return $this;
    }
}
