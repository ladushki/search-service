<?php

namespace App\Interactions;

use App\Repositories\TransmissionTypeRepository;
use ZachFlower\EloquentInteractions\Interaction;

class CreateTransmissionType extends Interaction
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
        return app(TransmissionTypeRepository::class)->save($this->params);
    }
}
