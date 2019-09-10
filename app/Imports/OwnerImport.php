<?php


namespace App\Imports;


use App\Interactions\CreateOwner;
use App\Interactions\CreateVehicle;

class OwnerImport extends Import implements ImportInterface
{
    public function map(array $row): array
    {
        return [
            'full_name'=>$row['C'],
            'profession'=>$row['D'],
            'company_id'=>$this->getCompanyId($row),
        ];
    }

    public function import(array $data)
    {
        $mapped = $this->map(array_filter($data));
        return CreateOwner::run($mapped);
    }

    public function getCompanyId($row)
    {
        $data = app(CompanyImport::class)->import($row);
        if($this->validate($data, 'Company import failed. ')){
            return $data->result->id;
        }
        return null;
    }

}