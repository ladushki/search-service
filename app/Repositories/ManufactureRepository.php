<?php


namespace App\Repositories;

use App\Manufacturer;
use App\Repositories\RepositoryInterface;

class ManufactureRepository extends Repository implements RepositoryInterface
{

    public function __construct(Manufacturer $model)
    {
        $this->model = $model;
    }

    public function save(array $item)
    {
        return $this->model->updateOrCreate(['name' => $item['name']], $item);
    }

    public function exists(array $item): bool
    {
        $item = $this->model->where('name', 'LIKE', $item['name'])->first();
        return (bool)$item;
    }
}