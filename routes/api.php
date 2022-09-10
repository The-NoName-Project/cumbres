<?php

namespace App\Http\Controllers;

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
Route::get('/', function () {
    return response()->json(['message' => 'CUMBRES API Laravel'], 200);;
});

Route::post('/login', [Auth\AuthController::class, 'login']);
Route::post('/register', [Auth\AuthController::class, 'signup']);
Route::get('/school', [Api\SchoolController::class, 'index']);
Route::get('/level', [Api\LevelController::class, 'index']);
Route::get('/role', [Api\RolesController::class, 'index']);


Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/user', [Auth\AuthController::class, 'user']);
    Route::post('/logout', [Auth\AuthController::class, 'logout']);
    Route::get('/question', [Api\QuestionController::class, 'index']);
    Route::post('/question', [Api\QuestionController::class, 'store']);
    Route::get('/all-users', function(){
        $u =\App\Models\User::all();
        return response()->json($u, 200);
    });
});
