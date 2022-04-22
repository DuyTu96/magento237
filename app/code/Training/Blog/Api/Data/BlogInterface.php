<?php

namespace Training\Blog\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface BlogInterface extends ExtensibleDataInterface
{
    public function getEntityId();
    public function setEntityId($entityId);
    public function getShortDescription();
    public function setShortDescription($value);
    public function getDescription();
    public function setDescription($value);
    public function getStatus();
    public function setStatus($value);
    public function getThumbnail();
    public function setThumbnail($value);
    public function getGallery();
    public function setGallery($value);
    public function getPublishDateFrom();
    public function setPublishDateFrom($value);
    public function getPublishDateTo();
    public function setPublishDateTo($value);
    public function getCategories();
    public function setCategories($value);
    public function getTags();
    public function setTags($value);
    public function getUrlKey();
    public function setUrlKey($value);
    public function getProductIds();
    public function setProductIds($value);
    public function getCreatedAt();
    public function setCreatedAt($value);
    public function getUpdatedAt();
    public function setUpdatedAt($value);
}
