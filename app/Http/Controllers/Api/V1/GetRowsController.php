<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Row;
use App\Services\RowsService;
use Illuminate\Http\JsonResponse;

class GetRowsController extends Controller
{
    public function __invoke(RowsService $service): JsonResponse
    {
        return response()->json($service->get());
    }
}
