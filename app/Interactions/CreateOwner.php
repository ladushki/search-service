<?php

namespace App\Interactions;

use App\Repositories\OwnerRepository;
use ZachFlower\EloquentInteractions\Interaction;

class CreateOwner extends Interaction
{
    /**
     * Parameter validations
     *
     * @var array
     */
    public $validations = [
        'full_name'=>'required|max:255',
        'profession'=>'required|max:255',
    ];

    /**
     * Execute the interaction
     *
     * @return void
     */
    public function execute() {
        return app(OwnerRepository::class)->save($this->params);
    }
}
