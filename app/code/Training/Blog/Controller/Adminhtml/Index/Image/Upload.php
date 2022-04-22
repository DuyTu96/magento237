<?php

namespace Training\Blog\Controller\Adminhtml\Index\Image;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Stdlib\DateTime\DateTime;

class Upload extends Action
{

    protected ImageUploader $imageUploader;
    protected DirectoryList $dir;
    protected DateTime $dateTime;

    public function __construct(
        Context $context,
        ImageUploader $imageUploader,
        DirectoryList $dir,
        DateTime $dateTime
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
        $this->dir = $dir;
        $this->dateTime = $dateTime;
    }

    /**
     * Check admin permissions for this controller
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Training_Blog::save');
    }

    public function execute()
    {
        try {
            $_FILES['images']['name'] = $this->renameImage($_FILES['images']['name']);
            $result = $this->imageUploader->saveFileToTmpDir('images');
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }

    private function renameImage(string $name) {
        $chunkName = explode('.', $name);
        $timestamp = $this->dateTime->gmtTimestamp();
        $typeFile = $chunkName[count($chunkName) - 1];

        return $timestamp . '.' . $typeFile;
    }
}
