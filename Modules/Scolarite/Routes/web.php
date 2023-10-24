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

        // les routes pour l'inscriptions
        Route::resource('inscriptions', \Modules\Scolarite\Http\Controllers\InscriptionController::class);
        Route::get('/inscription/page/',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'addPage'])->name('inscriptionPage'); 
        Route::get('/inscription/checkClasse/{niveau}/{etabSection}',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'checkClasse'])->name('getcheckClasse'); 
        Route::get('/inscription/getFrais/{niveau}/{annee}',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'getFrais'])->name('getfrais'); 
        Route::get('/liste_inscription_by_recherche',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'ajaxInscriptionListe'])->name('getInscriptionsByRecherche'); 
        
        // les routes pour le versement
        Route::resource('versements', \Modules\Scolarite\Http\Controllers\VersementController::class);
        Route::get('/inscription_for_versement',[\Modules\Scolarite\Http\Controllers\VersementController::class,'ajaxGetInscriptionForVersement'])->name('getInscriptionForVersement'); 
        Route::get('/calcul_frais',[\Modules\Scolarite\Http\Controllers\VersementController::class,'calculFrais'])->name('getCalculFrais');
        Route::get('/save_versement',[\Modules\Scolarite\Http\Controllers\VersementController::class,'saveVersement'])->name('postVersement'); 
        Route::get('/delete_versement',[\Modules\Scolarite\Http\Controllers\VersementController::class,'supVersement'])->name('deleteVersement'); 
        
        
        
          
    });

