<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserLoginMedika;
use App\Http\Controllers\Auth\MedikaRegisterController;
use App\Http\Controllers\MedikaAdminController;
use App\Http\Controllers\MedikaDokterController;
use App\Http\Controllers\MedikaPasienController;
use App\Http\Controllers\MedikaObatController;
use App\Http\Controllers\MedikaPoliklinikController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin', [MedikaAdminController::class, 'index'])->name('admin.index');
    Route::resource('admin/users', MedikaAdminController::class);
    Route::resource('admin/dokters', MedikaDokterController::class); 
    Route::resource('admin/pasiens', MedikaPasienController::class); 
    Route::resource('admin/obats', MedikaObatController::class); 
    Route::resource('admin/polikliniks', MedikaPoliklinikController::class); 
    Route::resource('admin/rekammedis', RekamMedisController::class); 
});
//login example
Route::get('/loginpuspita', [LoginController::class, 'showLoginForm'])->name('login.puspita');
Route::post('/loginpuspita', [LoginController::class, 'login']);
Route::post('/logoutAll', [LoginController::class, 'logout'])->name('logout.all');
//login mymedika
Route::get('/loginMedika', [UserLoginMedika::class, 'showLoginForm'])->name('login.medika');
Route::post('/loginMedika', [UserLoginMedika::class, 'login']);
Route::post('/logoutMedika', [UserLoginMedika::class, 'logout'])->name('logout.medika');
//signup example
Route::get('/registerpuspita', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/registerpuspita', [RegisterController::class, 'register']);
//signup Medika
Route::get('/registerMedika', [MedikaRegisterController::class, 'showRegistrationForm'])->name('register.medika');
Route::post('/registerMedika', [MedikaRegisterController::class, 'register']);



Route::get('/', function () {
    return redirect('/loginMedika');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
