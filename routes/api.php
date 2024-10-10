<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PasienController;

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

// Pasien API routes
Route::get('/pasiens', [PasienController::class, 'index']);
Route::post('/pasiens', [PasienController::class, 'store']);
Route::get('/pasiens/{id}', [PasienController::class, 'show']);
Route::put('/pasiens/{id}', [PasienController::class, 'update']);
Route::delete('/pasiens/{id}', [PasienController::class, 'destroy']);