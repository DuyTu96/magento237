<?php

namespace Training\Blog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Training\Blog\Model\Blog;
use Magento\Framework\App\Request\DataPersistorInterface;
use Training\Blog\Model\CategoryBlogFactory;
use Training\Blog\Model\Repository\BlogRepository;

class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Training_Blog::save';

    protected PostDataProcessor $dataProcessor;
    protected DataPersistorInterface $dataPersistor;
    protected CategoryBlogFactory $categoryBlogFactory;
    protected $_blogRepository;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param CategoryBlogFactory $categoryBlogFactory
     */
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        CategoryBlogFactory $categoryBlogFactory,
        BlogRepository $blogRepository
    )
    {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->categoryBlogFactory = $categoryBlogFactory;
        $this->_blogRepository = $blogRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $test = $this->_blogRepository->getById(2);
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (isset($data)) {
            if (isset($data['status'])) $data['status'] = $data['status'] === '0' ? Blog::STATUS_DISABLED :Blog::STATUS_ENABLED;

            if (empty($data['blog_id'])) $data['blog_id'] = null;

            if (empty($data['images'])) {
                $data['thumbnail'] = null;
            } else {
                if ($data['images'][0] && $data['images'][0]['name'])
                    $data['thumbnail'] = $data['images'][0]['name'];
                else
                    $data['thumbnail'] = null;
            }

            if (empty($data['gallery'])) {
                $data['gallery'] = null;
            } else {
                $gallery = [];
                foreach ($data['gallery'] as $img) {
                    $gallery[] = $img['name'];
                }

                $data['gallery'] = json_encode($gallery);
            }

            if (isset($data['categories'])) {
                foreach ($data['categories'] as $category) {
                    $dataCategoryBlog[]['category_id'] = (int) $category;
                }
            }


            if (!empty($data['categories'])) $data['categories'] = json_encode($data['categories']);
            if (!empty($data['tags'])) $data['tags'] = json_encode($data['tags']);
            if (!empty($data['product_ids'])) $data['product_ids'] = json_encode($data['product_ids']);

            $model = $this->_objectManager->create('Training\Blog\Model\Blog');
            $modelCategoryBlog = $this->_objectManager->create('Training\Blog\Model\CategoryBlog');

            $id = $this->getRequest()->getParam('blog_id');
            if ($id) {
                $model->load($id);
            }

            if (!$this->dataProcessor->validateRequireEntry($data, $id)) {
                return $resultRedirect->setPath('*/*/edit', ['blog_id' => $model->getId(), '_current' => true]);
            }

            $model->setData($data);

            try {
                $model->save();

                if (isset($dataCategoryBlog)) {
                    foreach ($dataCategoryBlog as $key => $item) {
                        $dataCategoryBlog[$key]['blog_id'] = $model->getId();
                    }
                    if ($id) {
                        $categoryBlogCollection = $this->categoryBlogFactory->create()->getCollection();
                        $dataOld = $categoryBlogCollection->addFieldToFilter('blog_id', ['eq' => (int) $id])->getData();
                        foreach ($dataOld as $value) {
                            $categoryBlogCollection->load((int) $value['id'])->walk('delete');
                        }
                    }
                    foreach ($dataCategoryBlog as $item) {
                        $modelCategoryBlog->setData($item);
                        $modelCategoryBlog->save();
                    }
                }

                $this->messageManager->addSuccess(__('You saved the blog.'));
                $this->dataPersistor->clear('blog');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['blog_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the blog.'));
            }

            $this->dataPersistor->set('blog', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
