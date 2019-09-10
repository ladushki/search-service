<?php


namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use App\Vehicle;
use Illuminate\Database\Eloquent\Collection;

class VehicleRepository extends Repository implements RepositoryInterface
{

    public function __construct(Vehicle $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->with('owner', 'transmissionType', 'fuelType', 'vehicleModel')->get();
    }

    public function save(array $item)
    {
        return $this->model->updateOrCreate(['license_plate' => $item['license_plate']], $item);
    }

    public function exists(array $item): bool
    {
        $item = $this->model->where('license_plate', '=', $item['license_plate'])->first();
        return (bool)$item;
    }
}