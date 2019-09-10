<?php


namespace App\Imports;

use App\Interactions\CreateCompany;
use App\Interactions\CreateFuelType;
use App\Interactions\CreateOwner;


class FuelTypeImport extends Import implements ImportInterface
{

    public function map(array $row): array
    {
        return [
            'name'=>$row['G']??null,
        ];
    }

    public function import(array $data)
    {
        $mapped = $this->map(array_filter($data));
        return CreateFuelType::run($mapped);
    }
}