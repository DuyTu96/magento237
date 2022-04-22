<?php

namespace Training\Blog\Model\Repository;

use Training\Blog\Model\TagFactory;
use Training\Blog\Api\TagRepositoryInterface;
use Training\Blog\Model\Tag;

class TagRepository implements TagRepositoryInterface
{
    const ENTITY_ID = Tag::ENTITY_ID;
    /**
     * @var TagFactory
     */
    protected TagFactory $modelFactory;

    /**
     * BlogRepository constructor.
     * @param TagFactory $modelFactory
     */
    public function __construct(
        TagFactory $modelFactory
    ) {
        $this->modelFactory = $modelFactory;
    }

    public function getById(int $id)
    {
        return $this->modelFactory->create()->load($id)->getData();
    }

    public function getMultipleById($ids)
    {
        $model = $this->modelFactory->create();
        $collection = $model->getCollection();

        return $collection->addFieldToFilter(self::ENTITY_ID, ['in' => $ids])->getData();
    }

    public function getList()
    {
        return $this->modelFactory->create()->getCollection()->getData();
    }

    public function save($data)
    {
        $model = $this->modelFactory->create();
        $model->setData($data);

        return $model->save();
    }
}
