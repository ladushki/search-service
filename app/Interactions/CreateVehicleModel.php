<?php

namespace App\Interactions;

use App\Repositories\VehicleModelRepository;
use ZachFlower\EloquentInteractions\Interaction;

class CreateVehicleModel extends Interaction
{
    /**
     * Parameter validations
     *
     * @var array
     */
    public $validations = [
       'name'=>'required',
       'manufacturer_id'=>'required|integer',
    ];

    /**
     * Execute the interaction
     *
     * @return void
     */
    public function execute() 
    {
        return app(VehicleModelRepository::class)->save($this->params);
    }
}
