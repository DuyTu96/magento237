<?php
namespace Training\Blog\Ui\DataProvider\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Data\Collection;
use Magento\Ui\DataProvider\AddFilterToCollectionInterface;

class AddCategoriesFilterToGrid implements AddFilterToCollectionInterface
{
    public function addFilter(Collection $collection, $field, $condition = null)
    {
        dd(123);
        if (isset($condition['gteq'])) {
            $collection->addFieldToFilter([[
                'attribute' => 'yearly_views', 'gteq' => $condition['gteq']]
            ]);
        }
        if (isset($condition['lteq'])) {
            $collection->addFieldToFilter([[
                'attribute' => 'yearly_views', 'lteq' => $condition['lteq']]
            ]);
        }
    }
}
