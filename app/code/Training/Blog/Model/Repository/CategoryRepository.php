<?php

namespace Training\Blog\Model\Repository;

use Training\Blog\Model\Category;
use Training\Blog\Model\CategoryFactory;
use Training\Blog\Api\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    const ENTITY_ID = Category::ENTITY_ID;
    /**
     * @var CategoryFactory
     */
    protected CategoryFactory $modelFactory;

    /**
     * BlogRepository constructor.
     * @param CategoryFactory $modelFactory
     */
    public function __construct(
        CategoryFactory $modelFactory
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
