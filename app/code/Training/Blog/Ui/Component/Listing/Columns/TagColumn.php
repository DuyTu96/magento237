<?php

namespace Training\Blog\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Training\Blog\Model\TagFactory;

class TagColumn extends Column
{
    protected TagFactory $_tagFactory;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        TagFactory $tagFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_tagFactory = $tagFactory;
    }

    /**
     * Prepare Data Source
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            $model = $this->_tagFactory->create();
            $collection = $model->getCollection();
            $listCategory = $collection->getData();

            foreach ($dataSource['data']['items'] as & $item) {
                $tags = json_decode($item[$fieldName]);
                $item[$fieldName] = $tags;
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
