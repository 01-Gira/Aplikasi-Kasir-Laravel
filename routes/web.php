<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;



// use AuthController;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [AuthController::class,'index'])->name('login');
Route::post('/', [AuthController::class,'login']);
Route::group(['middleware' => ['auth']], function(){
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard.index');
    Route::get('/users/index', [UsersController::class, 'index']);
    Route::get('/signout', [AuthController::class,'signout']);


});

