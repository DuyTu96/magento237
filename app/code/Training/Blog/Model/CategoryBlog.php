<?php

namespace Training\Blog\Model;

use Magento\Framework\Model\AbstractModel;

class CategoryBlog extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Training\Blog\Model\ResourceModel\CategoryBlog');
    }
}
