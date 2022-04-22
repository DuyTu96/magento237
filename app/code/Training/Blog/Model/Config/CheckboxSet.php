<?php

namespace Training\Blog\Model\Config;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Option\ArrayInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

/**
 * Class Status
 * @package ViMagento\HelloWorld\Model\Config
 */
class CheckboxSet implements ArrayInterface
{
    protected $_productCollectionFactory;

    public function __construct(CollectionFactory $productCollectionFactory)
    {
        $this->_productCollectionFactory = $productCollectionFactory;
    }

    /**
     * @return array[]
     */
    public function toOptionArray()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->setPageSize(3); // fetching only 3 products
        dd($collection);

        return $collection;

        $objectManager = ObjectManager::getInstance();
        $model = $objectManager->create('Training\Blog\Model\Category');
        $category = $model->getCollection()->getData();
        $categories = [];
        $this->getChild($categories, $category);

        return $categories;
    }

    private function getChild(&$arr, $categories, $parentId = "0", $char = '')
    {
        foreach ($categories as $key => $category) {
            if ($category['parent_id'] === $parentId) {
                $arr[$key] = [
                    'value' => (int) $category['category_id'],
                    'label' => $char . $category['name']
                ];
                unset($categories[$key]);
                $this->getChild($arr, $categories, $category['category_id'], $char . '__');
            }
        }
    }
}
