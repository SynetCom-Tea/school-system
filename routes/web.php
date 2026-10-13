<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\CalendrierscolaireController;
use App\Http\Controllers\ConduiteController;
use App\Http\Controllers\MenuGestionController;
use App\Http\Controllers\RapportController;
use App\Models\Annee;
use App\Models\Apprenant;
use App\Models\ClasseAnnee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\GestionNote\Http\Controllers\NoteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Modules\Enseignement\Http\Controllers\AffectationEnseignantController;
use Modules\Enseignement\Http\Controllers\EnseignantController;
use Modules\Enseignement\Http\Controllers\FilliereController;
use Modules\Enseignement\Http\Controllers\LmdController;
use Modules\Enseignement\Http\Controllers\UEController;
use Modules\Enseignement\Entities\Enseignant;
use Modules\Scolarite\Entities\Versement;
use Modules\Scolarite\Entities\Inscription;
use Modules\Scolarite\Http\Controllers\EtudiantsController;
use Modules\Scolarite\Http\Controllers\AnneeController;
use Modules\Scolarite\Http\Controllers\ClasseController;
use Modules\Scolarite\Http\Controllers\AnneeClasseController;
use Modules\Scolarite\Http\Controllers\TuteurController;
use Modules\Scolarite\Http\Controllers\NiveauController;
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
    // Route::resource('ues', UEController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    // Route::resource('etablissements', EtablissementController::class)->only(['index', 'create', 'store', 'update', 'destroy']);
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

Route::get('/dashboard', function (Request $request) {
    $annee = Annee::find($request->query('annee_id')) ?? Annee::getAnneeEnCours();
    $schoolYears = Annee::orderByDesc('id')->get(['id', 'libelle']);
    $studentCountForLevel = static function (array $levelCodes, array $classLabels) use ($annee) {
        if (!$annee) {
            return 0;
        }

        return Apprenant::where(function ($query) use ($annee, $levelCodes, $classLabels) {
            $query->whereHas('inscriptions', function ($inscription) use ($annee, $levelCodes) {
                $inscription->where('annee_id', $annee->id)
                    ->whereHas('niveau', fn ($niveau) => $niveau->whereIn('code', $levelCodes));
            })->orWhereHas('apprenant_classe_annees.classe_annee', function ($classeAnnee) use ($annee, $classLabels) {
                $classeAnnee->where('annee_id', $annee->id)
                    ->whereHas('classe', function ($classe) use ($classLabels) {
                        $classe->where(function ($labels) use ($classLabels) {
                            foreach ($classLabels as $label) {
                                $labels->orWhere('libelle', 'like', $label);
                            }
                        });
                    });
            });
        })
            ->distinct('apprenants.id')
            ->count('apprenants.id');
    };

    $unpaidPayments = 0;
    if ($annee) {
        $inscriptions = Inscription::where('annee_id', $annee->id)->get(['id', 'niveau_id']);
        $feesByLevel = DB::table('frais')
            ->where('annee_id', $annee->id)
            ->whereNull('deleted_at')
            ->select('niveau_id', DB::raw('SUM(montant) as total_fees'))
            ->groupBy('niveau_id')
            ->pluck('total_fees', 'niveau_id');
        $paymentsByInscription = DB::table('versements')
            ->whereIn('inscription_id', $inscriptions->pluck('id'))
            ->whereNull('deleted_at')
            ->select('inscription_id', DB::raw('SUM(montant) as total_paid'))
            ->groupBy('inscription_id')
            ->pluck('total_paid', 'inscription_id');

        $unpaidPayments = $inscriptions->sum(static function ($inscription) use ($feesByLevel, $paymentsByInscription) {
            return max(
                0,
                ($feesByLevel[$inscription->niveau_id] ?? 0) - ($paymentsByInscription[$inscription->id] ?? 0)
            );
        });
    }

    $dashboardStats = [  
        'students' => $annee ? Apprenant::whereHas('apprenant_classe_annees.classe_annee', fn ($query) => $query->where('annee_id', $annee->id))->count() : 0,
        'classes' => $annee ? ClasseAnnee::where('annee_id', $annee->id)->count() : 0,
        'teachers' => $annee ? Enseignant::whereHas('enseignement_annees.classe_annee', fn ($query) => $query->where('annee_id', $annee->id))->distinct()->count('id') : 0,
        'payments' => $annee  ? Versement::whereHas('inscription', fn ($query) => $query->where('annee_id', $annee->id))->sum('montant') : 0,
        'terminal_a' => $studentCountForLevel(['TA'], ['Terminale A%', 'Terminal A%']),
        'terminal_d' => $studentCountForLevel(['TD'], ['Terminale D%', 'Terminal D%']),
        'troisieme' => $studentCountForLevel(['3e'], ['Troisième%', 'Troisieme%', '3ème%', '3eme%']),
        'unpaid_payments' => $unpaidPayments,
    ];

    return Inertia::render('Dashboard', [
        'dashboardStats' => $dashboardStats,
        'schoolYearLabel' => $annee?->libelle ?? 'Aucune année active',
        'isSelectedYearActive' => (bool) ($annee?->actif ?? false),
        'schoolYears' => $schoolYears,
        'selectedYearId' => $annee?->id,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::group(['middleware' => ['checkRoles:Super-administrateur,Administrateur']], function () {
        
    });
    Route::resource('users', UserController::class);
    // Début routes tuteurs
    Route::get('tuteurs/list-warnings', [TuteurController::class, 'listWarnings'])->name('tuteurs.listWarnings');
    Route::get('tuteurs/meetings', [TuteurController::class, 'listWarnings'])->name('tuteurs.meetings');
    Route::get('tuteurs/mail-box', [TuteurController::class, 'mailBox'])->name('tuteurs.mailBox');
    Route::get('tuteurs/dashboard', [TuteurController::class, 'dashboard'])->name('tuteurs.dashboard');
    Route::get('tuteurs/result', [TuteurController::class, 'result'])->name('tuteurs.result');
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
    Route::get('getbulletinbyapprenant/{section_id}/{classe}/{periode}/{tab}/{apprenant}', [RapportController::class, 'create'])->name('bulletinbyapprenant');
    Route::get('getdata/{section_id}/{classe}/{periode}/{type_evaluation}', [RapportController::class, 'index'])->name('rapportdata');
    Route::get('conduites', [ConduiteController::class, 'index'])->name('conduites.index');
    Route::post('conduites', [ConduiteController::class, 'store'])->name('conduites.store');
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
Route::delete('frais_sup/{type}', [FraisController::class, 'supprimer'])->name('frais.supprimer');
Route::resource('affectations', AffectationController::class)->only(['update', 'destroy']);
Route::delete('affectationivausup/{type}', [AffectationController::class, 'niveausupprime'])->name('affectations.niveausupprime');
Route::delete('affectationsup/{type}', [AffectationController::class, 'supprimerUE'])->name('affectationsup.supprimerUE');
Route::get('affectation/{type}', [AffectationController::class, 'create'])->name('affectations.create');
Route::get('affectations/{type}', [AffectationController::class, 'index'])->name('affectations.index');
Route::post('affectations/{type}', [AffectationController::class, 'store'])->name('affectations.store');
// Route::delete('frais/{type}', [FraisController::class, 'supprimer'])->name('frais.supprimer');
// Route::resource('calendrierscolaire/{parameter}', CalendrierscolaireController::class);
Route::prefix('calendrierscolaire')->group(function () {
    Route::resource('{type}', CalendrierscolaireController::class)->only(['create', 'store', 'index']);
});
// Route::resource('calendrierscolaire/{type}', CalendrierscolaireController::class)->parameters(['type' => 'type']);

Route::resource('salles', SalleController::class);
Route::resource('rapports', RapportController::class);
Route::get('generate_bulletin_apprenant', [RapportController::class, 'bulletin'])->name('bulletin');
Route::resource('enseignants', EnseignantController::class)->only([ 'update', 'destroy']);
Route::get('enseignantscreate/{type}', [EnseignantController::class, 'create'])->name('enseignants.create');
Route::get('enseignants/{type}', [EnseignantController::class, 'index'])->name('enseignants.index');
Route::post('enseignants/{type}', [EnseignantController::class, 'store'])->name('enseignants.store');
Route::resource('AffectationEnseignants', AffectationEnseignantController::class)->only(['update', 'destroy']);
Route::get('affectationEnseignants/{type}', [AffectationEnseignantController::class, 'create'])->name('affectationEnseignants.create');
Route::get('AffectationEnseignants/{type}', [AffectationEnseignantController::class, 'index'])->name('AffectationEnseignants.index');
Route::post('AffectationEnseignants/{type}', [AffectationEnseignantController::class, 'store'])->name('AffectationEnseignants.store');
Route::get('AffectationEnseignants', [AffectationEnseignantController::class, 'edit'])->name('AffectationEnseignants.edit');
Route::delete('AffectationEnseignantssup/{type}', [AffectationEnseignantController::class, 'supprimerE'])->name('AffectationEnseignants.supprimerE');
Route::resource('filieres', FilliereController::class)->only([ 'update', 'destroy']);
Route::get('filierescreate/{type}', [FilliereController::class, 'create'])->name('filieres.create');
Route::post('filieresstore/{type}', [FilliereController::class, 'store'])->name('filieres.store');
Route::post('filierescycle/{type}', [FilliereController::class, 'ajout'])->name('filieres.ajout');
Route::delete('filieressup/{type}', [FilliereController::class, 'supprimer'])->name('filieres.supprimer');
Route::get('filieres/{type}', [FilliereController::class, 'index'])->name('filieres.index');
Route::resource('UniteEnseignement', UEController::class)->only([ 'edit', 'update','destroy']);
Route::get('Unité d\'enseignement create/{type}', [UEController::class, 'create'])->name('ues.create');
Route::get('Unité d\'enseignement/{type}', [UEController::class, 'index'])->name('ues.index');
Route::post('Unité d\'enseignement/{type}', [UEController::class, 'store'])->name('ues.store');
Route::get('/systeme/lmd/{type}', [LmdController::class, 'index'])->name('lmd.index');
Route::post('/systeme/lmd/store', [LmdController::class, 'store'])->name('systemelmd.store');


require __DIR__ . '/auth.php';
