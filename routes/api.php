<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/auth')->middleware(['guest'])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('schools')->middleware(['auth:sanctum'])->group(function () {
    Route::post('/', [SchoolController::class, 'store']);
    Route::put('/{school:code}', [SchoolController::class, 'update']);
    Route::get('/{school:code}', [SchoolController::class, 'show']);
    Route::delete('/{school:code}', [SchoolController::class, 'destroy']);
});
