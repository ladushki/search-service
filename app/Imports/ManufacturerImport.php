<?php


namespace App\Imports;

use App\Interactions\CreateCompany;
use App\Interactions\CreateFuelType;
use App\Interactions\CreateManufacture;
use App\Interactions\CreateOwner;


class ManufacturerImport extends Import implements ImportInterface
{

    public function map(array $row): array
    {
        return [
            'name'=>$row['I']??null,
        ];
    }

    public function import(array $data)
    {
        $mapped = $this->map(array_filter($data));
        return CreateManufacture::run($mapped);
    }
}