<?php

namespace Training\Blog\Model\Blog\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Training\Blog\Helper\Helper;
use Training\Blog\Model\TagFactory;

class BlogListingTag implements OptionSourceInterface
{

    protected TagFactory $_tagFactory;
    protected Helper $_helper;

    /**
     * @param TagFactory $tagFactory
     * @param Helper $helper
     */
    public function __construct(
        TagFactory $tagFactory,
        Helper $helper
    ) {
        $this->_tagFactory = $tagFactory;
        $this->_helper = $helper;
    }

    /**
     * Get status options
     */
    public function toOptionArray()
    {
        $model = $this->_tagFactory->create();
        $collection = $model->getCollection();
        $tags = [];
        $this->_helper->getTag($tags, $collection->getData());

        return $tags;
    }
}
