<?php

namespace Training\Blog\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Training\Blog\Model\CategoryFactory;

class CategoryColumn extends Column
{
    protected CategoryFactory $_categoryFactory;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CategoryFactory $categoryFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_categoryFactory = $categoryFactory;
    }

    /**
     * Prepare Data Source
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            $model = $this->_categoryFactory->create();
            $collection = $model->getCollection();
            $listCategory = $collection->getData();

            foreach ($dataSource['data']['items'] as & $item) {
                $categories = json_decode($item[$fieldName]);

//                $categoryName = '';
//                foreach ($categories as $category) {
//                    $categoryName .= $this->searchData($listCategory, 'category_id', $category) . '
//                    ';
//                }
//
//                $item[$fieldName] = $categoryName;
                $item[$fieldName] = $categories;
            }
        }

        return $dataSource;
    }

    function searchData($arrays, $key, $search) {
        $name = '';

        foreach($arrays as $object) {
            if(is_object($object)) $object = get_object_vars($object);
            if(array_key_exists($key, $object) && $object[$key] == $search) return $object['name'];
        }

        return $name;
    }
}
