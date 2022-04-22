<?php

namespace Training\Blog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Training\Blog\Model\CategoryFactory;

class InlineEdit extends Action
{

    const ADMIN_RESOURCE = 'Training_Blog::save';

    protected CategoryFactory $categoryFactory;
    protected JsonFactory $jsonFactory;

    public function __construct(
        Context $context,
        CategoryFactory $categoryFactory,
        JsonFactory $jsonFactory
    )
    {
        parent::__construct($context);
        $this->categoryFactory = $categoryFactory;
        $this->jsonFactory = $jsonFactory;
    }

    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);

        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $blogId) {
            try {
                $blog = $this->categoryFactory->create();
                $blog->load($blogId);
                $blog->setData($postItems[(string)$blogId]);
                $blog->save();
            } catch (\Exception $e) {
                $messages[] = __('Something went wrong while saving the image.');
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
