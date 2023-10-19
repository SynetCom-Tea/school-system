<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\User;
use App\Models\Apprenant;
use App\Models\ApprenantClasseAnnee;
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


        $list = [];
        $authUser =  Auth::user();
        $collection = collect();
        $nameRole = $authUser->roles[0] ? $authUser->roles[0]->name : null;
        $findNiveau = Niveau::where('section_id', (int)$section)->where('id', (int)$niveau)->get();

        if ($nameRole == 'Administrateur') {

            $list = Inscription::whereHas('apprenant', function ($query) use ($authUser) {
                $query->where('etablissement_id', (int)$authUser->etablissement_id);
            })->with('apprenant', 'apprenant.etablissement', 'apprenant.etablissement')->get();

            $findEtabSection = DB::table('etablissement_section')->where('section_id', (int)$section)->first();

            $apprenantsCABySection = ApprenantClasseAnnee::with('apprenant', 'classe_annee.annee', 'classe_annee.classe', 'classe_annee.classe.niveau')
                ->whereHas('classe_annee', function ($query) use ($year, $niveau, $findNiveau, $findEtabSection) {
                    $query->whereHas('annee', function ($query) use ($year) {
                        $query->where('libelle', $year);
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


            $list->map(function ($element) use ($apprenantsCABySection, $collection) {
                $vTerre = $apprenantsCABySection->filter(function ($el) use ($element) {
                    return $el['apprenant_id'] == $element['apprenant_id'];
                });
                return $collection->push($vTerre->filter()->all());
            });
        }

        $flattened = $collection->flatten()->unique()->filter();
        $flattened->all();
        return $flattened ?? [];
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
            if ($params == "organizationStudents") {
                $list = Inscription::whereHas('apprenant', function ($query) use ($authUser) {
                    $query->where('etablissement_id', (int)$authUser->etablissement_id);
                })->with('apprenant', 'apprenant.etablissement', 'apprenant.etablissement.sections')->get();
            }
        }
        $terre = ClasseAnnee::with('annee', 'classe', 'classe.niveau')->get();

        return $list ?? [];
    }
    public function index(Request $request)
    {
        // dump('request:', $request->all());
        $authUser = Auth::user();
        if (Auth::user() == null) {
            return redirect('/login')->with('message', [
                'type' => 'error',
                'text' => 'Session expirée!',
            ]);
        }
        $vUsers = null;
        // dump('T:', $request->section_id);
        if ($request->section_id != null) {
            $vUsers = User::where('users.etablissement_id', (int)$authUser->etablissement_id)
                ->where('users.user_id', (int)$authUser->id)
                // ->where('users.id', '<>', (int)$authUser->id)
                ->join(
                    'section_users',
                    'users.id',
                    '=',
                    'section_users.user_id',
                )
                ->join(
                    'etablissement_section',
                    'section_users.etablissement_section_id',
                    '=',
                    'etablissement_section.id',
                )
                ->where('etablissement_section.section_id', (int)$request->section_id)
                ->selectRaw('users.*')
                ->with('apprenant', 'tuteur', 'enseignant')
                ->get();
        }
        if ($request->section_id == null) {
            $vUsers = User::whereNull('apprenant_id')->whereNull('tuteur_id')->whereNull('enseignant_id')
                ->where('users.user_id', (int)$authUser->id)
                ->with('etablissement')->get();
        }

        return Inertia::render('user/Index', [
            'users' => $vUsers ?? [],
            'sectionID' => $request->section_id ?? null
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $sections = DB::select("
            SELECT s.id,s.libelle FROM sections s
            JOIN etablissement_section es ON s.id = es.section_id
            JOIN etablissements e ON e.id = es.etablissement_id
            JOIN users u ON e.id = u.etablissement_id
            WHERE e.id = :etablissement_id 
        ",
        [
            'etablissement_id' => $user->etablissement_id,
            
        ]); 
        return Inertia::render('User/Create', [
            'etablissements' => Etablissement::all(),
            'roles' => Role::all(),
            'sections' => $sections,
            'permissions' => Permission::all(),
            'enseignants' => Enseignant::where('etablissement_id', Auth::user()->etablissement_id)->get(),
            'apprenants' => Apprenant::where('etablissement_id', Auth::user()->etablissement_id)->get(),
            'etablissement_sections' => Section::whereHas('etablissements.users', function ($q) use ($user) {
                $q->where('id', $user->id);
            })->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $user = Auth::user();
        $permis = [];
        $etat = null;
        $nom = str_replace(' ', '', $request->nom);
        $prenom = str_replace(' ', '', $request->prenom);
        $login  = strtolower($nom) . '-' . strtolower($prenom) . '@gmail.com';
        if ($request->etablissement_id) {
            $etat = $request->etablissement_id;
        } else {
            $etat = Auth::user()->etablissement_id;
        }
        if ($request->nom and $request->prenom) {
            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $login,
                'user_id' => Auth::user()->id,
                'password' => Hash::make($login),
                'etablissement_id' => $etat,
                'enseignant_id' => $request->enseignant_id,
                'apprenant_id' => $request->apprenant_id
            ]);
            $permissions = PermissionRole::where('role_id', $request->roles)->where('user_id', Auth::user()->id)->get();
            foreach ($permissions as $permission) {
                $permis[] = $permission->permission_id;
            }
            $user->syncRoles($request->roles);
            $user->syncPermissions($permis);

            foreach ($request->section as $sec) {
                $etablissement_sections  = DB::table('etablissement_section')->where('section_id', $sec)->where('etablissement_id', Auth::user()->etablissement_id)->get()[0];

                SectionUser::create([
                    'user_id' => $user->id,
                    'etablissement_section_id' => $etablissement_sections->id
                ]);
            }
            if ($request->etablissement_id) {
                $etablissement = Etablissement::find($request->etablissement_id);
                $etablissement->sections()->attach($request->sections);
            }

            return redirect()->route('users.index')->with('message', 'Utilisateur a été crée avec succès !');
        } else {
            return redirect()->back()->with('messages', 'Veuillez réenseigner tous les champs ayant étoille rouge!');

            return redirect()->route('users.index')->with('message', 'Utilisateur a été crée avec succès !');
        }
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
        return Inertia::render('Page');
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
