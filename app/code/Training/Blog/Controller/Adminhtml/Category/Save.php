<?php

namespace Training\Blog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Training_Blog::save';

    protected DataPersistorInterface $dataPersistor;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor
    )
    {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (isset($data)) {
            $model = $this->_objectManager->create('Training\Blog\Model\Category');
            $id = $this->getRequest()->getParam('category_id');
            if ($id) {
                $model->load($id);
            }
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the blog.'));
                $this->dataPersistor->clear('categories');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['category_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the blog.'));
            }

            $this->dataPersistor->set('categories', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('category_id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
