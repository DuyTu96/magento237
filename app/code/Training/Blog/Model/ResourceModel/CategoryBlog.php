<?php

namespace Training\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CategoryBlog extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('category_blog', 'id');
    }
}
