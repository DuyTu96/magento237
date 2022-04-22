<?php

namespace Training\Blog\Model\Blog\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Training\Blog\Model\Blog;

class Status implements OptionSourceInterface
{

    protected Blog $blog;

    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    /**
     * Get status options
     */
    public function toOptionArray()
    {
        $availableOptions = $this->blog->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
