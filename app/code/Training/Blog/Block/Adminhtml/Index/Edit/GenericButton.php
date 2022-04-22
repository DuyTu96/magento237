<?php

namespace Training\Blog\Block\Adminhtml\Index\Edit;

use Magento\Backend\Block\Widget\Context;
use Training\Blog\Model\BlogFactory;

class GenericButton
{

    protected Context $context;
    protected BlogFactory $blogFactory;

    public function __construct(
        Context $context,
        BlogFactory $blogFactory
    )
    {
        $this->context = $context;
        $this->blogFactory = $blogFactory;
    }

    /**
     * Return blog ID
     */
    public function getblogId()
    {
        $id = $this->context->getRequest()->getParam('id');
        $blog = $this->blogFactory->create()->load($id);
        if ($blog->getId()) return $id;

        return null;
    }

    /**
     * Generate url by route and parameters
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
