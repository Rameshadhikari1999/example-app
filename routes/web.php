<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Monolog\Handler\RollbarHandler;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::post('/store', function (Request $request) {
//     return $request->all();
// });
Route::get('/', [UserController::class, 'index']);
Route::post('/store', [UserController::class, 'store']);
Route::get('/delete/{id}', [UserController::class, 'delete']);
Route::get('/edit/{id}', [UserController::class, 'edit']);
Route::post('/update/{id}', [UserController::class, 'update']);
Route::get('search', [UserController::class, 'search']);

Route::get('/jquery', [UserController::class, 'jquery']);
Route::post('/jquery/store', [UserController::class, 'jquerystore']);
Route::delete('/jquery/delete/{id}', [UserController::class, 'jquerydelete']);
Route::get('/jquery/edit/{id}', [UserController::class, 'jqueryedit']);
Route::post('/jquery/update/{id}', [UserController::class, 'jqueryupdate']);
