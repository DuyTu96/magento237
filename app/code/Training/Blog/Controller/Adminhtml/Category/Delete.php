<?php

namespace Training\Blog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Training_Blog::delete';

    public function execute()
    {
        $id = $this->getRequest()->getParam('category_id');

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('Training\Blog\Model\Category');
                $model->load($id);
                $id = $model->getId();
                $model->delete();

                $this->messageManager->addSuccess(__('The blog has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['category_id' => $id]);
            }
        }

        $this->messageManager->addError(__('We can\'t find a blog to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
