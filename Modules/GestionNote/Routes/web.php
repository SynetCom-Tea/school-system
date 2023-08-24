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

Route::prefix('gestionnote')->group(function() {
    Route::get('/', 'GestionNoteController@index');
    Route::resource('evaluation',\Modules\GestionNote\Http\Controllers\EvaluationController::class);
});
