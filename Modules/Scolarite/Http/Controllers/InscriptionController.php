<?php

namespace Modules\Scolarite\Http\Controllers;

use PDF;
use App\Models\Role;
use Inertia\Inertia;
use App\Models\Annee;
use App\Models\Cycle;
use App\Models\Classe;
use App\Models\Document;
use App\Models\Apprenant;
use App\Models\Parametre;
use App\Models\ClasseAnnee;
use App\Models\TypeDocument;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use Illuminate\Http\Response;
use App\Models\ApprenantTuteur;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ApprenantClasseAnnee;
use Illuminate\Support\Facades\Auth;
use Modules\Scolarite\Entities\Frais;
use Modules\Scolarite\Entities\Tuteur;
use Illuminate\Support\Facades\Redirect;
use Modules\Enseignement\Entities\Niveau;
use Modules\Scolarite\Entities\TypeFrais;
use Modules\Scolarite\Entities\Versement;
use Modules\Scolarite\Entities\Inscription;
use Modules\Enseignement\Entities\CycleFiliere;
use Modules\Scolarite\Entities\EtablissementTypeDocument;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Scolarite\Exports\InscriptionsExport;
use Modules\Scolarite\Exports\InscriptionsPayeesExport;
use Modules\Scolarite\Exports\InscriptionsNonPayeesExport;
use Modules\Scolarite\Exports\FichePresenceExport;
use Modules\Scolarite\Exports\ListeClasseAffichageExport;
use Illuminate\Contracts\Support\Renderable;



class InscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        // dd('r:', $request->all());
        try {
            //code...

            if (Auth::user() == null) {

                return redirect('/login')->with('message', [
                    'type' => 'error',
                    'text' => 'Session ou Token expiré!',
                ]);
            }

            return Inertia::render('Inscription/Index', [
                'vSectionID' => (int)$request->section_id,
                'inscriptions' => $this->ajaxInscriptionListe($request, null, $request->section_id)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => $th,
            ]);
        }
    }

    public function addPage(Request $request)
    {
        // dd($request);
        $apprenant = json_decode($request->query('apprenant'));
        // dd($apprenant);
        $section = json_decode($request->query('section'));
        $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $section);
        // $p = Parametre::where('etablissement_section_id', $etablissement_section)->first();
        // if (!is_null($p)) {
        $p = Parametre::where('etablissement_section_id',$etablissement_section[0])->first(); //modifier par Sam avec ajout [0] car la fonction getSectionEtablissement() retourne un tableau mais vous essayez de l'utiliser comme une valeur simple dans la requête
        if(!is_null($p)){
            $nbre_limite_eleve_classe_par_etab_section = $p->nbre_limite_eleve_par_classe;
        } else {
            $nbre_limite_eleve_classe_par_etab_section = null;
        }
        // dd($section,$p,$etablissement_section[0]);
        if ($section == '3' || $section == '4') {
            // dd('3 ou 4');
            // $cf = CycleFiliere::where('cycle_id', $request->cycle_id ? $request->cycle_id : 1)->whereHas('filiere', function ($query) use ($section, $etablissement_section) {
            //     $query->where('etablissement_section_id', $etablissement_section)->where(function ($query) use ($section) {
            //         if ($section == '3') {
            $cf = CycleFiliere::where('cycle_id',$request->cycle_id ? $request->cycle_id : 1)->whereHas('filiere', function($query) use ($section, $etablissement_section){
                $query->where('etablissement_section_id',$etablissement_section[0])->where(function ($query) use ($section) { //modifier par Sam avec ajout [0] car la fonction getSectionEtablissement() retourne un tableau mais vous essayez de l'utiliser comme une valeur simple dans la requête
                    if($section == '3'){
                        return $query->whereNull('departement_id');
                    } elseif ($section == '4') {
                        return $query->whereNotNull('departement_id');
                    }
                });
            })->with('filiere', 'cycle')->get();
        } else {

            $cf = [];
            // dd('aucun');
        }
        // dd($cf,$section);
        // dd($request->apprenant);
        return Inertia::render('Inscription/Create', [
            'type' => $section,
            'nbre_limite_eleve' => $nbre_limite_eleve_classe_par_etab_section,
            'niveaux' => Niveau::where('section_id', $section)->get(),
            'cycles' => Cycle::all(),
            'cycleFilieres' => $cf,
            'typeFrais' => TypeFrais::all(),
            'apprenant' => $apprenant,
            'annees' => Annee::all(),
            // 'typeDocuments' => EtablissementTypeDocument::where('etablissement_section_id', $etablissement_section)->where('statut', '1')->with('type_document')->get(),
            // 'tuteurs' => ApprenantTuteur::whereHas('apprenant', function ($query) {
            //     $query->where('etablissement_id', Auth::user()->etablissement_id);
            // })->with('tuteur')->get()
             'typeDocuments' => EtablissementTypeDocument::where('etablissement_section_id',$etablissement_section[0])->where('statut','1')->with('type_document')->get(), // Récupération des types de documents modifier par Sam avec ajout [0] car la fonction getSectionEtablissement() retourne un tableau mais vous essayez de l'utiliser comme une valeur simple dans la requête
            'tuteurs' => ApprenantTuteur::whereHas('apprenant', function($query){$query->where('etablissement_id',Auth::user()->etablissement_id);})->with('tuteur')->get()
        ]);
    }

    // Debut requete AXIOS
  public function ajaxInscriptionListe(Request $request, $mat = null, $sec = null)
{
    $nom = null;
    $prenom = null;
    $section = $sec ? $sec : $request->section;
    $matricule = null;
    
    if ($request->matricule == null && $mat == null) {
        $nom = $request->nom;
        $prenom = $request->prenom;
    } elseif ($request->matricule != null && $mat == null) {
        $matricule = $request->matricule;
    }
    
    $authUser = Auth::user();
    $etablissement_id = $authUser->etablissement_id;
    
    // Récupération de l'ID de la section d'établissement
    $et_sec_id = getSectionEtablissement($etablissement_id, $section)->first();
    
    $year = getAnneeEncours()->id;
    
    // Construction de la requête pour les inscriptions
    $query = Inscription::with([
            'apprenant', 
            'apprenant.etablissement', 
            'cycleFiliere.cycle', 
            'cycleFiliere.filiere', 
            'niveau', 
            'annee', 
            'versements',
            'classeAnnee.classe.niveau', // Ajout important
            'classeAnnee.annee' // Ajout important
        ])
        ->whereHas('apprenant', function($query) use ($etablissement_id) {
            $query->where('etablissement_id', $etablissement_id);
        });
    
    // Filtrage par section
    if ($section == '1' || $section == '2') {
        $query->whereNull('cycle_filiere_id');
    } elseif ($section == '3') {
        $query->whereNotNull('cycle_filiere_id')
            ->whereHas('cycleFiliere.filiere', function($query) use ($et_sec_id) {
                $query->where('etablissement_section_id', $et_sec_id)
                    ->whereNull('departement_id');
            });
    } elseif ($section == '4') {
        $query->whereNotNull('cycle_filiere_id')
            ->whereHas('cycleFiliere.filiere', function($query) use ($etablissement_id) {
                $query->where('etablissement_id', $etablissement_id)
                    ->whereNotNull('departement_id');
            });
    }
    
    // Filtrage par année (sauf si recherche spécifique)
    if ($matricule === null && $nom === null && $prenom === null) {
        $query->where('annee_id', $year);
    }
    
    // Filtrage par matricule, nom ou prénom
    if ($matricule !== null) {
        $query->whereHas('apprenant', function($query) use ($matricule) {
            $query->where('matricule', 'like', '%' . $matricule . '%');
        });
    } else {
        if ($nom !== null) {
            $query->whereHas('apprenant', function($query) use ($nom) {
                $query->where('nom', 'like', '%' . $nom . '%');
            });
        }
        if ($prenom !== null) {
            $query->whereHas('apprenant', function($query) use ($prenom) {
                $query->where('prenom', 'like', '%' . $prenom . '%');
            });
        }
    }
    
    $list = $query->get();
    
    // Pour les sections 1 et 2, récupérer également les apprenants par classe
    if ($section == '1' || $section == '2') {
        $apprenantsCABySection = ApprenantClasseAnnee::with([
                'apprenant', 
                'classe_annee.annee', 
                'classe_annee.classe', 
                'classe_annee.classe.niveau'
            ])
            ->whereHas('classe_annee.classe', function($query) use ($et_sec_id) {
                $query->where('etablissement_section_id', $et_sec_id);
            })
            ->whereHas('apprenant', function($query) use ($etablissement_id) {
                $query->where('etablissement_id', $etablissement_id);
            })
            ->whereHas('classe_annee.annee', function($query) use ($year, $matricule, $nom, $prenom) {
                if ($matricule === null && $nom === null && $prenom === null) {
                    $query->where('id', $year);
                }
            });
        
        // Filtrage supplémentaire par matricule, nom ou prénom
        if ($matricule !== null) {
            $apprenantsCABySection->whereHas('apprenant', function($query) use ($matricule) {
                $query->where('matricule', 'like', '%' . $matricule . '%');
            });
        } else {
            if ($nom !== null) {
                $apprenantsCABySection->whereHas('apprenant', function($query) use ($nom) {
                    $query->where('nom', 'like', '%' . $nom . '%');
                });
            }
            if ($prenom !== null) {
                $apprenantsCABySection->whereHas('apprenant', function($query) use ($prenom) {
                    $query->where('prenom', 'like', '%' . $prenom . '%');
                });
            }
        }
        
        $apprenantsCABySection = $apprenantsCABySection->get();
        
        // Fusionner les résultats en structurant correctement les données
        $mergedCollection = collect();
        
        foreach ($list as $inscription) {
            $correspondingCA = $apprenantsCABySection->firstWhere('apprenant_id', $inscription->apprenant_id);
            
            if ($correspondingCA) {
                // Créer un objet fusionné avec les données de l'inscription et de la classe
                $mergedData = (object) [
                    'id' => $inscription->id,
                    'apprenant' => $inscription->apprenant,
                    'annee' => $correspondingCA->classe_annee->annee ?? $inscription->annee,
                    'classe_annee' => $correspondingCA->classe_annee,
                    'niveau' => $correspondingCA->classe_annee->classe->niveau ?? $inscription->niveau,
                    'cycle_filiere_id' => $inscription->cycle_filiere_id,
                    'cycleFiliere' => $inscription->cycleFiliere,
                    'versements' => $inscription->versements,
                ];
                $mergedCollection->push($mergedData);
            } else {
                $mergedCollection->push($inscription);
            }
        }
        
        return $mergedCollection->values()->all() ?? [];
    }
    
    return $list ?? [];
}
    public function getFrais($niveau, $annee)
    {
        // dd($niveau);
        $frais_scolarite = 0;
        $frais = Frais::where('type_frais_id', 2)->where('annee_id', $annee)->where('etablissement_id', Auth::user()->etablissement_id)->where('niveau_id', $niveau)->first();
        if ($frais) {
            $frais_scolarite = $frais->montant;
        }
        // dd($frais_scolarite);
        return $frais_scolarite;
    }

  public function checkClasse($niveau, $etabSection)
{
    try {
        $etablissement_id = Auth::user()->etablissement_id;
        
        // Obtenez l'ID de section d'établissement (suppose que getSectionEtablissement retourne un ID integer)
        $etablisement_section_id = getSectionEtablissement($etablissement_id, $etabSection);
        
        // Si ce n'est pas un integer, essayez de trouver l'ID autrement
        if (!is_int($etablisement_section_id)) {
            // Essayez de trouver l'ID via la table etablissement_section
            $etablissement_section = DB::table('etablissement_section')
                ->where('etablissement_id', $etablissement_id)
                ->where('section_id', $etabSection)
                ->first();
                
            if ($etablissement_section) {
                $etablisement_section_id = $etablissement_section->id;
            } else {
                return ['code' => 0, 'message' => 'Section d\'établissement non trouvée'];
            }
        }
        
        // Vérifiez les classes pour ce niveau et section
        $classes = Classe::where('niveau_id', $niveau)
            ->where('etablissement_section_id', $etablisement_section_id)
            ->get();
        
        if ($classes->isEmpty()) {
            return ['code' => 0, 'message' => 'Aucune classe trouvée pour ce niveau et section'];
        }
        
        // Vérifiez les classes-années pour l'année en cours
        $annee_encours = getAnneeEncours()->id;
        $result = ClasseAnnee::whereIn('classe_id', $classes->pluck('id'))
            ->where('annee_id', $annee_encours)
            ->with('classe.niveau')
            ->get();
        
        if ($result->count() > 0) {
            $donnees = [];
            foreach ($result as $item) {
                $nbre = ApprenantClasseAnnee::where('classe_annee_id', $item->id)->wherehas('apprenant', function ($query) use ($etablissement_id) {
                    $query->where('etablissement_id', $etablissement_id);
                })->count();
                $donnees[] = [
                    'classe' => $item,
                    'nbre' => $nbre
                ];
            }

            return ['code' => 1, 'result' => $donnees];
        } else {
            return ['code' => 0, 'message' => 'Aucune classe-année trouvée pour l\'année en cours'];
        }
    } catch (\Exception $e) {
        return ['code' => -1, 'message' => 'Erreur: ' . $e->getMessage()];
    }
}
    // Fin requete AXIOS

    // DEBUT FUNCTION HELPERS
    public function generateMatricule($donnees)
    {

        $mat = "";
        $words = preg_split(
            "/(\s|\-|\.)/",
            Etablissement::find($donnees['annees']['etablissement_section_id']['pivot']['etablissement_id'])->name
        );
        $n = "";
        $o = 0;
        $f = "";
        foreach ($words as $w) {
            $n .= substr($w, 0, 1);
        }
        $o = Apprenant::where('etablissement_id', $donnees['annees']['etablissement_section_id']['pivot']['etablissement_id'])->count() + 1;
        $mat = 'US-' . $n . '-0' . $o;
        return $mat ?? "";
    }

    public function generateCodeInscription($donnees)
    {
        // dd($donnees);
        $mat = "";
        $s = substr($this->getNameSection($donnees['section']), 0, 1);
        $words = preg_split(
            "/(\s|\-|\.)/",
            Niveau::find($donnees['annees']['niveau'])->libelle
        );
        $n = "";
        $o = 1;
        $f = "";
        foreach ($words as $w) {
            $n .= substr($w, 0, 1);
        }
        $a = Annee::find($donnees['annees']['annee'])->libelle;
        if ($donnees['section'] == '1' || $donnees['section'] == '2') {
            //$o = Inscription::where('annee_id', $donnees['annees']['annee'])->where('niveau_id', $donnees['annees']['niveau'])->count() + 1;
            $os = Inscription::where('annee_id', $donnees['annees']['annee'])
                ->where('niveau_id', $donnees['annees']['niveau'])
                ->latest('id') // Trie par la colonne 'id'
                ->first();
                 if ($os) {
                    // Si un enregistrement existe, incrémenter le dernier code
                    $chaine = $os->code;
                    $dernierChiffre = substr($chaine, strrpos($chaine, '-') + 1);
                    $o = (int)$dernierChiffre + 1;
                }
                
        } elseif ($donnees['section'] == '3' || $donnees['section'] == '4') {
            //$o = Inscription::where('annee_id', $donnees['annees']['annee'])->where('niveau_id', $donnees['annees']['niveau'])->where('cycle_filiere_id', $donnees['annees']['cycle_filiere'])->count() + 1;
            $os = Inscription::where('annee_id', $donnees['annees']['annee'])
                ->where('niveau_id', $donnees['annees']['niveau'])
                ->where('cycle_filiere_id', $donnees['annees']['cycle_filiere'])
                ->latest('id') // Trie par la colonne 'id'
                ->first();
               if ($os) {
                    // Si un enregistrement existe, incrémenter le dernier code
                    $chaine = $os->code;
                    $dernierChiffre = substr($chaine, strrpos($chaine, '-') + 1);
                    $o = (int)$dernierChiffre + 1;
                }
        }
        if ($donnees['section'] == '1' || $donnees['section'] == '2') {
            $mat = 'US-' . $s . '-' . $a . '-' . $n . '-' . $o;
        } elseif ($donnees['section'] == '3' || $donnees['section'] == '4') {
            $f = substr(CycleFiliere::find($donnees['annees']['cycle_filiere'])->with('filiere')->first()->filiere->name, 0, 1);
            $mat = 'US-' . '-' . $s . '-' . $a . '-' . $n . '-' . $f . '-' . $o;
        }
        return $mat ?? "";
    }

    public function getNameSection($section)
    {
        $name = '';
        if ($section == '1') {
            $name = 'Primaire';
        }
        if ($section == '2') {
            $name = 'Secondaire';
        }
        if ($section == '3') {
            $name = 'Supérieure';
        }
        if ($section == '4') {
            $name = 'Universitaire';
        }
        return $name;
    }
    // FIN FUNCTION HELPER

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd($request->all());
        /////////////////////////////  matricule  ///////////////////////
        $et_sec_id = getSectionEtablissement(Auth::user()->etablissement_id, $request->section)->first();
        $matricule = $this->generateMatricule($request->all());
        $code_inscription = $this->generateCodeInscription($request->all());
        $id_apprenant = null;
        $section = $request->section;
        $tabs = EtablissementTypeDocument::where('etablissement_section_id', $et_sec_id)->where('obligatoire', '1')->where('statut', '1')->with('type_document')->get()->pluck('type_document_id')->unique()->values()->all();
        $type_user = 'Etudiant';
        $role = Role::where('name', 'Etudiant')->exists() ? Role::where('name', 'Etudiant')->get()[0]->id : null;
        if ($request->apprenants) {
            if (isset($request->documents['documents'])) {
                $p = collect($request->documents['documents'])->map(function ($e) {
                    return (int)$e['type'];
                })->toArray();
            } else {
                $p = [];
            }
            $i = array_intersect($p, $tabs);
            // dd($tabs,$p,$i);
            if (count($i) != count($tabs)) {
                return redirect()->back()->with('message', [
                    'type' => 'error',
                    'text' => 'Merci de renseigner tous les documents obligatoires',
                ]);
            }
        }

        // dd('ca a passé');
        try {
            // Démarrez la transaction
            // DB::beginTransaction();

            if ($request->apprenants) {
                // dd($request->apprenants,$request->section);
                $find = Apprenant::where('nom', $request->apprenants['nom'])->where('prenom', $request->apprenants['prenom'])->where('sexe', $request->apprenants['sexe'])
                    ->where('date_naissance', $request->apprenants['date_naissance'])->where('lieu_naissance', $request->apprenants['lieu_naissance'])->where('telephone', $request->apprenants['telephone'])
                    ->where('etablissement_id', Auth::user()->etablissement_id)->first();
                if ($find == null) {
                    $item_apprenant = Apprenant::create([
                        'matricule' => $matricule,
                        'nom' => $request->apprenants['nom'],
                        'prenom' => $request->apprenants['prenom'],
                        'sexe' => $request->apprenants['sexe'],
                        'date_naissance' => $request->apprenants['date_naissance'],
                        'lieu_naissance' => $request->apprenants['lieu_naissance'],
                        'telephone' => $request->apprenants['telephone'],
                        'etablissement_id' => Auth::user()->etablissement_id
                    ]);
                    $id_apprenant = $item_apprenant->id;
                    // CreationCompte($item_apprenant,$section);
                    $apprenant = Apprenant::where('id',$id_apprenant)->get()[0];
                    if ($section == '3'){
                    // CreationCompte($apprenant,$section,$type_user,$role);
                    }
                } else {
                    $id_apprenant = $find->id;
                    $apprenant = Apprenant::where('id',$id_apprenant)->get()[0];
                    // CreationCompte($apprenant,$section,$type_user,$role);
                }
            } else {
                $id_apprenant = $request->annees['apprenant']['more']['apprenant']['id'];
            }
            $check = Inscription::where('annee_id', $request->annees['annee'])->where('apprenant_id', $id_apprenant)->get();

            if ($check->count() == 0) {
                if ($request->section == '1' || $request->section == '2') {
                    $inscription = Inscription::create([
                        'code' => $code_inscription,
                        'date_inscription' => date('Y-m-d'),
                        'annee_id' => $request->annees['annee'],
                        'niveau_id' => $request->annees['niveau'],
                        'apprenant_id' => $id_apprenant,
                        'statut' => 0
                    ]);
                } elseif ($request->section == '3' || $request->section == '4') {
                    $inscription = Inscription::create([
                        'code' => $code_inscription,
                        'date_inscription' => date('Y-m-d'),
                        'annee_id' => $request->annees['annee'],
                        'niveau_id' => $request->annees['niveau'],
                        'cycle_filiere_id' => $request->annees['cycle_filiere'],
                        'apprenant_id' => $id_apprenant,
                        'statut' => 0
                    ]);
                }
            } else {
                return redirect()->back()->with('message', [
                    'type' => 'error',
                    'text' => 'Cette inscription existe déjà',
                ]);
            }
            $classe = null;
            $niv = Niveau::find($request->annees['niveau']);
            if ($request->section == '1' || $request->section == '2') {

                if ($request->annees['classe'] == null) {

                    if ($niv->code != '6e' && $niv->code != '5e' && $niv->code != '4e' && $niv->code != '3e') {
                        $cod = '1';
                    } else {
                        $cod = 'A';
                    }
                    $cl = Classe::create([
                        'code' => $niv->code . $cod,
                        'libelle' => $niv->libelle . $cod,
                        'niveau_id' => $request->annees['niveau'],
                        'etablissement_section_id' => $request->annees['etablissement_section_id']['id']
                    ]);
                    $classe = $cl->id;
                } else {
                    $classe = $request->annees['classe'];
                }
            } elseif ($request->section == '3' || $request->section == '4') {

                $classe = Classe::where('niveau_id', $request->annees['niveau'])->where('etablissement_section_id', $et_sec_id)->where('cycle_filiere_id', $request->annees['cycle_filiere'])->first();
                if (is_null($classe)) {
                    $cycleFiliere = CycleFiliere::find($request->annees['cycle_filiere']);
                    $cl = Classe::create([
                        'code' => $cycleFiliere->code . '/ ' . $niv->code,
                        'libelle' => $cycleFiliere->code . '/ ' . $niv->libelle,
                        'niveau_id' => $request->annees['niveau'],
                        'cycle_filiere_id' => $request->annees['cycle_filiere'],
                        'etablissement_section_id' => $request->annees['etablissement_section_id']['id']
                    ]);
                    $classe = $cl->id;
                } else {
                    $classe = $classe->id;
                }
            }



            $checkAnneeClasse = ClasseAnnee::where('annee_id', $request->annees['annee'])->where('classe_id', $classe)->first();

            $classe_annee = null;
            if ($checkAnneeClasse == null) {
                $classe_annee = ClasseAnnee::create([
                    'annee_id' => $request->annees['annee'],
                    'classe_id' => $classe
                ]);
            } else {
                $classe_annee = $checkAnneeClasse;
            }


            ApprenantClasseAnnee::create([
                'classe_annee_id' => $classe_annee->id,
                'apprenant_id' => $id_apprenant
            ]);


            // Versement


            // Versement::create([
            //     'inscription_id' => $inscription->id,
            //     'frais_id' => $frais->id,
            //     'montant' => $request->annees['versement'],
            //     'date_versement' => date('Y-m-d')
            // ]);

            // Tuteur


            if ($request->tuteurs['selection'] !== true) {
                foreach ($request->tuteurs['tuteurs'] as $tuteur) {
                    if (
                        $tuteur['nom'] === null &&
                        $tuteur['prenom'] === null &&
                        $tuteur['tel'] === null &&
                        $tuteur['sexe'] === null &&
                        $tuteur['email'] === null
                    ) {
                    } else {
                        $item_tuteur = Tuteur::create([
                            'nom' => $tuteur['nom'],
                            'prenom' => $tuteur['prenom'],
                            'telephone' => $tuteur['tel'],
                            // 'adresse' => $tuteur['adresse'],
                            'email' => $tuteur['email'],
                            'sexe' => $tuteur['sexe'],
                        ]);
                        ApprenantTuteur::create([
                            'apprenant_id' => $id_apprenant,
                            'tuteur_id' => $item_tuteur['id'],
                        ]);
                    }
                }
            } else {
                for ($i = 0; $i < count($request->tuteurs['selectTuteurs']); $i++) {
                    // dd($id_apprenant,$request->tuteurs['selectTuteurs'][$i]);
                    ApprenantTuteur::create([
                        'apprenant_id' => $id_apprenant,
                        'tuteur_id' => $request->tuteurs['selectTuteurs'][$i],
                    ]);
                }
            }



            // if($request->tuteurs['tuteurs']){
            //     if($request->tuteurs['selection'] !== true){
            //         foreach($request->tuteurs['tuteurs'] as $tuteur){
            //             $item_tuteur = Tuteur::create([
            //                 'nom' => $tuteur['nom'],
            //                 'prenom' => $tuteur['prenom'],
            //                 'telephone' => $tuteur['tel'],
            //                 // 'adresse' => $tuteur['adresse'],
            //                 'email' => $tuteur['email'],
            //                 'sexe' => $tuteur['sexe'],
            //             ]);
            //             ApprenantTuteur::create([
            //                 'apprenant_id' => $id_apprenant,
            //                 'tuteur_id' => $item_tuteur['id'],
            //             ]);
            //         }
            //     }else{
            //         for($i = 0; $i < count($request->tuteurs['selectTuteurs']); $i++){
            //             // dd($id_apprenant,$request->tuteurs['selectTuteurs'][$i]);
            //             ApprenantTuteur::create([
            //                 'apprenant_id' => $id_apprenant,
            //                 'tuteur_id' => $request->tuteurs['selectTuteurs'][$i],
            //             ]);
            //         }
            //     }
            // }



            if (isset($request->documents['documents'])) {
                foreach ($request->documents['documents'] as $document) {
                    // dd($document);
                    if (isset($document['file'][0])) {
                        $file_name = $document['file'][0]->getClientOriginalName();
                        $document['file'][0]->move('test/', $document['file'][0]->getClientOriginalName());
                    } else {
                        $file_name = null;
                    }
                    $item_tuteur = Document::create([
                        'type_document_id' => $document['type'],
                        'apprenant_id' => $id_apprenant,
                        'file' => $file_name,
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('message', [
                'type' => 'success',
                'text' => 'Inscription effectuée avec succès',
            ]);
        } catch (\Exception $e) {
            // En cas d'erreur, annulez la transaction
            // DB::rollback();
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => throw $e,
            ]);
            // Gérez l'erreur (log, renvoyez une réponse, etc.)
            throw $e;
        }
    }

    public function recuInscription(Request $request)
    {
        // dd($request->all());
        $etb = Etablissement::find(Auth::user()->etablissement_id);
        $ins = Inscription::where('id', $request->id)->with('annee', 'apprenant', 'niveau', 'cycleFiliere')->first();
        $apprenant_classe_annee = ApprenantClasseAnnee::whereHas('classe_annee',function ($query) use ($ins){
            $query->where('annee_id',$ins->annee_id);
        } )->where('apprenant_id',$ins->apprenant->id)->with('classe_annee')->get();
        $classe = Classe::where('id',$apprenant_classe_annee[0]->classe_annee->id)->get();
        $data = [
            'etablissement' => $etb,
            'inscription' => $ins,
            'section' => $request->section,
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y'),
            'classe' => $classe->first()
        ];

        $pdf = PDF::loadView('recu_inscription', $data);

        return $pdf->stream('itsolutionstuff.pdf');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('scolarite::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('scolarite::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

 /**
 * Exporter la liste des inscrits
 * @param Request $request
 * @param string $format
 * @return mixed
 */
/**
 * Exporter la liste des inscrits
 * @param Request $request
 * @param string $format
 * @return mixed
 */
/**
 * Exporter la liste des inscrits
 * @param Request $request
 * @param string $format
 * @return mixed
 */
/**
 * Exporter la liste des inscrits
 * @param Request $request
 * @param string $format
 * @return mixed
 */
public function exportInscriptions(Request $request, $format)
{
    try {
        $section = $request->section;
        $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
        $inscriptions = $this->calculerMontantsRestants($inscriptions);
        
        // CHARGER LES RELATIONS NÉCESSAIRES POUR LES TYPES DE FRAIS
        $inscriptionsAvecRelations = [];
        foreach ($inscriptions as $inscription) {
            // Charger les relations nécessaires pour les types de frais
            if (is_object($inscription) && method_exists($inscription, 'load')) {
                $inscription->load([
                    'versements.frais.etablissement_type_frais.type_frais',
                    'versements.frais.niveau'
                ]);
            }
            $inscriptionsAvecRelations[] = $inscription;
        }
        
        // Ajouter les informations de classe à chaque inscription
        $inscriptionsAvecClasses = [];
        foreach ($inscriptionsAvecRelations as $inscription) {
            $inscriptionData = is_array($inscription) ? $inscription : $inscription->toArray();
            
            // Récupérer la classe de l'apprenant
            $classeInfo = $this->getClasseForInscription($inscriptionData);
            
            $inscriptionData['classe_annee'] = $classeInfo;
            $inscriptionsAvecClasses[] = $inscriptionData;
        }
        
        if ($format === 'pdf') {
            $etb = Etablissement::find(Auth::user()->etablissement_id);
            $data = [
                'etablissement' => $etb,
                'inscriptions' => $inscriptionsAvecClasses,
                'section' => $section,
                'title' => 'Liste des inscrits',
                'date' => date('d/m/Y'),
            ];
            
            $pdf = PDF::loadView('exports.inscriptions_pdf', $data);
            return $pdf->download('liste_inscrits_' . date('Ymd_His') . '.pdf');
        } 
        elseif ($format === 'excel') {
            $fileName = 'liste_inscrits_' . date('Ymd_His') . '.xlsx';
            $export = new InscriptionsExport($inscriptionsAvecClasses, $section, 'Liste des inscrits');
            
            return Excel::download($export, $fileName, \Maatwebsite\Excel\Excel::XLSX, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de l\'export: ' . $e->getMessage()], 500);
    }
}

/**
 * Récupérer les informations de classe d'une inscription (même logique que recuInscription)
 */
private function getClasseForInscription($inscriptionData)
{
    $apprenantId = $inscriptionData['apprenant_id'] ?? null;
    $anneeId = $inscriptionData['annee_id'] ?? null;
    
    if (!$apprenantId || !$anneeId) {
        return ['classe' => ['libelle' => 'Non classé', 'code' => null]];
    }
    
    try {
        // Même logique que dans recuInscription
        $apprenant_classe_annee = ApprenantClasseAnnee::whereHas('classe_annee', function($query) use ($anneeId) {
                $query->where('annee_id', $anneeId);
            })
            ->where('apprenant_id', $apprenantId)
            ->with('classe_annee.classe')
            ->first();
        
        if ($apprenant_classe_annee && $apprenant_classe_annee->classe_annee && $apprenant_classe_annee->classe_annee->classe) {
            return [
                'classe' => [
                    'id' => $apprenant_classe_annee->classe_annee->classe->id,
                    'libelle' => $apprenant_classe_annee->classe_annee->classe->libelle,
                    'code' => $apprenant_classe_annee->classe_annee->classe->code,
                ]
            ];
        }
    } catch (\Exception $e) {
        // En cas d'erreur, logger et retourner une valeur par défaut
        \Log::error('Erreur récupération classe: ' . $e->getMessage());
    }
    
    return ['classe' => ['libelle' => 'Non classé', 'code' => null]];
}

/**
 * Normaliser les données pour inclure les informations de classe
 */
private function normaliserDonneesAvecClasses($inscriptions, $section)
{
    $inscriptionsNormalisees = [];
    
    foreach ($inscriptions as $inscription) {
        $inscriptionData = is_array($inscription) ? $inscription : $inscription->toArray();
        
        // Pour les sections 1 et 2 (Primaire/Secondaire) - ApprenantClasseAnnee
        if ($section == '1' || $section == '2') {
            // Les données contiennent déjà classe_annee
            if (isset($inscription->classe_annee)) {
                $inscriptionData['classe_annee'] = $inscription->classe_annee->toArray();
            } elseif (isset($inscriptionData['classe_annee'])) {
                // Déjà présent dans le tableau
            } else {
                // Récupérer la classe depuis la relation
                $classeAnnee = $this->getClasseAnneeForApprenant(
                    $inscriptionData['apprenant_id'] ?? null, 
                    getAnneeEncours()->id
                );
                if ($classeAnnee) {
                    $inscriptionData['classe_annee'] = $classeAnnee->toArray();
                } else {
                    $inscriptionData['classe_annee'] = [
                        'classe' => [
                            'libelle' => $inscriptionData['niveau']['libelle'] ?? 'Non classé',
                            'code' => $inscriptionData['niveau']['code'] ?? null,
                        ]
                    ];
                }
            }
        }
        // Pour les sections 3 et 4 (Supérieure) - Inscription
        else {
            // Récupérer la classe depuis ApprenantClasseAnnee
            $classeAnnee = $this->getClasseAnneeForApprenant(
                $inscriptionData['apprenant_id'] ?? null, 
                $inscriptionData['annee_id'] ?? getAnneeEncours()->id
            );
            
            if ($classeAnnee) {
                $inscriptionData['classe_annee'] = $classeAnnee->toArray();
            } else {
                // Si pas de classe trouvée, utiliser le niveau comme classe par défaut
                $inscriptionData['classe_annee'] = [
                    'classe' => [
                        'libelle' => $inscriptionData['niveau']['libelle'] ?? 'Non classé',
                        'code' => $inscriptionData['niveau']['code'] ?? null,
                    ]
                ];
            }
        }
        
        $inscriptionsNormalisees[] = $inscriptionData;
    }
    
    return $inscriptionsNormalisees;
}

/**
 * Récupérer la classe_annee d'un apprenant pour une année donnée
 */
private function getClasseAnneeForApprenant($apprenantId, $anneeId)
{
    if (!$apprenantId) {
        return null;
    }
    
    return ApprenantClasseAnnee::with(['classe_annee.classe', 'classe_annee.annee'])
        ->where('apprenant_id', $apprenantId)
        ->whereHas('classe_annee', function($query) use ($anneeId) {
            $query->where('annee_id', $anneeId);
        })
        ->first()
        ?->classe_annee;
}

/**
 * Générer le récapitulatif par type de frais
 * @param array $inscriptions
 * @return array
 */
private function genererRecapitulatifParTypeFrais($inscriptions)
{
    $recapitulatif = [];
    $totalPaye = 0;
    $totalRestant = 0;
    
    // Récupérer tous les types de frais
    $typesFrais = TypeFrais::all();
    
    foreach ($typesFrais as $typeFrais) {
        $totalTypePaye = 0;
        $totalTypeRestant = 0;
        
        foreach ($inscriptions as $inscription) {
            // Calculer les versements pour ce type de frais
            $versementsType = DB::table('versements')
                ->join('frais', 'versements.frais_id', '=', 'frais.id')
                ->where('versements.inscription_id', $inscription['id'] ?? null)
                ->where('frais.type_frais_id', $typeFrais->id)
                ->sum('versements.montant');
                
            // Calculer les frais totaux pour ce type
            $fraisType = DB::table('frais')
                ->where('niveau_id', $inscription['niveau_id'] ?? null)
                ->where('annee_id', getAnneeEncours()->id)
                ->where('type_frais_id', $typeFrais->id)
                ->where('etablissement_id', Auth::user()->etablissement_id)
                ->sum('montant');
                
            $totalTypePaye += $versementsType;
            $totalTypeRestant += max(0, $fraisType - $versementsType);
        }
        
        $pourcentage = $fraisType > 0 ? round(($totalTypePaye / $fraisType) * 100, 2) : 0;
        
        $recapitulatif[] = [
            'type_frais' => $typeFrais->libelle,
            'total_paye' => $totalTypePaye,
            'total_restant' => $totalTypeRestant,
            'pourcentage' => $pourcentage
        ];
        
        $totalPaye += $totalTypePaye;
        $totalRestant += $totalTypeRestant;
    }
    
    // Ajouter le total général
    $totalGeneralPourcentage = ($totalPaye + $totalRestant) > 0 
        ? round(($totalPaye / ($totalPaye + $totalRestant)) * 100, 2) 
        : 0;
        
    $recapitulatif[] = [
        'type_frais' => 'TOTAL GÉNÉRAL',
        'total_paye' => $totalPaye,
        'total_restant' => $totalRestant,
        'pourcentage' => $totalGeneralPourcentage
    ];
    
    return $recapitulatif;
}

/**
 * Exporter la liste des inscrits ayant fini leur paiement
 * @param Request $request
 * @param string $format
 * @return mixed
 */
public function exportInscriptionsPayees(Request $request, $format)
{
    try {
        $section = $request->section;
        $inscriptions = $this->getInscriptionsAvecPaiement($request, 'payees');
        $inscriptions = $this->calculerMontantsRestants($inscriptions);
        
        if (count($inscriptions) === 0) {
            return response()->json(['error' => 'Aucune inscription avec paiement complet à exporter'], 404);
        }
        
        // UTILISER VOTRE METHODE EXISTANTE
        $inscriptionsAvecClasses = $this->normaliserDonneesAvecClasses($inscriptions, $section);
        
        if ($format === 'pdf') {
            $etb = Etablissement::find(Auth::user()->etablissement_id);
            $data = [
                'etablissement' => $etb,
                'inscriptions' => $inscriptionsAvecClasses, // Données avec classes
                'section' => $section,
                'title' => 'Liste des inscrits ayant fini leur paiement',
                'date' => date('d/m/Y'),
            ];
            
            $pdf = PDF::loadView('exports.inscriptions_pdf', $data);
            return $pdf->download('liste_inscrits_payes_' . date('Ymd_His') . '.pdf');
        } 
        elseif ($format === 'excel') {
            $fileName = 'liste_inscrits_payes_' . date('Ymd_His') . '.xlsx';
            $export = new \Modules\Scolarite\Exports\InscriptionsPayeesExport($inscriptionsAvecClasses, $section);
            return Excel::download($export, $fileName); 
        }
        elseif ($format === 'word') {
            $etb = Etablissement::find(Auth::user()->etablissement_id);
            $data = [
                'etablissement' => $etb,
                'inscriptions' => $inscriptionsAvecClasses, // Données avec classes
                'section' => $section,
                'title' => 'Liste des inscrits ayant fini leur paiement',
                'date' => date('d/m/Y'),
            ];
            
            $html = view('exports.inscriptions_word', $data)->render();
            
            return response()->streamDownload(function () use ($html) {
                echo $html;
            }, 'liste_inscrits_payes_' . date('Ymd_His') . '.doc', [
                'Content-Type' => 'application/vnd.ms-word',
            ]);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de l\'export: ' . $e->getMessage()], 500);
    }
}
/**
 * Exporter la liste des inscrits n'ayant pas fini leur paiement
 * @param Request $request
 * @param string $format
 * @return mixed
 */
public function exportInscriptionsNonPayees(Request $request, $format)
{
    try {
        $section = $request->section;
        $inscriptions = $this->getInscriptionsAvecPaiement($request, 'non_payees');
        $inscriptions = $this->calculerMontantsRestants($inscriptions);

        if (count($inscriptions) === 0) {
            return response()->json(['error' => 'Aucune inscription avec paiement incomplet à exporter'], 404);
        }
        
        // UTILISER VOTRE METHODE EXISTANTE
        $inscriptionsAvecClasses = $this->normaliserDonneesAvecClasses($inscriptions, $section);
        
        if ($format === 'pdf') {
            $etb = Etablissement::find(Auth::user()->etablissement_id);
            $data = [
                'etablissement' => $etb,
                'inscriptions' => $inscriptionsAvecClasses, // Données avec classes
                'section' => $section,
                'title' => 'Liste des inscrits n\'ayant pas fini leur paiement',
                'date' => date('d/m/Y'),
            ];
            
            $pdf = PDF::loadView('exports.inscriptions_pdf', $data);
            return $pdf->download('liste_inscrits_non_payes_' . date('Ymd_His') . '.pdf');
        } 
        elseif ($format === 'excel') {
            $fileName = 'liste_inscrits_non_payes_' . date('Ymd_His') . '.xlsx';
            $export = new \Modules\Scolarite\Exports\InscriptionsNonPayeesExport($inscriptionsAvecClasses, $section);
            return Excel::download($export, $fileName);
        }
        elseif ($format === 'word') {
            $etb = Etablissement::find(Auth::user()->etablissement_id);
            $data = [
                'etablissement' => $etb,
                'inscriptions' => $inscriptionsAvecClasses, // Données avec classes
                'section' => $section,
                'title' => 'Liste des inscrits n\'ayant pas fini leur paiement',
                'date' => date('d/m/Y'),
            ];
            
            $html = view('exports.inscriptions_word', $data)->render();
            
            return response()->streamDownload(function () use ($html) {
                echo $html;
            }, 'liste_inscrits_non_payes_' . date('Ymd_His') . '.doc', [
                'Content-Type' => 'application/vnd.ms-word',
            ]);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de l\'export: ' . $e->getMessage()], 500);
    }
}
/**
 * Exporter la liste combinée des inscrits payés et non payés
 * @param Request $request
 * @param string $format
 * @return mixed
 */
public function exportInscriptionsCombine(Request $request, $format)
{
    try {
        $section = $request->section;
        
        // Récupérer les inscriptions payées et non payées
        $inscriptionsPayees = $this->getInscriptionsAvecPaiement($request, 'payees');
        $inscriptionsNonPayees = $this->getInscriptionsAvecPaiement($request, 'non_payees');
        
        // Calculer les montants restants
        $inscriptionsPayees = $this->calculerMontantsRestants($inscriptionsPayees);
        $inscriptionsNonPayees = $this->calculerMontantsRestants($inscriptionsNonPayees);
        
        if (count($inscriptionsPayees) === 0 && count($inscriptionsNonPayees) === 0) {
            return response()->json(['error' => 'Aucune inscription à exporter'], 404);
        }
        
        if ($format === 'excel') {
            $fileName = 'situation_paiements_' . date('Ymd_His') . '.xlsx';
            $export = new \Modules\Scolarite\Exports\InscriptionsPaiementCombineExport(
                $inscriptionsPayees, 
                $inscriptionsNonPayees, 
                $section
            );
            
            return Excel::download($export, $fileName);
        }
        else {
            return response()->json(['error' => 'Format non supporté pour l\'export combiné'], 400);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de l\'export combiné: ' . $e->getMessage()], 500);
    }
}



/**
 * Générer la fiche de présence (pour impression/contrôle)
 */
/**
 * Générer la fiche de présence (pour impression/contrôle)
 */
/**
 * Générer la fiche de présence (pour impression/contrôle)
 */
public function genererFichePresence(Request $request)
{
    try {
        // Récupérer la section depuis la requête ou utiliser une valeur par défaut
        $section = $request->get('section', $request->input('section', 1));
        
        if (!$section) {
            return response()->json(['error' => 'Section non spécifiée. Ajoutez ?section=1 à l\'URL'], 400);
        }

        // Récupérer les inscriptions
        $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
        
        if (empty($inscriptions)) {
            return response()->json(['error' => 'Aucune inscription trouvée pour la section ' . $section], 404);
        }

        // Utiliser la méthode corrigée
        $inscriptions = $this->ajouterInfosClasseCorrige($inscriptions);
        
        // Distribuer dans les classes selon la logique existante
        $inscriptions = $this->distribuerParClasses($inscriptions);
        
        $typePeriode = $request->get('type_periode', 'jour');
        $periode = $request->get('periode', '');
        $dateDebut = $request->get('date_debut', date('Y-m-d'));
        $dateFin = $request->get('date_fin', date('Y-m-d', strtotime('+6 days')));

        $fileName = 'fiche_presence_' . date('Ymd_His') . '.xlsx';
        
        $export = new \Modules\Scolarite\Exports\FichePresenceExport(
            $inscriptions, 
            $section, 
            $typePeriode, 
            $periode, 
            $dateDebut, 
            $dateFin
        );
        
        return Excel::download($export, $fileName);
        
    } catch (\Exception $e) {
        \Log::error('Erreur génération fiche présence: ' . $e->getMessage());
        return response()->json(['error' => 'Erreur lors de la génération: ' . $e->getMessage()], 500);
    }
}

/**
 * Générer la liste pour affichage en classe
 */
/**
 * Générer la liste pour affichage en classe
 */
public function genererListeAffichage(Request $request)
{
    try {
        // Récupérer la section depuis la requête ou utiliser une valeur par défaut
        $section = $request->get('section', $request->input('section', 1));
        
        if (!$section) {
            return response()->json(['error' => 'Section non spécifiée. Ajoutez ?section=1 à l\'URL'], 400);
        }

        // Récupérer les inscriptions
        $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
        
        if (empty($inscriptions)) {
            return response()->json(['error' => 'Aucune inscription trouvée pour la section ' . $section], 404);
        }

        // CORRECTION : Utiliser la méthode corrigée
        $inscriptions = $this->ajouterInfosClasseCorrige($inscriptions);
        
        // Distribuer dans les classes A, B, C si nécessaire
        $inscriptions = $this->distribuerParClasses($inscriptions);

        $fileName = 'liste_affichage_' . date('Ymd_His') . '.xlsx';
        
        // CORRECTION : Passer la section comme string simple
        $export = new ListeClasseAffichageExport($inscriptions, $section);
        
        return Excel::download($export, $fileName);
        
    } catch (\Exception $e) {
        \Log::error('Erreur génération liste affichage: ' . $e->getMessage());
        return response()->json(['error' => 'Erreur lors de la génération: ' . $e->getMessage()], 500);
    }
}

/**
 * CORRECTION : Méthode corrigée pour ajouter les infos de classe
 */
private function ajouterInfosClasseCorrige($inscriptions)
{
    $result = [];
    
    foreach ($inscriptions as $inscription) {
        // Convertir en tableau si c'est un objet
        $inscriptionData = json_decode(json_encode($inscription), true);
        
        // Récupérer la classe de l'apprenant
        $classeInfo = $this->getClasseForInscription($inscriptionData);
        
        // Ajouter les informations de classe
        $inscriptionData['classe_annee'] = $classeInfo;
        $inscriptionData['niveau_code'] = $classeInfo['niveau_code'] ?? null;
        $inscriptionData['classe_code'] = $classeInfo['classe_code'] ?? null;
        $inscriptionData['classe_libelle'] = $classeInfo['classe_libelle'] ?? null;
        
        $result[] = $inscriptionData;
    }
    
    return $result;
}

/**
 * Récupérer les informations de classe pour une inscription
 */

/**
 * Distribuer les élèves dans des classes selon la logique existante
 * Version optimisée avec répartition équilibrée
 */
private function distribuerParClasses($inscriptions)
{
    $groupedByNiveau = [];
    
    // Grouper d'abord par niveau
    foreach ($inscriptions as $inscription) {
        $niveauCode = $inscription['niveau_code'] ?? 'Non classé';
        
        if (!isset($groupedByNiveau[$niveauCode])) {
            $groupedByNiveau[$niveauCode] = [];
        }
        
        $groupedByNiveau[$niveauCode][] = $inscription;
    }
    
    $result = [];
    $lettres = ['A', 'B', 'C', 'D'];
    
    // Distribuer chaque niveau dans des classes A, B, C, D
    foreach ($groupedByNiveau as $niveauCode => $elevesNiveau) {
        $nombreEleves = count($elevesNiveau);
        $nombreClasses = min(ceil($nombreEleves / 25), 4); // Max 4 classes, ~25 élèves par classe
        
        // Répartir équitablement
        $elevesParClasse = ceil($nombreEleves / $nombreClasses);
        
        for ($i = 0; $i < $nombreEleves; $i++) {
            $classeIndex = floor($i / $elevesParClasse);
            $lettreClasse = $lettres[$classeIndex] ?? 'A';
            
            $elevesNiveau[$i]['classe_code'] = $niveauCode . $lettreClasse;
            $elevesNiveau[$i]['classe_libelle'] = $niveauCode . ' ' . $lettreClasse;
            
            $result[] = $elevesNiveau[$i];
        }
    }
    
    return $result;
}
// Nouvelle méthode pour calculer tous les montants
/**
 * Calculer les montants restants en excluant les versements supprimés
 */
private function calculerMontantsRestants($inscriptions)
{
    $anneeId = getAnneeEncours()->id;
    
    // Récupérer tous les IDs d'inscription et de niveau
    $inscriptionIds = [];
    $niveauIds = [];
    
    foreach ($inscriptions as $inscription) {
        $inscriptionIds[] = $inscription['id'] ?? $inscription->id ?? null;
        $niveauIds[] = $inscription['niveau_id'] ?? $inscription->niveau_id ?? null;
    }
    
    // Calculer les frais totaux par niveau (une seule requête)
    $fraisParNiveau = DB::table('frais')
        ->whereIn('niveau_id', array_filter(array_unique($niveauIds)))
        ->where('annee_id', $anneeId)
        ->where('etablissement_id', Auth::user()->etablissement_id)
        ->select('niveau_id', DB::raw('SUM(montant) as total_frais'))
        ->groupBy('niveau_id')
        ->pluck('total_frais', 'niveau_id')
        ->toArray();
    
    // CORRECTION: Exclure les versements supprimés avec whereNull('deleted_at')
    $versementsParInscription = DB::table('versements')
        ->whereIn('inscription_id', array_filter(array_unique($inscriptionIds)))
        ->whereNull('deleted_at') // EXCLURE LES VERSEMENTS SUPPRIMÉS
        ->select('inscription_id', DB::raw('SUM(montant) as total_verse'))
        ->groupBy('inscription_id')
        ->pluck('total_verse', 'inscription_id')
        ->toArray();
    
    // Ajouter les montants restants à chaque inscription
    foreach ($inscriptions as &$inscription) {
        $niveauId = $inscription['niveau_id'] ?? $inscription->niveau_id ?? null;
        $inscriptionId = $inscription['id'] ?? $inscription->id ?? null;
        
        $totalFrais = $fraisParNiveau[$niveauId] ?? 0;
        $totalVerse = $versementsParInscription[$inscriptionId] ?? 0;
        
        // CORRECTION: Éviter les montants négatifs
        $montantRestant = max(0, $totalFrais - $totalVerse);
        
        if (is_array($inscription)) {
            $inscription['montant_restant'] = $montantRestant;
            $inscription['montant_total_frais'] = $totalFrais;
            $inscription['montant_total_verse'] = $totalVerse;
        } else {
            $inscription->montant_restant = $montantRestant;
            $inscription->montant_total_frais = $totalFrais;
            $inscription->montant_total_verse = $totalVerse;
        }
    }
    
    return $inscriptions;
}



    /**
     * Calculer le montant restant à payer pour une inscription
     * @param array $inscription
     * @return float
     */
    private function calculerMontantRestant($inscription)
    {
        try {
            $apprenantId = isset($inscription['apprenant_id']) 
                ? $inscription['apprenant_id'] 
                : ($inscription['apprenant']['id'] ?? null);
            $anneeId = $inscription['annee_id'] ?? (getAnneeEncours()->id);     
            if (!$apprenantId) {
                return 0;
            }   
            // Méthode alternative sans utiliser les relations problématiques
            $totalFrais = DB::table('frais')
                ->join('niveaux', 'frais.niveau_id', '=', 'niveaux.id')
                ->join('inscriptions', 'niveaux.id', '=', 'inscriptions.niveau_id')
                ->where('frais.annee_id', $anneeId)
                ->where('inscriptions.apprenant_id', $apprenantId)
                ->where('inscriptions.annee_id', $anneeId)
                ->sum('frais.montant');         
            $totalVerse = DB::table('versements')
                ->join('inscriptions', 'versements.inscription_id', '=', 'inscriptions.id')
                ->where('inscriptions.apprenant_id', $apprenantId)
                ->where('inscriptions.annee_id', $anneeId)
                ->sum('versements.montant');         
            $montantRestant = max(0, $totalFrais - $totalVerse);
            return $montantRestant;
        } catch (\Exception $e) {
            \Log::error('Erreur calcul montant restant: ' . $e->getMessage());
            return 0;
        }
    }                       
    /**
     * Obtenir les inscriptions avec statut de paiement
     * @param Request $request
     * @param string $type
     * @return array
     */
    private function getInscriptionsAvecPaiement(Request $request, $type = 'all')
    {
        try {
            $inscriptions = $this->ajaxInscriptionListe($request, null, $request->section);
            
            $result = [];
            $anneeId = $request->annee_id ?? getAnneeEncours()->id;
            
            foreach ($inscriptions as $inscription) {
                try {
                    $apprenantId = isset($inscription['apprenant_id']) 
                        ? $inscription['apprenant_id'] 
                        : ($inscription['apprenant']['id'] ?? null);
                    
                    if (!$apprenantId) {
                        continue;
                    }
                    
                    // Vérifier le statut de paiement
                    $estPaye = $this->verifierPaiementComplet($apprenantId, $anneeId);
                    
                    if (($type === 'payees' && $estPaye) || 
                        ($type === 'non_payees' && !$estPaye) || 
                        $type === 'all') {
                        $result[] = $inscription;
                    }
                } catch (\Exception $e) {
                    \Log::error('Erreur traitement inscription: ' . $e->getMessage());
                    continue;
                }
            }
            
            return $result;
        } catch (\Exception $e) {
            \Log::error('Erreur getInscriptionsAvecPaiement: ' . $e->getMessage());
            return [];
        }
    }

        
        /**
     * Vérifier si un apprenant a complété son paiement
     * @param int $apprenantId
     * @param int $anneeId
     * @return bool
     */
    private function verifierPaiementComplet($apprenantId, $anneeId)
    {
        try {
            // Méthode alternative sans utiliser les relations problématiques
            $totalFrais = DB::table('frais')
                ->join('niveaux', 'frais.niveau_id', '=', 'niveaux.id')
                ->join('inscriptions', 'niveaux.id', '=', 'inscriptions.niveau_id')
                ->where('frais.annee_id', $anneeId)
                ->where('inscriptions.apprenant_id', $apprenantId)
                ->where('inscriptions.annee_id', $anneeId)
                ->sum('frais.montant');
            
            // Si aucun frais n'est défini, considérer comme payé
            if ($totalFrais <= 0) {
                return true;
            }
            
            $totalVerse = DB::table('versements')
                ->join('inscriptions', 'versements.inscription_id', '=', 'inscriptions.id')
                ->where('inscriptions.apprenant_id', $apprenantId)
                ->where('inscriptions.annee_id', $anneeId)
                ->sum('versements.montant');
            
            return $totalVerse >= $totalFrais;
        } catch (\Exception $e) {
            // En cas d'erreur, logger l'erreur et retourner false
            \Log::error('Erreur vérification paiement: ' . $e->getMessage());
            return false;
        }
    }
}
