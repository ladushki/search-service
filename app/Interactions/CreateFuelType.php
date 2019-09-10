<?php

namespace App\Interactions;

use App\Repositories\FuelTypeRepository;
use ZachFlower\EloquentInteractions\Interaction;

class CreateFuelType extends Interaction
{
    /**
     * Parameter validations
     *
     * @var array
     */
    public $validations = [
        'name'=>'required',
    ];

    /**
     * Execute the interaction
     *
     * @return void
     */
    public function execute() 
    {
        return app(FuelTypeRepository::class)->save($this->params);
    }
}
