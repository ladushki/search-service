<?php


namespace App\Imports;

use App\Exceptions\ImportException;
use App\Interactions\CreateVehicle;

class VehicleImport extends Import implements ImportInterface
{

    public function map(array $row): array
    {
        return [
            'license_plate' => $row['A'],
            'year_of_purchase' => $row['B'],
            'owner_id' => $this->getOwnerId($row),
            'fuel_type_id' => $this->getFuelTypeId($row),
            'transmission_type_id' => $this->getTransmissionTypeId($row),
            'vehicle_model_id' => $this->getVehicleModelId($row),
            'color' => $row['F'],
            'seats' => $row['K'],
            'doors' => $row['L'],
        ];
    }

    public function getOwnerId($row)
    {
        $ownerData = app(OwnerImport::class)->import($row);
        if ($this->validate($ownerData, 'Owner import failed.')) {
            return $ownerData->result->id;
        }
        return null;
    }

    public function getTransmissionTypeId($row)
    {
        $data = app(TransmissionTypeImport::class)->import($row);
        if ($this->validate($data, 'Transmission import failed. ')) {
            return $data->result->id;
        }
        return null;
    }

    public function getFuelTypeId($row)
    {
        $data = app(FuelTypeImport::class)->import($row);
        if ($this->validate($data, 'Fuel type import failed. ')) {
            return $data->result->id;
        }
        return null;
    }

    public function getVehicleModelId($row)
    {
        $data = app(VehicleModelImport::class)->import($row);
        if ($this->validate($data, 'Vehicle Model import failed. ')) {
            return $data->result->id;
        }
        return null;
    }

    public function import(array $data): Object
    {
        $mapped = $this->map(array_filter($data));

        return CreateVehicle::run($mapped);
    }

    /**
     * @param  $data
     * @return \Illuminate\Support\Collection
     */
    private function removeHeader($data): \Illuminate\Support\Collection
    {
        $collection = collect($data);
        $collection->shift();
        return $collection;
    }
}