<?php

namespace Training\Blog\Block\Adminhtml\Category\Edit;

use Magento\Backend\Block\Widget\Context;
use Training\Blog\Model\CategoryFactory;

class GenericButton
{

    protected Context $context;
    protected CategoryFactory $categoryFactory;

    public function __construct(
        Context $context,
        CategoryFactory $categoryFactory
    )
    {
        $this->context = $context;
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * Return category ID
     */
    public function getCategoryId()
    {
        $id = $this->context->getRequest()->getParam('category_id');
        $category = $this->categoryFactory->create()->load($id);
        if ($category->getCategoryId()) return $id;

        return null;
    }

    /**
     * Generate url by route and parameters
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
