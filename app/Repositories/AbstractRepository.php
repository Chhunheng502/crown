<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements RepositoryInterface
{
    private String $modelClass;
    protected Model $model;

    public function __construct($modelClass = null)
    {
        $this->modelClass = $modelClass ?: self::guessModelClass();
        $this->model = app($this->modelClass);
    }

    public static function guessModelClass()
    {
        return preg_replace('/(.+)\\\\Repositories\\\\(.+)Repository$/m', '$1\Models\\\$2', static::class);
    }

    public function getbyId($id)
    {
        return $this->model->find($id);
    }

    public function getByIds($ids)
    {
        return $this->model->whereIn('id', $ids);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}