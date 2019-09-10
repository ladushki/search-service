<?php

namespace App\Interactions;

use App\Company;
use App\Repositories\CompanyRepository;
use ZachFlower\EloquentInteractions\Interaction;

class CreateCompany extends Interaction
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
     * @return Company
     */
    public function execute() 
    {
        return app(CompanyRepository::class)->save($this->params);
    }
}
