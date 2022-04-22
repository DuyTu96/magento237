<?php

namespace Training\Blog\Api;

use Training\Blog\Api\Data\BlogInterface;

interface CategoryRepositoryInterface
{
    /**
     * @param int $id
     * @return BlogInterface
     */
    public function getById(int $id);

    /**
     * @return mixed
     */
    public function getList();

    /**
     * @param $data
     * @return mixed
     */
    public function save($data);

    /**
     * @param $ids
     * @return mixed
     */
    public function getMultipleById($ids);
}
