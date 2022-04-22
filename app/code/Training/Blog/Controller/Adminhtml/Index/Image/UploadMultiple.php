<?php

namespace Training\Blog\Controller\Adminhtml\Index\Image;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;

class UploadMultiple extends Action
{

    protected ImageUploader $imageUploader;
    protected DateTime $dateTime;

    public function __construct(
        Context $context,
        ImageUploader $imageUploader,
        DateTime $dateTime
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
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
            $_FILES['gallery']['name'] = $this->renameImage($_FILES['gallery']['name']);
            $result = $this->imageUploader->saveFileToTmpDir('gallery');
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
