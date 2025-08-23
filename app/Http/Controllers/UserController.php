<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\User;
use App\Models\Apprenant;
use App\Models\ApprenantClasseAnnee;
use App\Models\ApprenantTuteur;
use App\Models\ClasseAnnee;
use App\Models\Role;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Section;
use App\Models\Permission;
use App\Models\SectionUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\PermissionRole;
use Illuminate\Support\Facades\DB;
use App\Models\EtablissementSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Modules\Enseignement\Entities\Enseignant;
use Modules\Enseignement\Entities\Niveau;
use Modules\Scolarite\Entities\Inscription;
use Modules\Scolarite\Entities\Tuteur;
use Modules\Scolarite\Entities\Versement;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getVersementsByClasseAnneeAndStudent($classeAnnee, $apprenant)
    {
        $authUser =  Auth::user();
        $data = null;
        $nameRole = $authUser->roles[0] ? $authUser->roles[0]->name : null;
        $getModelClasseAnnee = ClasseAnnee::find((int) $classeAnnee);
        if ($nameRole == 'Administrateur') {

            $data  = Versement::whereHas('apprenant', function ($query) use ($authUser) {
                $query->where('etablissement_id', (int)$authUser->etablissement_id);
            })->whereHas('frais', function ($query) use ($getModelClasseAnnee) {
                $query->where('annee_id', (int)$getModelClasseAnnee->annee_id);
            })->with('apprenant', 'frais', 'frais.type_frais')->where('apprenant_id', (int)$apprenant)
                ->get();
        }
        return $data  ?? [];
    }
    public function getInscriptionsByYearAndSection($year, $section, $niveau)
    {

        // dd($year);
        $list = [];
        $authUser =  Auth::user();
        $collection = collect();
        $nameRole = $authUser->roles[0] ? $authUser->roles[0]->name : null;
        $findNiveau = Niveau::where('section_id', (int)$section)->where('id', (int)$niveau)->get();
       
        if ($nameRole == 'Administrateur') {
            $list = Inscription::where(function ($query) use ($section) {
                if($section == '1' || $section == '2'){
                    // Si $p est nul, n'ajoutez aucune condition supplémentaire.
                    return $query->where('cycle_filiere_id',null);
                } elseif($section == '3' || $section == '4') {
                    // Si $p n'est pas nul, ajoutez vos conditions à la requête.
                    return $query->where('cycle_filiere_id','<>',null);
                }
            })->where('annee_id', $year)->whereHas('apprenant', function ($query) use ($authUser) {
                $query->where('etablissement_id', (int)$authUser->etablissement_id);
            })->with('apprenant', 'apprenant.etablissement', 'cycleFiliere.cycle', 'cycleFiliere.filiere', 'niveau', 'annee')->get();
            // dd($list);
            if($section == '1' || $section == '2'){
                $findEtabSection = DB::table('etablissement_section')->where('section_id', (int)$section)->first();

                $apprenantsCABySection = ApprenantClasseAnnee::with('apprenant', 'classe_annee.annee', 'classe_annee.classe', 'classe_annee.classe.niveau')
                    ->whereHas('classe_annee', function ($query) use ($year, $niveau, $findNiveau, $findEtabSection) {
                        $query->whereHas('annee', function ($query) use ($year) {
                            $query->where('id', $year);
                        })->whereHas('classe', function ($query) use ($niveau, $findNiveau, $findEtabSection) {
                            if ($findNiveau->count() != 0) {
                                return $query->where('niveau_id', $niveau)->where(
                                    'etablissement_section_id',
                                    $findEtabSection->id
                                );
                            }
                            return $query->where(
                                'etablissement_section_id',
                                $findEtabSection->id
                            );
                        });
                    })
                    ->get();
                    // dd($apprenantsCABySection,$list);
                $list->map(function ($element) use ($apprenantsCABySection, $collection) {
                    $vTerre = $apprenantsCABySection->filter(function ($el) use ($element) {
                        return $el['apprenant_id'] == $element['apprenant_id'];
                    });
                    return $collection->push($vTerre->filter()->all());
                });
            }
        }
        if($section == '1' || $section == '2'){
            $flattened = $collection->flatten()->unique()->filter();
            $flattened->all();
            // dd($flattened);
            return $flattened ?? [];
        }elseif($section == '3' || $section == '4'){
            return $list ?? []; 
        }
    }
    public function getUsersByCategory($params)
    {
        // dd('$params:', $params);
        $data = null;
        $list = [];
        $authUser =  Auth::user();
        $nameRole = $authUser->roles[0] ? $authUser->roles[0]->name : null;

        if ($nameRole == 'Administrateur') {
            if ($params == "allyears") {

                $list = Annee::all();
            }

            if ($params == "primaireClasses") {

                $list = Niveau::where('section_id', 1)->get();
            }
            if ($params == "secondaireClasses") {

                $list = Niveau::where('section_id', 2)->get();
            }
            if ($params == "superieurClasses") {

                $list = Niveau::where('section_id', 3)->get();
            }
            
            if ($params == "organizationStudents") {
                $list = Inscription::whereHas('apprenant', function ($query) use ($authUser) {
                    $query->where('etablissement_id', (int)$authUser->etablissement_id);
                })->with('apprenant', 'apprenant.etablissement', 'apprenant.etablissement.sections')->get();
            }
        }
        $terre = ClasseAnnee::with('annee', 'classe', 'classe.niveau')->get();

        return $list ?? [];
    }
    // public function index(Request $request)
    // {
    //     // dd($request->all());
    //     $authUser = Auth::user();
    //     if (Auth::user() == null) {
    //         return redirect('/login')->with('message', [
    //             'type' => 'error',
    //             'text' => 'Session expirée!',
    //         ]);
    //     }
    //     // dump('request:', $request->all(), $authUser);
    //     // die();
    //     $vUsers = null;
    //     // dump('T:', $request->section_id);
    //     if ($request->section_id != null) {
    //         $vUsers = User::where('users.etablissement_id', (int)$authUser->etablissement_id)
    //         ->where('users.user_id', (int)$authUser->id)->get();
    //     }
    //     if ($request->section_id == null) {
    //         $vUsers = User::whereNull('apprenant_id')->whereNull('tuteur_id')->whereNull('enseignant_id')
    //             ->where('users.user_id', (int)$authUser->id)
    //             ->with('etablissement')->get();
    //     }
    //     return Inertia::render('User/Index', [
    //         'users' => $vUsers ?? [],
    //         'sectionID' => $request->section_id ?? null,
    //         'timestamp' => now()->timestamp // ← NOUVEAU: ajoutez un timestamp
    //     ]);
    // }

public function index(Request $request)
{
    $authUser = Auth::user();
    if (Auth::user() == null) {
        return redirect('/login');
    }

    // REQUÊTE SIMPLE : tous les users de l'établissement
    $vUsers = User::where('etablissement_id', (int)$authUser->etablissement_id)
                ->with(['etablissement', 'roles'])
                ->get();

    return Inertia::render('User/Index', [
        'users' => $vUsers,
        'sectionID' => $request->section_id ?? null,
        'timestamp' => now()->timestamp
    ]);
}
    /**
     * Show the form for creating a new resource.
     */
    // private function getEnseignants($type)
    // {
    //     if($type == 1){
    //         $enseignants = Enseignant::where('etablissement_id', Auth::user()->etablissement_id)->get();

    //         // Appliquer la transformation avec la méthode map
    //         $enseignantsTransformed = $enseignants->map(function ($enseignant) {
    //             return [
    //                 'id' => $enseignant->id,
    //                 'matricule' => $enseignant->matricule,
    //                 'nom' => $enseignant->nom,
    //                 'prenom' => $enseignant->prenom,
    //                 'nomcomplet' => $enseignant->matricule . ' - ' . $enseignant->nom . ' ' . $enseignant->prenom
    //                 // Ajoutez d'autres propriétés au besoin
    //             ];
    //         });
    //     }else{
    //         $tuteurs = ApprenantTuteur::whereHas('apprenant', function ($query) {
    //             $query->where('etablissement_id', Auth::user()->etablissement_id);
    //         })->with('tuteur')->get();

    //         // Appliquer la transformation avec la méthode map
    //         $enseignantsTransformed = $tuteurs->pluck('tuteur')->unique()->map(function ($tuteur) {
    //             return [
    //                 'id' => $tuteur->id,
    //                 'nom' => $tuteur->nom,
    //                 'prenom' => $tuteur->prenom,
    //                 'nomcomplet' => $tuteur->nom . ' ' . $tuteur->prenom
    //                 // Ajoutez d'autres propriétés au besoin
    //             ];
    //         });
    //     }
        

    //     return $enseignantsTransformed;
    // }
    

    // private function getEnseignants($type)
    // {
    //     $authUser = Auth::user();
        
    //     if($type == 1){
    //         // FILTREZ LES ENSEIGNANTS PAR ÉTABLISSEMENT
    //         $enseignants = Enseignant::where('etablissement_id', $authUser->etablissement_id)->get();

    //         $enseignantsTransformed = $enseignants->map(function ($enseignant) {
    //             return [
    //                 'id' => $enseignant->id,
    //                 'matricule' => $enseignant->matricule,
    //                 'nom' => $enseignant->nom,
    //                 'prenom' => $enseignant->prenom,
    //                 'nomcomplet' => $enseignant->matricule . ' - ' . $enseignant->nom . ' ' . $enseignant->prenom
    //             ];
    //         });
    //     } else {
    //         // FILTREZ LES TUTEURS PAR ÉTABLISSEMENT
    //         $tuteurs = ApprenantTuteur::whereHas('apprenant', function ($query) use ($authUser) {
    //             $query->where('etablissement_id', $authUser->etablissement_id);
    //         })->with('tuteur')->get();

    //         $enseignantsTransformed = $tuteurs->pluck('tuteur')->unique()->map(function ($tuteur) {
    //             return [
    //                 'id' => $tuteur->id,
    //                 'nom' => $tuteur->nom,
    //                 'prenom' => $tuteur->prenom,
    //                 'nomcomplet' => $tuteur->nom . ' ' . $tuteur->prenom
    //             ];
    //         });
    //     }

    //     return $enseignantsTransformed;
    // }


    private function getEnseignants($type)
    {
        $authUser = Auth::user();
        
        if($type == 1){
            // Filtrer les enseignants par établissement
            $enseignants = Enseignant::where('etablissement_id', $authUser->etablissement_id)->get();

            $enseignantsTransformed = $enseignants->map(function ($enseignant) {
                return [
                    'id' => $enseignant->id,
                    'matricule' => $enseignant->matricule,
                    'nom' => $enseignant->nom,
                    'prenom' => $enseignant->prenom,
                    'nomcomplet' => $enseignant->matricule . ' - ' . $enseignant->nom . ' ' . $enseignant->prenom
                ];
            });
        } else {
            // Filtrer les tuteurs par établissement
            $tuteurs = ApprenantTuteur::whereHas('apprenant', function ($query) use ($authUser) {
                $query->where('etablissement_id', $authUser->etablissement_id);
            })->with('tuteur')->get();

            $enseignantsTransformed = $tuteurs->pluck('tuteur')->unique()->map(function ($tuteur) {
                return [
                    'id' => $tuteur->id,
                    'nom' => $tuteur->nom,
                    'prenom' => $tuteur->prenom,
                    'nomcomplet' => $tuteur->nom . ' ' . $tuteur->prenom
                ];
            });
        }

        return $enseignantsTransformed;
    }


    // public function create(Request $request)
    // {
    //     $user = Auth::user();
    //     $sections = DB::select("
    //         SELECT s.id,s.libelle FROM sections s
    //         JOIN etablissement_section es ON s.id = es.section_id
    //         JOIN etablissements e ON e.id = es.etablissement_id
    //         JOIN users u ON e.id = u.etablissement_id
    //         WHERE e.id = :etablissement_id 
    //     ",
    //     [
    //         'etablissement_id' => $user->etablissement_id,
    //     ]);
    //     return Inertia::render('User/Create', [
    //         'section_id' => $request->section_id,
    //         'etablissements' => Etablissement::all(),
    //         'role' => Role::all(),
    //         'AllSections' => $sections,
    //         'permissions' => Permission::all(),
    //         'enseignants' => $this->getEnseignants(1),
    //         'tuteurs' => $this->getEnseignants(2),
    //         'etablissement_sections' => Section::whereHas('etablissements.users', function ($q) use ($user) {
    //             $q->where('id', $user->id);
    //         })->get()
    //     ]);
    // }

  public function create(Request $request)
{
    $user = Auth::user();
    
    $sections = DB::select("
        SELECT s.id, s.libelle FROM sections s
        JOIN etablissement_section es ON s.id = es.section_id
        WHERE es.etablissement_id = :etablissement_id 
    ", ['etablissement_id' => $user->etablissement_id]);

    // SOUS-REQUÊTE POUR FILTRER LES RÔLES
    $roles = Role::whereNull('etablissement_section_id')
            ->orWhereIn('etablissement_section_id', function($query) use ($user) {
                $query->select('id')
                      ->from('etablissement_section')
                      ->where('etablissement_id', $user->etablissement_id);
            })
            ->get();

    return Inertia::render('User/Create', [
        'section_id' => $request->section_id,
        'etablissements' => Etablissement::all(),
        'role' => $roles, // RÔLES FILTRÉS
        'AllSections' => $sections,
        'permissions' => Permission::all(),
        'enseignants' => $this->getEnseignants(1),
        'tuteurs' => $this->getEnseignants(2),
        'etablissement_sections' => Section::whereHas('etablissements', function($q) use ($user) {
            $q->where('etablissements.id', $user->etablissement_id);
        })->get()
    ]);
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        CreationCompte(null,null,$request->type_user,$request->roles,$request);

        // return redirect()->route('users.index')->with('message', 'Utilisateur a été créé avec succès !');
        // REDIRIGEZ AVEC LE SECTION_ID POUR GARDER LE CONTEXTE
        return redirect()->route('users.index', [
            'section_id' => $request->section_id
        ])->with('message', 'Utilisateur créé avec succès !');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function NotFoud(Request $request)
    {
        //return Inertia::render('Page');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
