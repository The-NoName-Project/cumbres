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
Route::post('/question', [Api\QuestionController::class, 'store']);
Route::get('/question/all', [Api\QuestionController::class, 'show']);
Route::get('/results', [Api\QuestionController::class, 'showVisor']);
Route::post('/q', [Api\QuestionController::class, 'storeVisor']);

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/user', [Auth\AuthController::class, 'user']);
    Route::post('/logout', [Auth\AuthController::class, 'logout']);
    Route::get('/question', [Api\QuestionController::class, 'index']);
    Route::get('/all-users', function(){
        //consulta todos los usuarios y remplaza el id de la escuela por el nombre de la escuela
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            $user->school = \App\Models\School::find($user->school_id);
        }
        //consulta todos los usuarios y remplaza el id del rol por el nombre del rol
        foreach ($users as $user) {
            $user->role = \App\Models\Roles::find($user->role_id);
        }
        //consulta todos los usuarios y remplaza el id del level por el nombre del level
        foreach ($users as $user) {
            $user->level = \App\Models\Level::find($user->level_id);
        }
        return response()->json($users, 200);
        //return response()->json($u, 200);
    });
    Route::get('/sports', [Api\SportsController::class, 'index']);
    Route::get('/activities', [Api\ActivitiesController::class, 'index']);
    Route::post('/activities', [Api\ActivitiesController::class, 'store']);
    Route::get('/activities/{id}', [Api\ActivitiesController::class, 'show']);
    Route::put('/activities/{id}', [Api\ActivitiesController::class, 'update']);
    Route::delete('/activities/{id}', [Api\ActivitiesController::class, 'destroy']);
});
