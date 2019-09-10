<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Collection;

abstract class Repository implements RepositoryInterface
{

    protected $model;


    public function getAll(): Collection
    {
        return $this->model->get();
    }

    public function create(array $item)
    {
        return $this->model->create($item);
    }

    public function update(array $item)
    {
        $this->model->fill($item)->save();
        return $this->model;
    }

    public function exists(array $item): bool
    {
        $item = $this->model->where('name', 'LIKE', $item['name'])->first();
        return (bool)$item;
    }
}