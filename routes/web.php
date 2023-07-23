<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProductsController;




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

    Route::group(['middleware' => ['role:superadministrator|administrator']], function(){
        // User
        Route::get('/users/index', [UsersController::class, 'index']);
        Route::post('/users/index', [UsersController::class, 'store']);
        Route::put('/users/index', [UsersController::class, 'update']);
        Route::get('/users/get-data', [UsersController::class, 'getData']);
        Route::get('/users/dashboard', [UsersController::class, 'dashboard']);
        Route::delete('/users/index', [UsersController::class, 'destroy']);

        // User END

        // Role 
        Route::get('/roles/index', [RolesController::class, 'index']);
        Route::get('/roles/dashboard', [RolesController::class, 'dashboard']);
        Route::post('/roles/index', [RolesController::class, 'store']);
        // Role END

        // Permissions 
        Route::get('/permissions/index', [PermissionsController::class, 'index']);
        Route::get('/permissions/dashboard', [PermissionsController::class, 'dashboard']);
        Route::post('/permissions/index', [PermissionsController::class, 'store']);

        // Permission END
    });

    Route::get('/products/index', [ProductsController::class, 'index']);
    Route::get('/products/dashboard', [ProductsController::class, 'dashboard']);
    Route::post('/products/index', [ProductsController::class, 'store']);
    Route::delete('/products/index', [ProductsController::class, 'delete']);
    Route::get('/products/slug', [ProductsController::class, 'slug']);
    Route::get('/products/dashboard', [ProductsController::class, 'dashboard']);



    Route::get('/signout', [AuthController::class,'signout']);


});

