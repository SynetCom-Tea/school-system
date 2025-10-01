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
use Modules\Scolarite\Http\Controllers\InscriptionController;

    Route::prefix('scolarite')->group(function() {

        // les routes pour l'inscriptions
        Route::resource('inscriptions', \Modules\Scolarite\Http\Controllers\InscriptionController::class);
        Route::get('/inscription/page/',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'addPage'])->name('inscriptionPage'); 
        Route::get('/inscription/checkClasse/{niveau}/{etabSection}',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'checkClasse'])->name('getcheckClasse'); 
        Route::get('/inscription/getFrais/{niveau}/{annee}',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'getFrais'])->name('getfrais'); 
        Route::get('/liste_inscription_by_recherche',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'ajaxInscriptionListe'])->name('getInscriptionsByRecherche'); 
        // Route::get('/liste_inscription_about_mle',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'ajaxGetInscriptionAboutMle'])->name('getInscriptionAboutMle'); 
        // Route::get('/liste_inscription_by_niveau',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'ajaxInscriptionByNiveau'])->name('getInscriptionsByNiveau'); 
        // Route::get('/liste_inscription_by_classe',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'ajaxInscriptionByClasse'])->name('getInscriptionsByClasse'); 
        // Route::get('/liste_inscription_by_cycle_filiere',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'ajaxInscriptionByCycleFiliere'])->name('getInscriptionsByCycleFiliere'); 
        // Route::get('/liste_inscription_by_statut',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'ajaxInscriptionByStatut'])->name('getInscriptionsByStatut'); 
        // Route::get('/liste_inscription_by_annee',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'ajaxInscriptionByAnnee'])->name('getInscriptionsByAnnee'); 
        // Route::get('/liste_inscription_by_section',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'ajaxInscriptionBySection'])->name('getInscriptionsBySection'); 
        // Route::get('/delete_inscription',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'supInscription'])->name('deleteInscription'); 
        // Route::get('/generate_releve_note',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'releveNote'])->name('generateReleveNote'); 
        // Route::get('/export_inscriptions',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'exportInscriptions'])->name('exportInscriptions');     
        
        // Routes d'export avec des noms cohérents
        Route::get('/inscriptions/export/{format}', [\Modules\Scolarite\Http\Controllers\InscriptionController::class, 'exportInscriptions'])
        ->name('inscriptions.export');
    
        Route::get('/inscriptions/export-payees/{format}', [\Modules\Scolarite\Http\Controllers\InscriptionController::class, 'exportInscriptionsPayees'])
        ->name('inscriptions.export.payees');

        Route::get('/inscriptions/export-combinees/{format}', [\Modules\Scolarite\Http\Controllers\InscriptionController::class, 'exportInscriptionsCombine'])
        ->name('inscriptions.export.combinees');
    
        Route::get('/inscriptions/export-non-payees/{format}', [\Modules\Scolarite\Http\Controllers\InscriptionController::class, 'exportInscriptionsNonPayees'])
        ->name('inscriptions.export.non-payees');
        
        // les routes pour le versement
        Route::resource('versements', \Modules\Scolarite\Http\Controllers\VersementController::class);
        Route::get('/inscription_for_versement',[\Modules\Scolarite\Http\Controllers\VersementController::class,'ajaxGetInscriptionForVersement'])->name('getInscriptionForVersement'); 
        Route::get('/liste_inscription_about_mle',[\Modules\Scolarite\Http\Controllers\VersementController::class,'ajaxGetInscriptionAboutMle'])->name('getInscriptionAboutMle'); 
        
        
        Route::get('/calcul_frais',[\Modules\Scolarite\Http\Controllers\VersementController::class,'calculFrais'])->name('getCalculFrais');
        Route::get('/save_versement',[\Modules\Scolarite\Http\Controllers\VersementController::class,'saveVersement'])->name('postVersement'); 
        Route::get('/delete_versement',[\Modules\Scolarite\Http\Controllers\VersementController::class,'supVersement'])->name('deleteVersement'); 
        Route::get('/generate_recu_versement',[\Modules\Scolarite\Http\Controllers\VersementController::class,'recuVersement'])->name('generateRecuVersement'); 
        Route::get('/generate_recu_inscription',[\Modules\Scolarite\Http\Controllers\InscriptionController::class,'recuInscription'])->name('generateRecuInscription'); 
        
        
        // Fiches de présence
        Route::get('/scolarite/fiche-presence', [InscriptionController::class, 'genererFichePresence'])
            ->name('scolarite.fiche.presence');

        // Listes d'affichage
        Route::get('/scolarite/liste-affichage', [InscriptionController::class, 'genererListeAffichage'])
            ->name('scolarite.liste.affichage');


        Route::get('/scolarite/fiche-presence-avancee', [InscriptionController::class, 'genererFichePresenceAvancee'])
            ->name('scolarite.fiche.presence.avancee');

        Route::get('/scolarite/fiche-presence-pdf', [InscriptionController::class, 'genererFichePresencePdf'])
            ->name('scolarite.fiche.presence.pdf');

        Route::get('/scolarite/fiches-pdf-par-classe', [InscriptionController::class, 'genererFichesPdfParClasse'])
            ->name('scolarite.fiches.pdf.classe');
            
        
          
    });

