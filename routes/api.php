<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\UserController;
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




Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);






Route::group(['middleware'=>'auth:api'],function (){
    Route::get('user',[UserController::class,'user']);
    Route::put('users/info',[UserController::class,'updateInfo']);
    Route::put('users/password',[UserController::class,'updatePassword']);
    Route::apiResource('users',UserController::class);
    Route::apiResource('rules',RuleController::class);
    Route::apiResource('products',ProductController::class);
    Route::apiResource('orders',OrderController::class)->only(['index','show']);
    Route::apiResource('permissions',PermissionController::class)->only(['index']);
    Route::get('chart',[DashboardController::class,'chart']);
    Route::get('export',[OrderController::class,'export']);
    Route::get('logout',[AuthController::class,'logout']);
});



