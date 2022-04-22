<?php

namespace Training\Blog\Model\Config;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Option\ArrayInterface;

/**
 * Class Status
 * @package ViMagento\HelloWorld\Model\Config
 */
class Category implements ArrayInterface
{
    /**
     * @return array[]
     */
    public function toOptionArray()
    {
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
