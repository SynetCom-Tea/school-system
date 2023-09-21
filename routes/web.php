<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EtablissementController;

use Modules\GestionNote\Http\Controllers\NoteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Modules\Scolarite\Http\Controllers\EtudiantsController;
use Modules\Scolarite\Http\Controllers\AnneeController;
use Modules\Scolarite\Http\Controllers\ClasseController;
use Modules\Scolarite\Http\Controllers\AnneeClasseController;
use Modules\Scolarite\Http\Controllers\TuteurController;
use Modules\Scolarite\Http\Controllers\NiveauController;
use Modules\Scolarite\Http\Controllers\InscriptionController;



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
// AbdoulAZIZ
// Route::prefix('enseignement')->group(function () {
//     Route::get('/', 'EnseignementController@index');
//     Route::resource('ues', UEController::class)->only(['index', 'create', 'store', 'edit', 'update']);
//     Route::resource('fillieres', FilliereController::class)->only(['index', 'create', 'store', 'update', 'destroy']);
//     Route::resource('etablissements', EtablissementController::class)->only(['index', 'create', 'store', 'update', 'destroy']);
//     Route::resource('cycles', CycleController::class)->only(['index', 'create', 'destroy', 'store', 'update']);
//     Route::resource('permissions', PermissionController::class);
//     Route::resource('roles', RoleController::class)->only(['index', 'store', 'update', 'destroy']);
// });

Route::get('/', function () {
    return Inertia::render('welcome/Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        //'laravelVersion' => Application::VERSION,
        // 'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// Route::prefix('gestionnote')->group(function () {
//     Route::get('/', 'GestionNoteController@index');
//     Route::resource('evaluation', \Modules\GestionNote\Http\Controllers\EvaluationController::class);
//     // Affichage de notes
//     Route::get('/note/affichage', [NoteController::class, 'index'])->name('note.affichage');
//     Route::get('/note/attribution', [NoteController::class, 'attribution'])->name('note.attribution');
//     Route::post('/note/enregistrer', [NoteController::class, 'store'])->name('note.save');
// });
Route::middleware('auth')->group(function () {
    Route::group(['middleware' => ['checkRoles:Super-administrateur,Administrateur']], function () {
        Route::resource('users', UserController::class);
    });
    Route::get('get-users-by-category/{params}/', [UserController::class, 'getUsersByCategory'])->name('getUsersByCategory');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('salles', SalleController::class);
});

Route::resource('etudiants', EtudiantsController::class);
Route::resource('annees', AnneeController::class);
Route::resource('classes', ClasseController::class);
Route::resource('promotions', AnneeClasseController::class);
Route::resource('tuteurs', TuteurController::class);
Route::resource('niveaux', NiveauController::class);
Route::resource('etablissements', EtablissementController::class);
Route::post('/activation/{id}', [EtablissementController::class, 'activer'])->name('etablissement.activer');
Route::resource('inscriptions', InscriptionController::class);
Route::get('/NotFoud', [UserController::class, 'NotFoud'])->name('NotFoud');

require __DIR__ . '/auth.php';
