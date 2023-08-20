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

Route::post('incomes/getByEmployee', [IncomeController::class, 'getByEmployee']);
Route::post('incomes/getByEmployeeAndDate', [IncomeController::class, 'getByEmployeeAndDate']);
Route::post('incomes/getByEmployeeAndGame', [IncomeController::class, 'getByEmployeeAndGame']);
Route::post('incomes/getByEmployeeGameAndDate', [IncomeController::class, 'getByEmployeeGameAndDate']);

Route::post('incomes/deleteByEmployee', [IncomeController::class, 'deleteByEmployee']);
Route::post('incomes/deleteByEmployeeAndDate', [IncomeController::class, 'deleteByEmployeeAndDate']);
Route::post('incomes/deleteByEmployeeAndGame', [IncomeController::class, 'deleteByEmployeeAndGame']);
Route::post('incomes/deleteByEmployeeGameAndDate', [IncomeController::class, 'deleteByEmployeeGameAndDate']);

Route::patch('incomes/updateByEmployeeGameAndDate', [IncomeController::class, 'updateByEmployeeGameAndDate']);
