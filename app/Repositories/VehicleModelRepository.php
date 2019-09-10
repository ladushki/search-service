<?php


namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use App\VehicleModel;
use Illuminate\Database\Eloquent\Collection;

class VehicleModelRepository extends Repository implements RepositoryInterface
{

    public function __construct(VehicleModel $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->with('manufacture')->get();
    }

    public function save(array $item)
    {
        return $this->model->updateOrCreate(
            ['name' => $item['name'], 'manufacturer_id' => $item['manufacturer_id']],
            $item
        );
    }

    public function exists(array $item): bool
    {
        $item = $this->model->where('license_plate', '=', $item->license_plate)->first();
        return (bool)$item;
    }
}