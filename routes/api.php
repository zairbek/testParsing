<?php

use App\Http\Controllers\Api\V1\GetRowsController;
use App\Http\Controllers\Api\V1\ParsingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('/v1')->group(static function () {
    Route::post('/parsing', ParsingController::class)->name('parsing');
    Route::get('rows', GetRowsController::class);
});
