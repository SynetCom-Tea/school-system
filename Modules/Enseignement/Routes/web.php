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
Route::middleware('auth')->group(function () {
    Route::prefix('enseignement')->group(function() {
        Route::get('/', 'EnseignementController@index');
        Route::get('/configuration/{type}',[\Modules\Enseignement\Http\Controllers\EnseignementController::class, 'config'])->name('admin.config');
        Route::get('/configuration/lmd/{type}',[\Modules\Enseignement\Http\Controllers\EnseignementController::class, 'lmd'])->name('admin.lmd');
        Route::post('/configuration/lmd/store',[\Modules\Enseignement\Http\Controllers\EnseignementController::class, 'storelmd'])->name('lmd.store');
    });
});
