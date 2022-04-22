<?php

namespace Training\Blog\Model\Blog;

use Magento\Framework\Api\Filter;
use Magento\Framework\UrlInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Training\Blog\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends AbstractDataProvider
{
    protected $loadedData;
    protected $collection;
    protected DataPersistorInterface $dataPersistor;
    protected StoreManagerInterface $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $blogCollectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $blogCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        if (empty($items)) return [];

        foreach ($items as $blog) {
            $data = $blog->getData();
            $thumbnail = $data['thumbnail'];
            if ($thumbnail && is_string($thumbnail)) {
                $data['images'][0]['name'] = $thumbnail;
                $data['images'][0]['url'] = $this->storeManager
                        ->getStore()
                        ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'blog/images/' . $thumbnail;
            }
            if ($data['gallery'] && is_string($data['gallery'])) {
                $newDataGallery = [];
                $gallery = json_decode($data['gallery']);
                foreach ($gallery as $k => $img) {
                    $newDataGallery[$k]['name'] = $img;
                    $newDataGallery[$k]['url'] = $this->storeManager
                            ->getStore()
                            ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'blog/images/' . $img;
                }

                $data['gallery'] = $newDataGallery;
            }

            if ($data['categories'] && is_string($data['categories'])) {
                $data['categories'] = json_decode($data['categories']);
            }

            if ($data['tags'] && is_string($data['tags'])) {
                $data['tags'] = json_decode($data['tags']);
            }

            if ($data['product_ids'] && is_string($data['product_ids'])) {
                $data['product_ids'] = json_decode($data['product_ids']);
            }

            $this->loadedData[$blog->getId()] = $data;
        }

        $data = $this->dataPersistor->get('blog');

        if (!empty($data)) {
            $blog = $this->collection->getNewEmptyItem();
            $blog->setData($data);
            $this->loadedData[$blog->getId()] = $blog->getData();
            $this->dataPersistor->clear('blog');
        }

        return $this->loadedData;
    }

    /**
     * @inheritdoc
     */
    public function addFilter(Filter $filter)
    {
        if (!empty($this->additionalFilterPool[$filter->getField()])) {
            $this->additionalFilterPool[$filter->getField()]->addFilter($this->searchCriteriaBuilder, $filter);
        } else {
            parent::addFilter($filter);
        }
    }
}
