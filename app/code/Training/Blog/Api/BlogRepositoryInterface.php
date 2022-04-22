<?php

namespace Training\Blog\Api;

use Training\Blog\Api\Data\BlogInterface;

interface BlogRepositoryInterface
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
}
