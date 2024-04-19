<?php

use App\Http\Controllers\PeminjamanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\RuanganController;

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
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/me', [AuthController::class, 'me']);
});

Route::group(['middleware' => 'api', 'prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/update/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::group(['middleware' => 'api', 'prefix' => 'jurusans'], function () {
    Route::get('/', [JurusanController::class, 'index']);
    Route::post('/', [JurusanController::class, 'store']);
    Route::get('/{id}', [JurusanController::class, 'show']);
    Route::put('/update/{id}', [JurusanController::class, 'update']);
    Route::delete('/{id}', [JurusanController::class, 'destroy']);
});

Route::group(['middleware' => 'api', 'prefix' => 'ruangans'], function () {
    Route::get('/', [RuanganController::class, 'index']);
    Route::post('/', [RuanganController::class, 'store']);
    Route::get('/{id}', [RuanganController::class, 'show']);
    Route::put('/update/{id}', [RuanganController::class, 'update']);
    Route::delete('/{id}', [RuanganController::class, 'destroy']);
});

Route::group(['middleware' => 'api', 'prefix' => 'barangs'], function () {
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/{id}', [BarangController::class, 'show']);
    Route::put('/update/{id}', [BarangController::class, 'update']);
    Route::delete('/{id}', [BarangController::class, 'destroy']);
});

Route::group(['middleware' => 'api', 'prefix' => 'peminjamans'], function () {
    Route::get('/', [PeminjamanController::class, 'index']);
    Route::post('/', [PeminjamanController::class, 'store']);
    Route::get('/{id}', [PeminjamanController::class, 'show']);
    Route::put('/update/{id}', [PeminjamanController::class, 'update']);
    Route::delete('/{id}', [PeminjamanController::class, 'destroy']);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
