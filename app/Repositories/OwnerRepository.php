<?php


namespace App\Repositories;

use App\Company;
use App\Owner;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OwnerRepository extends Repository implements RepositoryInterface
{

    public function __construct(Owner $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->with('company')->get();
    }

    public function save(array $item)
    {
        return $this->model->updateOrCreate(['full_name' => $item['full_name']], $item);
    }

    public function exists(array $item): bool
    {
        $item = $this->model->where('full_name', '=', $item['full_name'])->first();
        return (bool)$item;
    }
}