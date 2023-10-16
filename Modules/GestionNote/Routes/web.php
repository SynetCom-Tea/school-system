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
    Route::get('/evaluation/{type}',[\Modules\GestionNote\Http\Controllers\EvaluationController::class,'index']);
    Route::post('/evaluation',[\Modules\GestionNote\Http\Controllers\EvaluationController::class,'store'])->name('evaluation.store');
    Route::put('/evaluation/{id}',[\Modules\GestionNote\Http\Controllers\EvaluationController::class,'update'])->name('evaluation.update');
    Route::delete('/evaluation/{id}',[\Modules\GestionNote\Http\Controllers\EvaluationController::class,'destroy'])->name('evaluation.destroy');
    // Affichage de notes
    // Route::get('/note/affichage',[\Modules\GestionNote\Http\Controllers\NoteController::class, 'index'])->name('note.affichage');
    // Route::get('/note/attribution',[\Modules\GestionNote\Http\Controllers\NoteController::class, 'attribution'])->name('note.attribution');
    // Route::post('/note/enregistrer',[\Modules\GestionNote\Http\Controllers\NoteController::class, 'store'])->name('note.save');
    Route::get('/admin',[\Modules\GestionNote\Http\Controllers\EvaluationController::class,'indexAdmin'])->name('evaluation.index_admin');
    
    Route::get('/note/{type}',[\Modules\GestionNote\Http\Controllers\NoteController::class, 'index'])->name('note.affichage');
    Route::get('/attribution/note',[\Modules\GestionNote\Http\Controllers\NoteController::class, 'attribution'])->name('note.attribution');
    Route::post('/enregistrer/note',[\Modules\GestionNote\Http\Controllers\NoteController::class, 'store'])->name('note.save');
    Route::put('/update/note/{id}',[\Modules\GestionNote\Http\Controllers\NoteController::class, 'update'])->name('note.update');
});