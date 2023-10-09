<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParsingRequest;
use Illuminate\Http\JsonResponse;

class ParsingController extends Controller
{
    public function __invoke(ParsingRequest $request): JsonResponse
    {
        return response()->json(['filename' => $request->file('file')->getClientOriginalName()]);
    }
}
