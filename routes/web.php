<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\MenuGestionController;
use Modules\GestionNote\Http\Controllers\NoteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Modules\Enseignement\Http\Controllers\AffectationEnseignantController;
use Modules\Enseignement\Http\Controllers\EnseignantController;
use Modules\Scolarite\Http\Controllers\EtudiantsController;
use Modules\Scolarite\Http\Controllers\AnneeController;
use Modules\Scolarite\Http\Controllers\ClasseController;
use Modules\Scolarite\Http\Controllers\AnneeClasseController;
use Modules\Scolarite\Http\Controllers\TuteurController;
use Modules\Scolarite\Http\Controllers\NiveauController;
use Modules\Scolarite\Http\Controllers\InscriptionController;
use Modules\Scolarite\Http\Controllers\FraisController;
use Modules\Scolarite\Http\Controllers\FaculteController;
use Modules\Scolarite\Http\Controllers\DepartementController;



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
Route::prefix('enseignement')->group(function () {
    Route::get('/', 'EnseignementController@index');
    Route::resource('ues', UEController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    Route::resource('fillieres', FilliereController::class)->only(['index', 'create', 'store', 'update', 'destroy']);
    Route::resource('etablissements', EtablissementController::class)->only(['index', 'create', 'store', 'update', 'destroy']);
    Route::resource('cycles', CycleController::class)->only(['index', 'create', 'destroy', 'store', 'update']);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class)->only(['index', 'store', 'update', 'destroy']);
});

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
    // Début routes tuteurs
    Route::get('tuteurs/list-warnings', [TuteurController::class, 'listWarnings'])->name('tuteurs.listWarnings');
    Route::get('tuteurs/meetings', [TuteurController::class, 'listWarnings'])->name('tuteurs.meetings');
    Route::get('tuteurs/mail-box', [TuteurController::class, 'mailBox'])->name('tuteurs.mailBox');
    // Fin routes tuteurs
    Route::get('menu-section-primaire', [MenuGestionController::class, 'indexPrimaire'])->name('indexPrimaire');
    Route::get('menu-section-secondaire', [MenuGestionController::class, 'indexSecondaire'])->name('indexSecondaire');
    Route::get('menu-section-superieure', [MenuGestionController::class, 'indexSuperieure'])->name('indexSuperieure');
    Route::get('menu-section-universitaire', [MenuGestionController::class, 'indexUniversitaire'])->name('indexUniversitaire');
    Route::get('get-versements-by-classeAnnee-and-student/{classeAnnee}/{apprenant}', [UserController::class, 'getVersementsByClasseAnneeAndStudent'])->name('getVersementsByClasseAnneeAndStudent');
    Route::get('get-inscriptions-by-year-and-section/{year}/{section}/{niveau}', [UserController::class, 'getInscriptionsByYearAndSection'])->name('getInscriptionsByYearAndSection');
    Route::get('get-users-by-category/{params}', [UserController::class, 'getUsersByCategory'])->name('getUsersByCategory');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('salles', SalleController::class);
});

Route::resource('etudiants', EtudiantsController::class);
Route::resource('annees', AnneeController::class);
Route::resource('classes', ClasseController::class)->only(['update', 'destroy']);
Route::get('classes/{type}', [ClasseController::class, 'index'])->name('classes.index');
Route::get('Classes/{type}', [ClasseController::class, 'create'])->name('classes.create');
Route::post('classes/{type}', [ClasseController::class, 'store'])->name('classes.store');
Route::resource('promotions', AnneeClasseController::class);
Route::resource('tuteurs', TuteurController::class);
Route::resource('niveaux', NiveauController::class);
Route::resource('etablissements', EtablissementController::class);
Route::post('/activation/{id}', [EtablissementController::class, 'activer'])->name('etablissement.activer');
Route::resource('inscriptions', InscriptionController::class);
Route::resource('facultes', FaculteController::class);
Route::resource('departements', DepartementController::class);
Route::resource('matieres', MatiereController::class)->only(['update', 'destroy']);
Route::get('matieres/{type}', [MatiereController::class, 'index'])->name('matieres.index');
Route::get('Matieres/{type}', [MatiereController::class, 'create'])->name('matieres.create');
Route::post('matieres/{type}', [MatiereController::class, 'store'])->name('matieres.store');
Route::get('/NotFoud', [UserController::class, 'NotFoud'])->name('NotFoud');
Route::resource('frais', FraisController::class)->only(['update', 'destroy']);
Route::get('frais/{type}', [FraisController::class, 'index'])->name('frais.index');
Route::get('Frais/{type}', [FraisController::class, 'create'])->name('frais.create');
Route::post('frais/{type}', [FraisController::class, 'store'])->name('frais.store');
Route::resource('affectations', AffectationController::class)->only(['update', 'destroy']);
Route::get('affectation/{type}', [AffectationController::class, 'create'])->name('affectations.create');
Route::get('affectations/{type}', [AffectationController::class, 'index'])->name('affectations.index');
Route::post('affectations/{type}', [AffectationController::class, 'store'])->name('affectations.store');
Route::resource('salles', SalleController::class);
Route::resource('enseignants', EnseignantController::class)->only(['create', 'update', 'destroy']);
Route::get('enseignants', [EnseignantController::class, 'index'])->name('enseignants.index');
Route::post('enseignants', [EnseignantController::class, 'store'])->name('enseignants.store');


Route::resource('AffectationEnseignants', AffectationEnseignantController::class)->only(['update', 'destroy']);
Route::get('affectationEnseignants/{type}', [AffectationEnseignantController::class, 'create'])->name('affectationEnseignants.create');
Route::get('AffectationEnseignants/{type}', [AffectationEnseignantController::class, 'index'])->name('AffectationEnseignants.index');
Route::post('AffectationEnseignants/{type}', [AffectationEnseignantController::class, 'store'])->name('AffectationEnseignants.store');
require __DIR__ . '/auth.php';
