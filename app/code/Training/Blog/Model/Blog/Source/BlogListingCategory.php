<?php

namespace Training\Blog\Model\Blog\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Training\Blog\Helper\Helper;
use Training\Blog\Model\CategoryFactory;

class BlogListingCategory implements OptionSourceInterface
{

    protected CategoryFactory $_categoryFactory;
    protected Helper $_helper;

    /**
     * @param CategoryFactory $categoryFactory
     * @param Helper $helper
     */
    public function __construct(
        CategoryFactory $categoryFactory,
        Helper $helper
    ) {
        $this->_categoryFactory = $categoryFactory;
        $this->_helper = $helper;
    }

    /**
     * Get status options
     */
    public function toOptionArray()
    {
        $model = $this->_categoryFactory->create();
        $collection = $model->getCollection();
        $categories = [];
        $this->_helper->getCategoriesNoChar($categories, $collection->getData());

        return $categories;
    }
}
