<?php

namespace Training\Blog\Controller\Adminhtml\Index;

use Magento\Framework\Message\ManagerInterface;
use Training\Blog\Model\BlogFactory;

class PostDataProcessor
{
    protected ManagerInterface $messageManager;
    protected BlogFactory $_blogFactory;

    public function __construct(
        ManagerInterface $messageManager,
        BlogFactory $blogFactory
    ) {
        $this->messageManager = $messageManager;
        $this->_blogFactory = $blogFactory;
    }

    /**
     * @param array $data
     * @param $id
     * @return bool
     */
    public function validateRequireEntry(array $data, $id)
    {
        $blogModel = $this->_blogFactory->create();
        $blogCollection = $blogModel->getCollection();
        $requiredFields = [
            'name' => __('Name'),
            'thumbnail' => __('Thumbnail'),
            'gallery' => __('Gallery'),
            'description' => __('Description'),
            'short_description' => __('Short Description'),
        ];
        $errorNo = true;

        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addError(
                    __('"%1" field is required', $requiredFields[$field])
                );
            }

            if ($field === 'name') {
                $query = $blogCollection->addFieldToFilter('name', ['eq' => $value]);

                if ($id) {
                    $query = $query->addFieldToFilter('blog_id', ['neq' => $id]);
                }
                $query = $query->getData();
                if (count($query) > 0) {
                    $errorNo = false;
                    $this->messageManager->addError(
                        __('"%1" field is unique', $requiredFields[$field])
                    );
                }
            }
        }
        return $errorNo;
    }
}
