<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {return inertia('Welcome');});
Route::get('/home', function () {  return inertia('Home/Index'); });

Route::resource('employees', App\Http\Controllers\UserController::class);
Route::post('/employee/import', [App\Http\Controllers\ImportController::class, 'index']);
Route::post('/employee/store', [App\Http\Controllers\ImportController::class, 'store']);

Route::resource('calendar', App\Http\Controllers\CalendarController::class);
Route::resource('dtr', App\Http\Controllers\HR\DtrController::class);
Route::resource('leave', App\Http\Controllers\HR\LeaveController::class);
Route::resource('survey', App\Http\Controllers\HR\SurveyController::class);
Route::resource('cto', App\Http\Controllers\HR\CtoController::class);

Route::resource('travel', App\Http\Controllers\TravelController::class);

require __DIR__.'/auth.php';