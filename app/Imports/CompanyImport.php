<?php


namespace App\Imports;

use App\Interactions\CreateCompany;
use App\Interactions\CreateOwner;


class CompanyImport extends Import implements ImportInterface
{

    public function map(array $row): array
    {
        return [
            'name'=>$row['E']??null,
        ];
    }

    public function import(array $data)
    {
        $mapped = $this->map(array_filter($data));
        return CreateCompany::run($mapped);
    }
}