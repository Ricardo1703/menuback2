<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('menuClientes/{id}', [ProductoController::class, 'menuClientes']);
Route::get('obtenerUser/{id}', [UserController::class, 'obtenerUser']);


Route::group(['middleware' => ["auth:sanctum"]], function(){
    Route::get('logout', [UserController::class, 'logout']);
    Route::put('update/{id}', [UserController::class, 'update']);
    Route::put('editPass/{id}', [UserController::class, 'editPass']);
    Route::get('mostrarUser/{id}', [UserController::class, 'mostrarUser']);
    Route::get('menu/{id}', [ProductoController::class, 'menu']);
    Route::post('editPlatillo/{id}', [ProductoController::class, 'editPlatillo']);
    Route::post('agregarPlatillo/{id}', [ProductoController::class, 'agregarPlatillo']);
    Route::post('fotoPerfil/{id}', [UserController::class, 'fotoPerfil']);
    Route::get('verFoto/{id}', [UserController::class, 'verFoto']);
    Route::delete('destroy/{id}', [ProductoController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
