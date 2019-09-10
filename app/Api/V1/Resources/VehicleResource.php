<?php

namespace App\Api\V1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'license_plate' => $this->license_plate,
            'year_of_purchase' => $this->year_of_purchase,
            'owner_name' => $this->owner->full_name,
            'owner_profession' => $this->owner->profession,
            'owner_company' => optional($this->owner->company)->name,
            'colour' => $this->color,
            'fuel_type' => $this->fuelType->name,
            'transmission' => $this->transmissionType->name,
            'manufacturer' => $this->vehicleModel->manufacturer->name,
            'model' => $this->vehicleModel->name,
            'num_seats' => $this->seats,
            'num_doors' => $this->doors,
          //  'modified' => $this->updated_at,
        ];
    }
}
