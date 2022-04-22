<?php

namespace Training\Blog\Model\Config;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Option\ArrayInterface;

/**
 * Class Status
 * @package ViMagento\HelloWorld\Model\Config
 */
class Tag implements ArrayInterface
{
    /**
     * @return array[]
     */
    public function toOptionArray()
    {
        $objectManager = ObjectManager::getInstance();
        $model = $objectManager->create('Training\Blog\Model\Tag');
        $data = $model->getCollection()->getData();

        $cats = [];
        $this->getChild($cats, $data);

        return $cats;
    }

    private function getChild(&$arr, $tags)
    {
        foreach ($tags as $key => $tag) {
            $arr[$key] = [
                'value' => (int) $tag['tag_id'],
                'label' => $tag['name']
            ];
            unset($tags[$key]);
        }
    }
}
