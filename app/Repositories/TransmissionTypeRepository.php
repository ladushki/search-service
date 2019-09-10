<?php


namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use App\TransmissionType;

class TransmissionTypeRepository extends Repository implements RepositoryInterface
{
    public function __construct(TransmissionType $model)
    {
        $this->model = $model;
    }

    public function save(array $item)
    {
        return $this->model->updateOrCreate(['name' => $item['name']], $item);
    }
}