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
use App\Http\Controllers\NonBookAntrianController;
use App\Http\Controllers\BookAntrianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookRM_Controller;
use App\Models\BookAntrian;


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

Route::get('/booking-antrian', [BookAntrianController::class, 'showCurrentAntrian'])->name('show.antrian');
// Route for auto-updating with JSON data
Route::get('/fetch-antrian', [BookAntrianController::class, 'fetchCurrentAntrian'])->name('fetch.antrian');

Route::get('/bookantrian/latest', function () {
    // $bookantrians = BookAntrian::latest()->get(); // Adjust to your specific requirements
    // return response()->json($bookantrians);
     // Eager load user and poliklinik relationships
      // Fetch the latest bookantrians in descending order
    $bookantrians = BookAntrian::with(['user', 'poliklinik'])
    ->orderBy('created_at', 'desc') // Adjust the column name as necessary
    ->get();

return response()->json($bookantrians);
});
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin', [MedikaAdminController::class, 'index'])->name('admin.index');
    Route::resource('admin/users', MedikaAdminController::class);
    Route::resource('admin/dokters', MedikaDokterController::class); 
    Route::resource('admin/pasiens', MedikaPasienController::class); 
    Route::resource('admin/obats', MedikaObatController::class); 
    Route::resource('admin/polikliniks', MedikaPoliklinikController::class); 
    Route::resource('admin/rekammedis', RekamMedisController::class);
    Route::resource('admin/non_bookantrian', NonBookAntrianController::class); 
    Route::resource('admin/bookantrian', BookAntrianController::class); 
    Route::resource('admin/book_rm', BookRM_Controller::class); 
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
