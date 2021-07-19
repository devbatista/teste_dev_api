<?php

use App\Http\Controllers\ClientesController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('clientes', [ClientesController::class, 'index']);
Route::get('cliente/{id}', [ClientesController::class, 'show']);
Route::post('cliente', [ClientesController::class, 'store']);
Route::put('cliente/{id}', [ClientesController::class, 'update']);
Route::delete('cliente/{id}', [ClientesController::class, 'destroy']);