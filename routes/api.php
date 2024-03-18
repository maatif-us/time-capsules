<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\CapsuleController;
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

Route::post('register', [AuthController::class,'register'])->name('user.register');
Route::post('login',    [AuthController::class,'login'])->name('user.login');



Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user',   [AuthController::class, 'getUser']);



    Route::group(['prefix' => 'capsule'], function () {
        Route::get('/all', [CapsuleController::class, 'index']);
        Route::post('/store', [CapsuleController::class, 'store']);
        Route::get('/view/{id}', [CapsuleController::class, 'view']);
        Route::patch('/update/{id}', [CapsuleController::class, 'update']);
        Route::delete("/{id}", [CapsuleController::class, 'destroy']);
    });
  });