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

    Route::prefix('scolarite')->group(function() {
        Route::resource('inscriptions', \Modules\Scolarite\Http\Controllers\InscriptionController::class);
        Route::get('/inscription/page/',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'addPage'])->name('inscriptionPage'); 
        Route::get('/inscription/checkClasse/{niveau}/{etabSection}',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'checkClasse'])->name('getcheckClasse'); 
        Route::get('/inscription/getFrais/{niveau}',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'getFrais'])->name('getfrais'); 
          
    });

