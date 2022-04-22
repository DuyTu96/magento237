<?php

namespace Training\Blog\Model\ResourceModel;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\AbstractModel;

class Blog extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('blogs', 'blog_id');
    }

    protected function _afterSave(AbstractModel $object)
    {
        $newImage = $object->getData('thumbnail');
        try {
            $imageUploader = ObjectManager::getInstance()->get('Training\Blog\BlogImageUpload');
            $imageUploader->moveFileFromTmp($newImage);
        } catch (\Exception $e) {

        }
        $newGallery = $object->getData('gallery');
        if (isset($newGallery)) {
            $newGallery = json_decode($newGallery);

            foreach ($newGallery as $gallery) {
                try {
                    $imageUploader = ObjectManager::getInstance()->get('Training\Blog\BlogImageUploadMultiple');
                    $imageUploader->moveFileFromTmp($gallery);
                } catch (\Exception $e) {

                }
            }
        }

        return $this;
    }
}
