<?php

namespace Training\Blog\Model\Repository;

use Training\Blog\Model\BlogFactory;
use Training\Blog\Api\BlogRepositoryInterface;
use Training\Blog\Api\CategoryRepositoryInterface;
use Training\Blog\Api\TagRepositoryInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Framework\Serialize\Serializer\Json;

class BlogRepository implements BlogRepositoryInterface
{
    const TOPIC_NAME = 'training.queue.blog';
    protected PublisherInterface $publisher;

    /**
     * @var BlogFactory
     */
    protected BlogFactory $blogFactory;
    protected CategoryRepositoryInterface $_categoryRepository;
    protected TagRepositoryInterface $_tagRepository;

    /**
     * BlogRepository constructor.
     * @param BlogFactory $blogFactory
     * @param CategoryRepositoryInterface $categoryRepository
     * @param TagRepositoryInterface $tagRepository
     * @param PublisherInterface $publisher
     * @param Json $json
     */
    public function __construct(
        BlogFactory $blogFactory,
        CategoryRepositoryInterface $categoryRepository,
        TagRepositoryInterface $tagRepository,
        PublisherInterface $publisher,
        Json $json
    ) {
        $this->blogFactory = $blogFactory;
        $this->_categoryRepository = $categoryRepository;
        $this->_tagRepository = $tagRepository;
        $this->publisher = $publisher;
        $this->json = $json;
    }

    public function getById(int $id)
    {
        return $this->blogFactory->create()->load($id)->getData();
    }

    public function getList()
    {
        // $data = [1, 2, 3];
        // $this->publisher->publish(self::TOPIC_NAME, $this->json->serialize($data));
        // dd(123);
        $objectManager = ObjectManager::getInstance();
        $data = $this->blogFactory->create()->getCollection()->getData();

        foreach ($data as $key => $item) {
            $gallery = json_decode($item['gallery']);
            if (isset($gallery)) {
                foreach ($gallery as $keyGallery => $image) {
                    $gallery[$keyGallery] = '/media/blog/images/' . $image;
                }
            }
            $data[$key]['gallery'] = $gallery;
            $data[$key]['categories'] = $this->_categoryRepository->getMultipleById(json_decode($item['categories']));
            $data[$key]['tags'] = $this->_tagRepository->getMultipleById(json_decode($item['tags']));
            $products = json_decode($item['product_ids']);
            foreach ($products as $id) {
                $product = $objectManager->create('Magento\Catalog\Model\Product')->load($id);
                $prd[] = $product->getData();
            }
            $data[$key]['product_ids'] = $prd ?? [];
        }

        return $data;
    }

    public function save($data)
    {
        $model = $this->blogFactory->create();
        $model->setData($data);

        return $model->save();
    }
}
