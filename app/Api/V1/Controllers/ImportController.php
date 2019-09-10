<?php

namespace App\Api\V1\Controllers;

use App\Handlers\ImportVehicleHandler;
use App\Http\Controllers\Controller;
use App\Imports\Import;
use App\Imports\VehicleImport;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{

    /**
     * @var ImportVehicleHandler
     */
    private $handler;

    /**
     * ImportController constructor.
     *
     * @param ImportVehicleHandler $handler
     */
    public function __construct(ImportVehicleHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ImportException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \App\Exceptions\InvalidContentException
     */
    public function index(): JsonResponse
    {

        $result = $this->handler->load(config('api.file'))->run();
        return response()->json($result);
    }


}
