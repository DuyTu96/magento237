<?php

namespace Training\Blog\Helper;
use \Magento\Framework\App\Helper\AbstractHelper;

class Helper extends AbstractHelper
{
    public function getCategories(&$arr, $categories, $parentId = "0", $char = '')
    {
        foreach ($categories as $key => $category) {
            if (isset($category['parent_id']) && $category['parent_id'] === $parentId) {
                $arr[$key] = [
                    'value' => (int) $category['category_id'],
                    'label' => $char . $category['name']
                ];
                unset($categories[$key]);
                $this->getCategories($arr, $categories, $category['category_id'], $char . '____');
            }
        }
    }

    public function getCategoriesNoChar(&$arr, $categories, $parentId = "0")
    {
        foreach ($categories as $key => $category) {
            if (isset($category['parent_id']) && $category['parent_id'] === $parentId) {
                $arr[$key] = [
                    'value' => (int) $category['category_id'],
                    'label' => $category['name']
                ];
                unset($categories[$key]);
                $this->getCategoriesNoChar($arr, $categories, $category['category_id']);
            }
        }
    }

    public function getTag(&$arr, $tags, $parentId = "0", $char = '')
    {
        foreach ($tags as $key => $tag) {
            $arr[$key] = [
                'value' => (int) $tag['tag_id'],
                'label' => $char . $tag['name']
            ];
            unset($tags[$key]);
            $this->getTag($arr, $tags, $tag['tag_id'], $char . '____');
        }
    }
}
