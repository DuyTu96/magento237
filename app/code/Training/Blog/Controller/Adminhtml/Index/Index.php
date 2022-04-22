<?php

namespace Training\Blog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Training\Blog\Model\BlogFactory;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Training_Blog::blog_manager';

    protected PageFactory $resultPageFactory;
    protected BlogFactory $blogFactory;
    protected string $name;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        BlogFactory $blogFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->blogFactory = $blogFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Training_Blog::blog_manager');
        $resultPage->getConfig()->getTitle()->prepend(__('Blog manager'));

        return $resultPage;
    }

    public function getName()
    {
        return $this->name;
    }
}
