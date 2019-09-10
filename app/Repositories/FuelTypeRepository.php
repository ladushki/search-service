<?php


namespace App\Repositories;

use App\FuelType;
use App\Repositories\RepositoryInterface;

class FuelTypeRepository extends Repository implements RepositoryInterface
{

    public function __construct(FuelType $model)
    {
        $this->model = $model;
    }

    public function save(array $item)
    {
        return $this->model->updateOrCreate(['name' => $item['name']], $item);
    }
}