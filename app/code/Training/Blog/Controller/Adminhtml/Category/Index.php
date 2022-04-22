<?php

namespace Training\Blog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{

    const ADMIN_RESOURCE = 'Training_Blog::blog_manager';

    protected PageFactory $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Training_Blog::blog_manager');
        $resultPage->getConfig()->getTitle()->prepend(__('Category manager'));

        return $resultPage;
    }

}
