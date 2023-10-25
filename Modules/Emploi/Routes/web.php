<?php

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

use Illuminate\Support\Facades\Route;

Route::prefix('emploi')->group(function() {
    Route::resource('emplois', \Modules\Emploi\Http\Controllers\EmploiController::class);
    Route::resource('absences', \Modules\Emploi\Http\Controllers\AbsenceController::class);
    Route::get('calendar', [\Modules\Emploi\Http\Controllers\EmploiController::class, 'calendar'])->name('calendar.index');
});;