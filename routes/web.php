<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionsController;




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

    Route::group(['middleware' => ['role:superadmin|admin']], function(){
        // User
        Route::get('/users/index', [UsersController::class, 'index']);
        Route::get('/users/dashboard', [UsersController::class, 'dashboard']);
        Route::post('/users/index', [UsersController::class, 'store']);
        // User END

        // Role 
        Route::get('/roles/index', [RolesController::class, 'index']);
        Route::get('/roles/dashboard', [RolesController::class, 'dashboard']);
        Route::post('/roles/index', [RolesController::class, 'store']);
        // Role END

        // Permissions 
        Route::get('/permissions/index', [PermissionsController::class, 'index']);
        Route::get('/permissions/dashboard', [PermissionsController::class, 'dashboard']);
        // Permission END
    });


    Route::get('/signout', [AuthController::class,'signout']);


});

