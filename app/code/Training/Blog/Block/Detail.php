<?php
namespace Training\Blog\Block;

use Magento\Catalog\Helper\Image;
use \Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Training\Blog\Model\BlogFactory;
use Training\Blog\Model\TagFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Detail extends Template
{
    protected BlogFactory $_blogFactory;
    protected TagFactory $_tagFactory;
    protected TimezoneInterface $date;
    protected CollectionFactory $_productCollectionFactory;
    protected Image $imageHelper;

    public function __construct(
        Context $context,
        BlogFactory $blogFactory,
        TagFactory $tagFactory,
        TimezoneInterface $date,
        CollectionFactory $productCollectionFactory,
        Image $imageHelper
    ) {
        $this->_blogFactory = $blogFactory;
        $this->_tagFactory = $tagFactory;
        $this->date = $date;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->imageHelper = $imageHelper;
        parent::__construct($context);
    }

    /**
     * @return array|mixed|null
     */
    public function getBlogById() {
        $id = $this->getRequest()->getParam('blog_id');

        $blog = $this->_blogFactory->create();

        return $blog->load($id)->getData();
    }

    public function getTags() {
        $model = $this->_tagFactory->create();
        $collection = $model->getCollection();

        return $collection->getData();
    }

    public function getProductById($product_ids) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $data = [];
        foreach ($product_ids as $product_id) {
            $product = $objectManager->create('Magento\Catalog\Model\Product')->load($product_id);
            $data[] = $product->getData();
        }

        return $data;
    }
}
