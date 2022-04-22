<?php

namespace Training\Blog\Model;

use Magento\Framework\Model\AbstractModel;

class Category extends AbstractModel
{
    const ENTITY_ID = 'category_id';

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected function _construct()
    {
        $this->_init('Training\Blog\Model\ResourceModel\Category');
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}
