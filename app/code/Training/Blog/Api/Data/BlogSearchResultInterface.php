<?php

namespace Training\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface BlogSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return BlogInterface[]
     */
    public function getItems();

    /**
     * @param BlogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
