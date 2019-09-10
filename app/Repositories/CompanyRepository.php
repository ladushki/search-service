<?php


namespace App\Repositories;

use App\Company;
use App\Repositories\RepositoryInterface;

class CompanyRepository extends Repository implements RepositoryInterface
{

    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    public function save(array $item): Company
    {
        return $this->model->updateOrCreate(['name' => $item['name']], $item);
    }

}