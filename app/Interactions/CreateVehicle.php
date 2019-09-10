<?php

namespace App\Interactions;

use App\Repositories\VehicleRepository;
use ZachFlower\EloquentInteractions\Interaction;

class CreateVehicle extends Interaction
{
    /**
     * Parameter validations
     *
     * @var array
     */
    public $validations = [
        'license_plate' => 'required|max:255',
        'year_of_purchase' => 'required|integer',
        'owner_id' => 'required|integer',
        'color' => 'required|max:255',
        'seats' => 'required|integer',
        'doors' => 'required|integer',
        'fuel_type_id' => 'required|integer',
        //'fuel_type_id' => 'required|integer',
    ];


    public function execute() {
        return app(VehicleRepository::class)->save($this->params);
    }
}
