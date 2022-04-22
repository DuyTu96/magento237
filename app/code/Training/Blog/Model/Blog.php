<?php

namespace Training\Blog\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Training\Blog\Api\Data\BlogInterface;

class Blog extends AbstractExtensibleModel implements BlogInterface
{
    const ENTITY_ID = 'blog_id';
    const TITLE = 'name';
    const SHORT_DESCRIPTION = 'short_description';
    const DESCRIPTION = 'description';
    const STATUS = 'status';
    const THUMBNAIL = 'thumbnail';
    const GALLERY = 'gallery';
    const PUBLISH_DATE_FROM = 'publish_date_from';
    const PUBLISH_DATE_TO = 'publish_date_to';
    const CATEGORIES = 'categories';
    const TAGS = 'tags';
    const URL_KEY = 'url_key';
    const PRODUCT_IDS = 'product_ids';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Blog's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected function _construct()
    {
        $this->_init(\Training\Blog\Model\ResourceModel\Blog::class);
    }

    /**
     * Prepare blog's statuses.
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    public function setEntityId($entityId)
    {
        $this->setData(self::ENTITY_ID, $entityId);
        return $this;
    }

    public function getShortDescription()
    {
        return $this->getData(self::SHORT_DESCRIPTION);
    }

    public function setShortDescription($value)
    {
        $this->setData(self::SHORT_DESCRIPTION, $value);
        return $this;
    }

    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    public function setDescription($value)
    {
        $this->setData(self::DESCRIPTION, $value);
        return $this;
    }

    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    public function setStatus($value)
    {
        $this->setData(self::STATUS, $value);
        return $this;
    }

    public function getThumbnail()
    {
        return $this->getData(self::THUMBNAIL);
    }

    public function setThumbnail($value)
    {
        $this->setData(self::THUMBNAIL, $value);
        return $this;
    }

    public function getGallery()
    {
        return $this->getData(self::GALLERY);
    }

    public function setGallery($value)
    {
        $this->setData(self::GALLERY, $value);
        return $this;
    }

    public function getPublishDateFrom()
    {
        return $this->getData(self::PUBLISH_DATE_FROM);
    }

    public function setPublishDateFrom($value)
    {
        $this->setData(self::PUBLISH_DATE_FROM, $value);
        return $this;
    }

    public function getPublishDateTo()
    {
        return $this->getData(self::PUBLISH_DATE_TO);
    }

    public function setPublishDateTo($value)
    {
        $this->setData(self::PUBLISH_DATE_TO, $value);
        return $this;
    }

    public function getCategories()
    {
        return $this->getData(self::CATEGORIES);
    }

    public function setCategories($value)
    {
        $this->setData(self::CATEGORIES, $value);
        return $this;
    }

    public function getTags()
    {
        return $this->getData(self::TAGS);
    }

    public function setTags($value)
    {
        $this->setData(self::TAGS, $value);
        return $this;
    }

    public function getUrlKey()
    {
        return $this->getData(self::URL_KEY);
    }

    public function setUrlKey($value)
    {
        $this->setData(self::URL_KEY, $value);
        return $this;
    }

    public function getProductIds()
    {
        return $this->getData(self::PRODUCT_IDS);
    }

    public function setProductIds($value)
    {
        $this->setData(self::PRODUCT_IDS, $value);
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt($value)
    {
        $this->setData(self::CREATED_AT, $value);
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function setUpdatedAt($value)
    {
        $this->setData(self::UPDATED_AT, $value);
        return $this;
    }
}
