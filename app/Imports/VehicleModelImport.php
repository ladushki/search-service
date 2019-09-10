<?php


namespace App\Imports;

use App\Interactions\CreateVehicleModel;

class VehicleModelImport extends Import implements ImportInterface
{

    /**
     * @param array $row
     *
     * @return array
     * @throws \App\Exceptions\ImportException
     */
    public function map(array $row): array
    {
        return [
            'name'=>$row['J']??null,
            'manufacturer_id'=> $this->getManufacturerId($row),
        ];
    }

    /**
     * @param array $data
     *
     * @return Object
     * @throws \ZachFlower\EloquentInteractions\Exceptions\ValidationException
     */
    public function import(array $data): Object
    {
        $mapped = $this->map(array_filter($data));
        return CreateVehicleModel::run($mapped);
    }

    /**
     * @param array $row
     *
     * @return mixed
     * @throws \App\Exceptions\ImportException
     */
    public function getManufacturerId(array $row): ?int
    {
        $data = app(ManufacturerImport::class)->import($row);
        if($this->validate($data, 'Manufacturer import failed. ')) {
            return (int)$data->result->id;
        }
        return null;
    }

}