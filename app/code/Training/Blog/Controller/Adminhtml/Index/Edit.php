<?php

namespace Training\Blog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Training_Blog::save';

    protected Registry $_coreRegistry;
    protected PageFactory $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Load layout and set active menu
     */
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Training_Blog::blog_manager');

        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('blog_id');
        $model = $this->_objectManager->create('Training\Blog\Model\Blog');
        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                $this->messageManager->addError(__('This blog no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('blog', $model);

        $resultPage = $this->_initAction();
        $resultPage->getConfig()
            ->getTitle()
            ->prepend($model->getId() ? $model->getName() : __('Create Blog'));

        return $resultPage;
    }
}
