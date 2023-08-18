<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\EmployeeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/tests', function () {
    return response([
        'message' => 'API is working fine'
    ], 200);
});

Route::post('register', [AuthenticationController::class,'register']);
Route::post('login', [AuthenticationController::class,'login']);



Route::resource('employees', EmployeeController::class);
Route::resource('games', GameController::class);
Route::resource('incomes', IncomeController::class);
Route::resource('owners', OwnerController::class);

Route::get('incomes/byEmployee/{employee_username}', [IncomeController::class, 'getByEmployee']);
Route::get('incomes/byEmployeeAndDate/{employee_username}/{date}', [IncomeController::class, 'getByEmployeeAndDate']);
Route::get('incomes/byEmployeeAndGame/{employee_username}/{game_name}', [IncomeController::class, 'getByEmployeeAndGame']);
Route::get('incomes/byEmployeeAndGameAndDate/{employee_username}/{game_name}/{date}', [IncomeController::class, 'getByEmployeeAndGameAndDate']);
