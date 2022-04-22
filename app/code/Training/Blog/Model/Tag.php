<?php

namespace Training\Blog\Model;

use Magento\Framework\Model\AbstractModel;

class Tag extends AbstractModel
{
    const ENTITY_ID = 'tag_id';

    protected function _construct()
    {
        $this->_init('Training\Blog\Model\ResourceModel\Tag');
    }
}
