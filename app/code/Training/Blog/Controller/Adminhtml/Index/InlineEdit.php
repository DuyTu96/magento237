<?php

namespace Training\Blog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Training\Blog\Model\BlogFactory;

class InlineEdit extends Action
{

    const ADMIN_RESOURCE = 'Training_Blog::save';

    protected BlogFactory $blogFactory;
    protected JsonFactory $jsonFactory;

    public function __construct(
        Context $context,
        BlogFactory $blogFactory,
        JsonFactory $jsonFactory
    )
    {
        parent::__construct($context);
        $this->blogFactory = $blogFactory;
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
                $blog = $this->blogFactory->create();
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
