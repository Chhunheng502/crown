<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getById($id);

    public function getByIds($ids);

    public function getAll();
}