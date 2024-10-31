<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PasienController;
use App\Http\Controllers\API\DokterController;
use App\Http\Controllers\API\ObatController;
use App\Http\Controllers\API\PoliklinikController;
use App\Http\Controllers\API\RM_Controller;
use App\Http\Controllers\API\Book_pasienController;
use App\Http\Controllers\API\Book_antrianController;
use App\Http\Controllers\API\Book_RM_Controller;
use App\Http\Controllers\BookAntrianController;
use App\Http\Controllers\API\AuthController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



// Pasien API routes
Route::get('/pasiens', [PasienController::class, 'index']);
Route::post('/pasiens', [PasienController::class, 'store']);
Route::get('/pasiens/{id}', [PasienController::class, 'show']);
Route::put('/pasiens/{id}', [PasienController::class, 'update']);
Route::delete('/pasiens/{id}', [PasienController::class, 'destroy']);


Route::post('/register', [AuthController::class, 'register']); // Register new user
Route::post('/login', [AuthController::class, 'login']);       // Login existing user

// Protect these routes with sanctum middleware (token-based authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); // Logout user
    Route::get('/me', [AuthController::class, 'me']);          // Get authenticated user profile
    // BookPasien routes
    Route::get('bookpasiens', [Book_pasienController::class, 'index']);
    Route::post('bookpasiens', [Book_pasienController::class, 'store']);
    Route::get('/bookpasiens/{userId}', [Book_pasienController::class, 'show']);
    Route::put('bookpasiens/{id}', [Book_pasienController::class, 'update']);
    Route::delete('bookpasiens/{id}', [Book_pasienController::class, 'destroy']);
    //BookAntrian Routes
    Route::get('/bookantrian', [Book_antrianController::class, 'index']);
    Route::post('/bookantrian', [Book_antrianController::class, 'store']);
    Route::get('/bookantrian/{id}', [Book_antrianController::class, 'show']);
    Route::put('/bookantrian/{id}', [Book_antrianController::class, 'update']);
    Route::delete('/bookantrian/{id}', [Book_antrianController::class, 'destroy']);
    //rekam medis Online
    Route::get('/book-rm', [Book_RM_Controller::class, 'index']);
    Route::get('/book-rm/{id}', [Book_RM_Controller::class, 'show']);
});

//LIVE ANTRIAN
Route::get('/fetch-antrian-api', [BookAntrianController::class, 'getCurrentAntrianJson'])->name('fetch.antrian.api');

//API for DOKTER
Route::prefix('dokters')->group(function () {
    Route::get('/', [DokterController::class, 'index']);
    Route::post('/', [DokterController::class, 'store']);
    Route::get('{id}', [DokterController::class, 'show']);
    Route::put('{id}', [DokterController::class, 'update']);
    Route::delete('{id}', [DokterController::class, 'destroy']);
});
//API for Obat
Route::prefix('obats')->group(function () {
    Route::get('/', [ObatController::class, 'index']);
    Route::post('/', [ObatController::class, 'store']);
    Route::get('{id}', [ObatController::class, 'show']);
    Route::put('{id}', [ObatController::class, 'update']);
    Route::delete('{id}', [ObatController::class, 'destroy']);
});
//API for Poliklinik
Route::prefix('poliklinik')->group(function () {
    Route::get('/', [PoliklinikController::class, 'index']);
    Route::post('/', [PoliklinikController::class, 'store']);
    Route::get('{id}', [PoliklinikController::class, 'show']);
    Route::put('{id}', [PoliklinikController::class, 'update']);
    Route::delete('{id}', [PoliklinikController::class, 'destroy']);
});
//API for Rekam Medis
Route::prefix('rekammedis')->group(function () {
    Route::get('/', [RM_Controller::class, 'index']);
    Route::post('/', [RM_Controller::class, 'store']);
    Route::get('{id}', [RM_Controller::class, 'show']);
    Route::put('{id}', [RM_Controller::class, 'update']);
    Route::delete('{id}', [RM_Controller::class, 'destroy']);
});
