<?php


namespace App\Imports;

use App\Interactions\CreateVehicleModel;

class VehicleModelImport extends Import implements ImportInterface
{

    public function map(array $row): array
    {
        return [
            'name'=>$row['J'],
            'manufacturer_id'=> $this->getManufacturerId($row),
        ];
    }

    public function import(array $data)
    {
        $mapped = $this->map(array_filter($data));
        return CreateVehicleModel::run($mapped);
    }

    public function getManufacturerId($row): int
    {
        $data = app(ManufacturerImport::class)->import($row);
        if($this->validate($data, 'Manufacturer import failed. ')){
            return $data->result->id;
        }
        return null;
    }

}