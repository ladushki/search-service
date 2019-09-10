<?php

namespace App\Api\V1\Controllers;

use App\Handlers\ImportVehicleHandler;
use App\Http\Controllers\Controller;
use App\Imports\Import;
use App\Imports\VehicleImport;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{
    //
    public function index()
    {

        $result = app(ImportVehicleHandler::class)
            ->load(storage_path('imports/vehicles.csv'))
            ->run();
        return response()->json($result);

    }
}
