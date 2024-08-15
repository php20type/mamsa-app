<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SymptomController;
use App\Http\Controllers\BodypartController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MedicalFecilityController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OutboundController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientMonitorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/update-profile', [PatientController::class, 'updateData'])->name('update.profile');

Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/doctor', [OutboundController::class, 'index'])->name('doctor');

});
Route::get('/call/{patient_id}', [OutboundController::class, 'call'])->name('outboundCall');

Route::post('/add-symptoms', [SymptomController::class, 'store'])->name('store.symptoms');
Route::get('/delete-symptoms/{id}', [SymptomController::class, 'delete'])->name('delete.symptoms');

Route::post('/add-medication', [MedicationController::class, 'store'])->name('store.medication');
Route::get('/delete-medication/{id}', [MedicationController::class, 'delete'])->name('delete.medication');

Route::post('/add-fecility', [MedicalFecilityController::class, 'store'])->name('store.fecility');
Route::get('/delete-fecility/{id}', [MedicalFecilityController::class, 'delete'])->name('delete.fecility');

Route::post('/add-bodyparts', [BodypartController::class, 'store'])->name('store.bodyparts');
Route::get('/delete-bodyparts/{id}', [BodypartController::class, 'delete'])->name('delete.bodyparts');

Route::post('/add-patient', [PatientController::class, 'store'])->name('store.patient');

Route::get('/delete-patient/{id}', [PatientController::class, 'delete'])->name('delete.patient');
Route::post('/update-frequency', [PatientController::class, 'updateFrequency']);
Route::get('/changeLanguage/{lang}',[LanguageController::class,'changeLanguage'])->name('changeLanguage');
Route::get('/getHistory',[OutboundController::class,'getHistory']);
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [LoginController::class, 'showAdminLogin'])->name('admin.login-view');
    Route::post('/login', [LoginController::class, 'adminLogin'])->name('admin.login');
    Route::get('/logout', [LoginController::class, 'adminLogout'])->name('admin.logout');
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/symptoms', [SymptomController::class, 'index'])->name('symptoms');
        Route::get('/bodyparts', [BodypartController::class, 'index'])->name('bodyparts');
        Route::get('/medications', [MedicationController::class, 'index'])->name('medications');
        Route::get('/medical-fecilities',[MedicalFecilityController::class,'index'])->name('medical-fecilities');
        Route::get('/patients', [PatientController::class, 'index'])->name('patients');
        Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors');
    });
});
Route::group(['prefix' => 'doctor','middleware' => 'auth:web'], function () {
    Route::post('/sendGroupMessage',[MessageController::class,'sendGroupMessage'])->name('sendGroupMessage');
    Route::post('/replyMessage',[MessageController::class,'replyMessage'])->name('replyMessage');
    Route::get('/patients', [PatientController::class, 'patientFile'])->name('doctor.patients');
    Route::get('/getPatientList', [PatientController::class, 'getPatientList'])->name('doctor.getPatientList');
    Route::post('/add-patient', [PatientController::class, 'storePatientFile'])->name('doctor.store.patient');
    Route::get('/delete-patient/{id}', [PatientController::class, 'delete'])->name('doctor.delete.patient');
    Route::get('/monitoring',[PatientMonitorController::class,'index'])->name('patientMonitoring');
    Route::post('/add-monitoring', [PatientMonitorController::class, 'store'])->name('doctor.store.monitoring');
    Route::get('/delete-monitoring/{id}', [PatientMonitorController::class, 'delete'])->name('doctor.delete.monitoring');
    Route::get('/patient-report/{patient_id}',[PatientController::class,'patientDetail'])->name('patientDetail');
    Route::get('/edit-patient/{id}',[PatientController::class,'editPatient'])->name('editPatient');
    Route::post('/update-medical-condition', [PatientController::class, 'updateMedicalCondition'])->name('updateMedicalCondition');
});
