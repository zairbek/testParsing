<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParsingRequest;
use App\Services\ParsingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ParsingController extends Controller
{
    public function __invoke(ParsingRequest $request, ParsingService $service): JsonResponse
    {
        $service->parse($request);

        return response()->json(['message' => 'in process'], Response::HTTP_ACCEPTED);
    }
}
