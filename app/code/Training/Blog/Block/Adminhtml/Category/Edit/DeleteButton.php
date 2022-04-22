<?php

namespace Training\Blog\Block\Adminhtml\Category\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * Create Button
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getCategoryId()) {
            $data = [
                'label' => __('Delete Image'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        dd($data);
        return $data;
    }

    /**
     * Get URL for Button
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['category_id' => $this->getCategoryId()]);
    }
}
