<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Resources\VehicleResource;
use App\Http\Controllers\Controller;
use App\Repositories\VehicleRepository;
use App\Repositories\VehicleSearchRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct(VehicleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request): JsonResponse
    {
        $filter = $request->only('owner', 'year', 'license_plate', 'sort', 'year_sort');

        if (!empty($filter)) {
            $result = VehicleSearchRepository::apply($request);
        } else {
            $result = $this->repository->getAll();
        }

        return response()->json(VehicleResource::collection($result));
    }
}
