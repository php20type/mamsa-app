<?php

use App\Http\Controllers\BodypartController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SymptomController;
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

Route::get('/symptoms',[SymptomController::class,'list']);
Route::get('/get-symptoms/{value}',[SymptomController::class,'getDetails']);
Route::get('/bodyparts',[BodypartController::class,'list']);
Route::get('/getPatientData/{phone_number}',[PatientController::class,'getPatientData']);
Route::post('/storeMonitorHistory',[PatientController::class,'storeMonitorHistory']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

