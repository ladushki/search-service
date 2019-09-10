<?php

namespace App\Interactions;

use App\Repositories\ManufactureRepository;
use ZachFlower\EloquentInteractions\Interaction;

class CreateManufacture extends Interaction
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
    public function execute() {
        return app(ManufactureRepository::class)->save($this->params);
    }
}
