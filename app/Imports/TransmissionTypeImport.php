<?php


namespace App\Imports;

use App\Interactions\CreateCompany;
use App\Interactions\CreateFuelType;
use App\Interactions\CreateOwner;
use App\Interactions\CreateTransmissionType;


class TransmissionTypeImport extends Import implements ImportInterface
{

    public function map(array $row): array
    {
        return [
            'name'=>$row['H']??null,
        ];
    }

    public function import(array $data)
    {
        $mapped = $this->map(array_filter($data));
        return CreateTransmissionType::run($mapped);
    }
}