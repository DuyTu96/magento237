<?php

namespace Training\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\AbstractModel;

class Tag extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('tags', 'tag_id');
    }

    protected function _afterSave(AbstractModel $object)
    {
        return $this;
    }
}
