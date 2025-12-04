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
use Maatwebsite\Excel\Facades\Excel;
use Modules\Scolarite\Entities\Frais;
use Modules\Scolarite\Entities\Tuteur;
use Illuminate\Support\Facades\Redirect;
use Modules\Enseignement\Entities\Niveau;
use Modules\Scolarite\Entities\TypeFrais;
use Modules\Scolarite\Entities\Versement;
use Modules\Scolarite\Entities\Inscription;
use Illuminate\Contracts\Support\Renderable;
use Modules\Enseignement\Entities\CycleFiliere;
use Modules\Scolarite\Exports\InscriptionsExport;
use Modules\Scolarite\Exports\FichePresenceExport;
use Modules\Scolarite\Exports\InscriptionsPayeesExport;
use Modules\Scolarite\Entities\EtablissementTypeDocument;
use Modules\Scolarite\Exports\FichePresenceAvanceeExport;
use Modules\Scolarite\Exports\ListeClasseAffichageExport;
use Modules\Scolarite\Exports\InscriptionsNonPayeesExport;
// Add this import
use Illuminate\Support\Str;


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
    try {
        \Log::info('🔍 DEBUT méthode edit - ID: ' . $id);

        // Chargez TOUTES les relations nécessaires
        $inscription = Inscription::with([
            'apprenant', 
            'apprenant.apprenantTuteurs.tuteur',
            'apprenant.apprenant_classe_annees.classe_annee.classe', // Classe de l'apprenant
            'apprenant.apprenant_classe_annees.classe_annee.annee',  // Année de la classe
            'niveau',
            'apprenant.documents.type_document',
        ])->find($id);

        if (!$inscription) {
            \Log::error('❌ Inscription non trouvée - ID: ' . $id);
            return redirect()->route('inscriptions.index')->with('error', 'Inscription non trouvée');
        }

        \Log::info('✅ Inscription trouvée: ' . $inscription->id);

        $section = $inscription->niveau->section_id ?? null;
        \Log::info('📋 Section: ' . $section);

        // Récupérer l'établissement section ID pour les typeDocuments
        $etablissement_id = Auth::user()->etablissement_id;
        $etablissement_section = DB::table('etablissement_section')
            ->where('etablissement_id', $etablissement_id)
            ->where('section_id', $section)
            ->first();

            // Récupérer les documents existants de l'apprenant
        $documentsExistants = [];
        if ($inscription->apprenant && $inscription->apprenant->documents) {
            $documentsExistants = $inscription->apprenant->documents->map(function ($document) {
                 // Les fichiers sont dans public/test/ donc on utilise asset()
            $filePath = 'test/' . $document->file;
            $fileExists = file_exists(public_path($filePath));
                return [
                    'id' => $document->id,
                    'type_document_id' => $document->type_document_id,
                    'type' => $document->type_document_id, // Pour compatibilité avec votre code
                    'file' => $document->file,
                    'file_name' => $document->file,
                    // 'file_url' => $document->file ? asset('storage/documents/' . $document->file) : null,
                    'file_url' => $fileExists ? asset($filePath) : null,
                    'file_exists' => $fileExists,
                    'created_at' => $document->created_at,
                    'type_document' => $document->type_document // Relation chargée
                ];
            })->toArray();
        }

        \Log::info('📄 Documents existants: ' . count($documentsExistants));

        // Récupérez les tuteurs
        $tuteurs = [];
        if ($inscription->apprenant && $inscription->apprenant->apprenantTuteurs) {
            $tuteurs = $inscription->apprenant->apprenantTuteurs->map(function ($apprenantTuteur) {
                return $apprenantTuteur->tuteur;
            })->filter();
        }

        // Récupérez la classe actuelle de l'apprenant
        $classeActuelle = null;
        $anneeClasseActuelle = null;
        
        if ($inscription->apprenant && $inscription->apprenant->apprenant_classe_annees) {
            // Prendre la dernière classe (la plus récente)
            $apprenantClasseAnnee = $inscription->apprenant->apprenant_classe_annees->sortByDesc('id')->first();
            
            if ($apprenantClasseAnnee && $apprenantClasseAnnee->classe_annee) {
                $classeActuelle = $apprenantClasseAnnee->classe_annee->classe;
                $anneeClasseActuelle = $apprenantClasseAnnee->classe_annee->annee;
            }
        }

        $data = [
            'inscription' => $inscription,
            'type' => $section,
            'niveaux' => Niveau::where('section_id', $section)->get(),
            'annees' => \App\Models\Annee::all(),
            'tuteurs' => $tuteurs,
            'classe_actuelle' => $classeActuelle, // Classe actuelle
            'annee_classe_actuelle' => $anneeClasseActuelle, // Année de la classe 'typeDocuments' => $etablissement_section ?
            'typeDocuments' => $etablissement_section ? 
                EtablissementTypeDocument::where('etablissement_section_id', $etablissement_section->id)
                    ->where('statut', '1')
                    ->with('type_document')
                    ->get() : [],
            'documentsExistants' => $documentsExistants // AJOUT CRITIQUE
        ];

        \Log::info('🚀 Rendu de la vue avec ' . $tuteurs->count() . ' tuteurs');
        \Log::info('🏫 Classe actuelle: ' . ($classeActuelle ? $classeActuelle->libelle : 'Aucune'));

        return Inertia::render('Inscription/Edit', $data);

    } catch (\Exception $e) {
        \Log::error('❌ ERREUR CRITIQUE dans edit: ' . $e->getMessage());
        \Log::error('❌ Stack trace: ' . $e->getTraceAsString());
        
        return redirect()->route('inscriptions.index')
            ->with('error', 'Erreur technique: ' . $e->getMessage());
    }
}

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
   public function update(Request $request, $id)
{
    try {
        \Log::info('🔄 DEBUT méthode update - ID: ' . $id);
        \Log::info('📦 Données reçues:', $request->all());

        DB::beginTransaction();

        $inscription = Inscription::findOrFail($id);
        $apprenant = $inscription->apprenant;

        // DEBUG: Vérifier ce qui est reçu
        \Log::info('📝 Données apprenant reçues:', $request->apprenants ?? []);
        \Log::info('📝 Données année reçues:', $request->annees ?? []);
        \Log::info('📝 Données tuteurs reçues:', $request->tuteurs ?? []);
        \Log::info('📝 Données documents reçues:', $request->documents ?? []);

        // 1. Mettre à jour l'apprenant - CORRECTION
        if ($request->has('apprenants')) {
            $apprenantData = [
                'nom' => $request->input('apprenants.nom', $apprenant->nom),
                'prenom' => $request->input('apprenants.prenom', $apprenant->prenom),
                'sexe' => $request->input('apprenants.sexe', $apprenant->sexe),
                'date_naissance' => $request->input('apprenants.date_naissance', $apprenant->date_naissance),
                'lieu_naissance' => $request->input('apprenants.lieu_naissance', $apprenant->lieu_naissance),
                'telephone' => $request->input('apprenants.telephone', $apprenant->telephone),
            ];
            
            \Log::info('💾 Mise à jour apprenant:', $apprenantData);
            $apprenant->update($apprenantData);
        }

        // 2. Mettre à jour l'inscription - CORRECTION
        if ($request->has('annees')) {
            $inscriptionData = [
                'annee_id' => $request->input('annees.annee', $inscription->annee_id),
                'niveau_id' => $request->input('annees.niveau', $inscription->niveau_id),
            ];
            
            \Log::info('💾 Mise à jour inscription:', $inscriptionData);
            $inscription->update($inscriptionData);

            // Gérer le changement de classe
            if ($request->has('annees.classe') && $request->input('annees.classe')) {
                $this->changerClasseApprenant($apprenant->id, $request->input('annees.classe'), $request->input('annees.annee'));
            }
        }

        // 3. Gérer les tuteurs - CORRECTION
        if ($request->has('tuteurs')) {
            // Supprimer les anciennes relations
            ApprenantTuteur::where('apprenant_id', $apprenant->id)->delete();

            if (isset($request->tuteurs['tuteurs'])) {
                foreach ($request->tuteurs['tuteurs'] as $tuteur) {
                    // Vérifier que le tuteur a au moins un champ rempli
                    if (!empty($tuteur['nom']) || !empty($tuteur['prenom']) || !empty($tuteur['tel'])) {
                        $tuteurModel = Tuteur::create([
                            'nom' => $tuteur['nom'] ?? '',
                            'prenom' => $tuteur['prenom'] ?? '',
                            'telephone' => $tuteur['tel'] ?? '',
                            'email' => $tuteur['email'] ?? '',
                            'sexe' => $tuteur['sexe'] ?? '',
                        ]);
                        
                        ApprenantTuteur::create([
                            'apprenant_id' => $apprenant->id,
                            'tuteur_id' => $tuteurModel->id,
                        ]);
                        
                        \Log::info('👨‍👩‍👧‍👦 Tuteur créé:', $tuteurModel->toArray());
                    }
                }
            }
        }

        // 4. GÉRER LES DOCUMENTS - CORRECTION COMPLÈTE
        if ($request->has('documents')) {
            \Log::info('📁 Traitement des documents...');
            
            // Documents à supprimer
            if (isset($request->documents['documents_supprimes']) && is_array($request->documents['documents_supprimes'])) {
                foreach ($request->documents['documents_supprimes'] as $docId) {
                    $document = Document::find($docId);
                    if ($document && $document->apprenant_id == $apprenant->id) {
                        // Supprimer le fichier physique
                        $filePath = public_path('test/' . $document->file);
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                        $document->delete();
                        \Log::info('🗑️ Document supprimé:', ['id' => $docId]);
                    }
                }
            }

            // Nouveaux documents
            if (isset($request->documents['documents']) && is_array($request->documents['documents'])) {
                foreach ($request->documents['documents'] as $documentData) {
                    if (isset($documentData['type']) && !empty($documentData['type'])) {
                        // Vérifier si un fichier est uploadé
                        if (isset($documentData['file']) && $documentData['file'] instanceof \Illuminate\Http\UploadedFile) {
                            $file = $documentData['file'];
                            $fileName = time() . '_' . $file->getClientOriginalName();
                            
                            // Déplacer le fichier
                            $file->move('test/', $fileName);
                            
                            // Vérifier si un document de ce type existe déjà
                            $existingDocument = Document::where('apprenant_id', $apprenant->id)
                                ->where('type_document_id', $documentData['type'])
                                ->first();
                            
                            if ($existingDocument) {
                                // Supprimer l'ancien fichier
                                $oldFilePath = public_path('test/' . $existingDocument->file);
                                if (file_exists($oldFilePath)) {
                                    unlink($oldFilePath);
                                }
                                // Mettre à jour le document
                                $existingDocument->update(['file' => $fileName]);
                                \Log::info('📄 Document mis à jour:', ['type' => $documentData['type'], 'file' => $fileName]);
                            } else {
                                // Créer un nouveau document
                                Document::create([
                                    'type_document_id' => $documentData['type'],
                                    'apprenant_id' => $apprenant->id,
                                    'file' => $fileName,
                                ]);
                                \Log::info('📄 Nouveau document créé:', ['type' => $documentData['type'], 'file' => $fileName]);
                            }
                        } else {
                            \Log::info('⚠️ Type document sans fichier:', ['type' => $documentData['type']]);
                        }
                    }
                }
            }
        }

        DB::commit();
        
        \Log::info('✅ MODIFICATION RÉUSSIE - Inscription ID: ' . $inscription->id);
        \Log::info('🔍 Données finales apprenant:', $apprenant->fresh()->toArray());
        \Log::info('🔍 Données finales inscription:', $inscription->fresh()->toArray());

        return redirect()->route('inscriptions.index', ['section_id' => $request->section])
            ->with('success', 'Inscription modifiée avec succès');

    } catch (\Exception $e) {
        DB::rollback();
        \Log::error('❌ ERREUR CRITIQUE dans update: ' . $e->getMessage());
        \Log::error('📋 Stack trace: ' . $e->getTraceAsString());
        
        return redirect()->back()->with('error', 'Erreur lors de la modification: ' . $e->getMessage());
    }
}

/**
 * Créer une classe automatiquement (même logique que dans store)
 */
private function creerClasseAutomatique($niveauId, $section)
{
    try {
        $niveau = Niveau::find($niveauId);
        if (!$niveau) return null;

        $etablissement_id = Auth::user()->etablissement_id;
        
        // Récupérer l'établissement section ID
        $etablissement_section = DB::table('etablissement_section')
            ->where('etablissement_id', $etablissement_id)
            ->where('section_id', $section)
            ->first();
        
        if (!$etablissement_section) return null;

        // MÊME LOGIQUE QUE DANS STORE
        if ($niveau->code != '6e' && $niveau->code != '5e' && $niveau->code != '4e' && $niveau->code != '3e') {
            $cod = '1';
        } else {
            $cod = 'A';
        }

        $classe = Classe::create([
            'code' => $niveau->code . ' ' . $cod,
            'libelle' => $niveau->libelle . ' ' . $cod,
            'niveau_id' => $niveauId,
            'etablissement_section_id' => $etablissement_section->id
        ]);

        return $classe->id;

    } catch (\Exception $e) {
        \Log::error('Erreur création classe automatique: ' . $e->getMessage());
        return null;
    }
}

/**
 * Changer la classe d'un apprenant
 */
private function changerClasseApprenant($apprenantId, $classeId, $anneeId)
{
    // Trouver ou créer la classe_annee
    $classeAnnee = ClasseAnnee::where('classe_id', $classeId)
        ->where('annee_id', $anneeId)
        ->first();

    if (!$classeAnnee) {
        $classeAnnee = ClasseAnnee::create([
            'classe_id' => $classeId,
            'annee_id' => $anneeId,
        ]);
    }

    // Supprimer l'ancienne classe_annee de l'apprenant pour cette année
    ApprenantClasseAnnee::where('apprenant_id', $apprenantId)
        ->whereHas('classe_annee', function($query) use ($anneeId) {
            $query->where('annee_id', $anneeId);
        })
        ->delete();

    // Ajouter la nouvelle classe
    ApprenantClasseAnnee::create([
        'apprenant_id' => $apprenantId,
        'classe_annee_id' => $classeAnnee->id,
    ]);
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
/**
 * Normaliser les données pour inclure les informations de classe
 */
private function normaliserDonneesAvecClasses($inscriptions, $section)
{
    $inscriptionsNormalisees = [];

    foreach ($inscriptions as $inscription) {
        // Gérer à la fois les tableaux, les objets Eloquent et les stdClass
        if (is_array($inscription)) {
            $inscriptionData = $inscription;
        } elseif (method_exists($inscription, 'toArray')) {
            // C'est un modèle Eloquent
            $inscriptionData = $inscription->toArray();
        } else {
            // C'est un stdClass ou autre objet, convertir en tableau
            $inscriptionData = (array) $inscription;
        }

        // Pour les sections 1 et 2 (Primaire/Secondaire) - ApprenantClasseAnnee
        if ($section == '1' || $section == '2') {
            // Les données contiennent déjà classe_annee
            if (isset($inscription->classe_annee)) {
                // Gérer la conversion de l'objet classe_annee
                if (is_object($inscription->classe_annee) && method_exists($inscription->classe_annee, 'toArray')) {
                    $inscriptionData['classe_annee'] = $inscription->classe_annee->toArray();
                } else {
                    $inscriptionData['classe_annee'] = (array) $inscription->classe_annee;
                }
            } elseif (isset($inscriptionData['classe_annee'])) {
                // Déjà présent dans le tableau, s'assurer que c'est un tableau
                if (is_object($inscriptionData['classe_annee'])) {
                    $inscriptionData['classe_annee'] = method_exists($inscriptionData['classe_annee'], 'toArray') 
                        ? $inscriptionData['classe_annee']->toArray() 
                        : (array) $inscriptionData['classe_annee'];
                }
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
 * Export de la liste de présence
 */
// public function exportListePresence(Request $request, $format)
// a revoir
// public function genererFichePresence(Request $request)
// {
//     try {
//         $section = $request->section;
//         $periode = $request->periode ?? 'mois'; // jour, semaine, mois
//         $matieres = $request->matieres ?? [];
        
//         $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
        
//         // Normaliser les données avec les classes
//         $inscriptionsAvecClasses = $this->normaliserDonneesAvecClasses($inscriptions, $section);
        
//                    $fileName = 'Fiche_presence_' . date('Ymd_His') . '.xlsx';
//             $export = new FichePresenceExport($inscriptionsAvecClasses, 'Liste de présence');
            
//             return Excel::download($export, $fileName, \Maatwebsite\Excel\Excel::XLSX);
        
//     } catch (\Exception $e) {
//         return response()->json(['error' => 'Erreur lors de l\'export: ' . $e->getMessage()], 500);
//     }
// }
/**
 * NOUVELLE MÉTHODE - Génération de fiche de présence avancée
 */
public function genererFichePresencePdf(Request $request)
{
    try {
        $section = $request->section;
        $periode = $request->periode_type ?? 'mois';
        $periodeLabel = $request->periode_label ?? '';
        $mois = $request->mois ?? date('n');
        $annee = $request->annee ?? date('Y');
        $matieres = $request->matieres ? explode(',', $request->matieres) : [];
        $includeSignature = filter_var($request->input('include_signature', true), FILTER_VALIDATE_BOOLEAN);
        $includeTotal = filter_var($request->input('include_total', true), FILTER_VALIDATE_BOOLEAN);
        $includeLogo = filter_var($request->input('include_logo', true), FILTER_VALIDATE_BOOLEAN);
        $alternateRows = filter_var($request->input('alternate_rows', true), FILTER_VALIDATE_BOOLEAN);
        
        // Déterminer le nombre de jours en fonction du mois/année
        $joursParPeriode = $this->getJoursParPeriode($periode, $mois, $annee);
        $libellesJours = $this->getLibellesJours($periode, $mois, $annee);
        
        
        $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
        $inscriptionsAvecClasses = $this->normaliserDonneesAvecClasses($inscriptions, $section);
        
        // Récupérer les infos de l'établissement
        $etablissement = Etablissement::find(Auth::user()->etablissement_id);
        
        // Grouper les inscriptions par classe
        $classes = [];
        foreach ($inscriptionsAvecClasses as $inscription) {
            $classeName = $inscription['classe_annee']['classe']['libelle'] ?? 'Non classé';
            if (!isset($classes[$classeName])) {
                $classes[$classeName] = [];
            }
            $classes[$classeName][] = $inscription;
        }
        
        $data = [
            'etablissement' => $etablissement,
            'classes' => $classes,
            'periode' => $periode,
            'periodeLabel' => $periodeLabel,
            'mois' => $mois,
            'annee' => $annee,
            'matieres' => $matieres,
            'joursParPeriode' => $joursParPeriode,
            'libellesJours' => $libellesJours,
            'includeLogo' => $includeLogo,
            'includeSignature' => $includeSignature,
            'includeTotal' => $includeTotal,
            'alternateRows' => $alternateRows,
            'title' => 'Fiche de Présence - ' . ucfirst($periode),
            'date' => date('d/m/Y à H:i'),
        ];  
        
        $pdf = PDF::loadView('exports.fiche_presence_pdf', $data);
        
        $fileName = 'Fiche_presence_' . $periode . '_' . date('Ymd_His') . '.pdf';
        return $pdf->download($fileName);
        
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la génération PDF: ' . $e->getMessage()], 500);
    }
}

/**
 * Détermine le nombre de jours en fonction de la période
 */
/**
 * Détermine le nombre de jours en fonction de la période
 */
private function getJoursParPeriode($periode, $mois = null, $annee = null)
{
    switch ($periode) {
        case 'jour':
            return 1;
        case 'semaine':
            return 7;
        case 'mois':
            // CALCUL DYNAMIQUE selon le mois et l'année
            if ($mois && $annee) {
                return cal_days_in_month(CAL_GREGORIAN, $mois, $annee);
            }
            return 31; // Fallback
        case 'trimestre':
            return 90; // Environ 3 mois
        case 'annuel':
            return 365; // Maximum pour une année
        default:
            return 31;
    }
}

/**
 * Génère les libellés des jours en fonction de la période
 */
/**
 * Génère les libellés des jours en fonction de la période
 */
private function getLibellesJours($periode, $mois = null, $annee = null)
{
    switch ($periode) {
        case 'jour':
            return ['Jour'];
            
        case 'semaine':
            return ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
            
        case 'mois':
            // CALCUL DYNAMIQUE selon le mois et l'année
            $nombreJours = $this->getJoursParPeriode($periode, $mois, $annee);
            $jours = [];
            for ($i = 1; $i <= $nombreJours; $i++) {
                $jours[] = str_pad($i, 2, '0', STR_PAD_LEFT);
            }
            return $jours;
            
        case 'trimestre':
            $jours = [];
            for ($i = 1; $i <= 90; $i++) {
                $jours[] = 'J' . $i;
            }
            return $jours;
            
        case 'annuel':
            $jours = [];
            for ($i = 1; $i <= 12; $i++) {
                $jours[] = date('M', mktime(0, 0, 0, $i, 1));
            }
            return $jours;
            
        default:
            $jours = [];
            for ($i = 1; $i <= 31; $i++) {
                $jours[] = str_pad($i, 2, '0', STR_PAD_LEFT);
            }
            return $jours;
    }
}


public function genererFichePresenceAvancee(Request $request)
{
    try {
        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', 120);
        
        $section = $request->section;
        $periode = $request->periode_type ?? 'mois';
        $periodeLabel = $request->periode_label ?? '';
        $mois = $request->mois ?? date('n');
        $annee = $request->annee ?? date('Y');
        $matieres = $request->matieres ? explode(',', $request->matieres) : [];
        $includeSignature = filter_var($request->input('include_signature', true), FILTER_VALIDATE_BOOLEAN);
        $includeTotal = filter_var($request->input('include_total', true), FILTER_VALIDATE_BOOLEAN);
        $includeLogo = filter_var($request->input('include_logo', true), FILTER_VALIDATE_BOOLEAN);
        $alternateRows = filter_var($request->input('alternate_rows', true), FILTER_VALIDATE_BOOLEAN);
        $outputFormat = $request->output_format ?? 'excel';
        
        // NOUVEAU: Récupérer les classes sélectionnées
        $selectedClasses = $request->selected_classes ? explode(',', $request->selected_classes) : [];
        
        \Log::info('Génération fiche présence avancée', [
            'section' => $section,
            'periode' => $periode,
            'classes_selectionnees' => $selectedClasses,
            'nombre_classes' => count($selectedClasses),
            'format' => $outputFormat
        ]);
        
        // Déterminer le nombre de jours en fonction du mois/année
        $joursParPeriode = $this->getJoursParPeriode($periode, $mois, $annee);
        $libellesJours = $this->getLibellesJours($periode, $mois, $annee);
        
        // Récupérer les inscriptions
        $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
        
        // FILTRER par classes sélectionnées si spécifié
        if (!empty($selectedClasses)) {
            $inscriptions = array_filter($inscriptions, function($inscription) use ($selectedClasses) {
                $classeAnneeId = $inscription['classe_annee_id'] ?? null;
                return in_array($classeAnneeId, $selectedClasses);
            });
            
            \Log::info('Inscriptions filtrées par classes', [
                'total_avant_filtre' => count($this->ajaxInscriptionListe($request, null, $section)),
                'total_apres_filtre' => count($inscriptions),
                'classes_selectionnees' => $selectedClasses
            ]);
        }
        
        $inscriptionsAvecClasses = $this->normaliserDonneesAvecClasses($inscriptions, $section);
        
        // Récupérer les infos de l'établissement
        $etablissement = Etablissement::find(Auth::user()->etablissement_id);
        
        // Grouper les inscriptions par classe
        $classes = [];
        foreach ($inscriptionsAvecClasses as $inscription) {
            $classeName = $inscription['classe_annee']['classe']['libelle'] ?? 'Non classé';
            if (!isset($classes[$classeName])) {
                $classes[$classeName] = [];
            }
            $classes[$classeName][] = $inscription;
        }
        
        \Log::info('Classes à générer', [
            'noms_classes' => array_keys($classes),
            'effectif_par_classe' => array_map('count', $classes)
        ]);
        
        // Si format PDF, utiliser la vue PDF
        if ($outputFormat === 'pdf') {
            $data = [
                'etablissement' => $etablissement,
                'classes' => $classes,
                'periode' => $periode,
                'periodeLabel' => $periodeLabel,
                'mois' => $mois,
                'annee' => $annee,
                'matieres' => $matieres,
                'joursParPeriode' => $joursParPeriode,
                'libellesJours' => $libellesJours,
                'includeLogo' => $includeLogo,
                'includeSignature' => $includeSignature,
                'includeTotal' => $includeTotal,
                'alternateRows' => $alternateRows,
                'title' => 'Fiche de Présence - ' . ucfirst($periode),
                'date' => date('d/m/Y à H:i'),
            ];  
            
            // Configuration spécifique pour DomPDF
            $pdf = PDF::loadView('exports.fiche_presence_pdf', $data);
            $pdf->setPaper('A4', $joursParPeriode > 20 ? 'landscape' : 'portrait');
            $pdf->setOption('enable_php', false);
            $pdf->setOption('isRemoteEnabled', true);
            $pdf->setOption('isHtml5ParserEnabled', true);
            
            $fileName = 'Fiche_presence_' . $periode . '_' . date('Ymd_His') . '.pdf';
            $safeFileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);
            
            \Log::info('Génération PDF terminée', [
                'fichier' => $safeFileName,
                'nombre_pages' => count($classes)
            ]);
            
            return $pdf->download($safeFileName);
        }
        
        // Format Excel (existant)
        $fileName = 'Fiche_presence_avancee_' . $periode . '_' . date('Ymd_His') . '.xlsx';
        
        // Passer les paramètres à l'export
        $export = new FichePresenceAvanceeExport(
            $inscriptionsAvecClasses, 
            'Fiche de Présence Avancée',
            $periode,
            $matieres,
            $periodeLabel,
            $includeSignature,
            $includeTotal,
            $includeLogo,
            $alternateRows,
            $joursParPeriode,
            $libellesJours,
            $mois,
            $annee
        );
        
        \Log::info('Génération Excel terminée', [
            'fichier' => $fileName,
            'nombre_inscriptions' => count($inscriptionsAvecClasses)
        ]);
        
        return Excel::download($export, $fileName, \Maatwebsite\Excel\Excel::XLSX);
        
    } catch (\Exception $e) {
        \Log::error('Erreur génération fiche présence avancée', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request' => $request->all()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la génération: ' . $e->getMessage(),
            'trace' => config('app.debug') ? $e->getTraceAsString() : null
        ], 500);
    }
}
/**
 * API pour récupérer les classes d'une section
 */
public function getClassesBySection($section)
{
    try {
        $classes = ClasseAnnee::withCount(['inscriptions as effectif' => function($query) use ($section) {
                $query->where('section_annee_id', $section);
            }])
            ->with('classe:niveau,libelle')
            ->whereHas('inscriptions', function($query) use ($section) {
                $query->where('section_annee_id', $section);
            })
            ->get()
            ->map(function($classeAnnee) {
                return [
                    'id' => $classeAnnee->id,
                    'libelle' => $classeAnnee->classe->libelle,
                    'niveau' => $classeAnnee->classe->niveau,
                    'effectif' => $classeAnnee->effectif
                ];
            });
        
        return response()->json([
            'success' => true,
            'classes' => $classes
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Erreur récupération classes section', [
            'section' => $section,
            'error' => $e->getMessage()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la récupération des classes',
            'error' => $e->getMessage()
        ], 500);
    }
}
/**
 * NOUVELLE MÉTHODE - Génération PDF par classe
 */
// public function genererFichesPdfParClasse(Request $request)
// {
//     try {
//         $section = $request->section;
//         $typeFiche = $request->type_fiche ?? 'presence';
//         $includeLogo = filter_var($request->input('include_logo', true), FILTER_VALIDATE_BOOLEAN);
//         $includeHeader = filter_var($request->input('include_header', true), FILTER_VALIDATE_BOOLEAN);
        
//         $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
//         $inscriptionsAvecClasses = $this->normaliserDonneesAvecClasses($inscriptions, $section);
        
//         // Grouper par classe
//         $classes = [];
//         foreach ($inscriptionsAvecClasses as $inscription) {
//             $classeName = $inscription['classe_annee']['classe']['libelle'] ?? 'Non classé';
//             if (!isset($classes[$classeName])) {
//                 $classes[$classeName] = [];
//             }
//             $classes[$classeName][] = $inscription;
//         }
        
//         $etablissement = Etablissement::find(Auth::user()->etablissement_id);
        
//         $data = [
//             'etablissement' => $etablissement,
//             'classes' => $classes,
//             'typeFiche' => $typeFiche,
//             'includeLogo' => $includeLogo,
//             'includeHeader' => $includeHeader,
//             'title' => 'Fiches par Classe - ' . ucfirst($typeFiche),
//             'date' => date('d/m/Y'),
//         ];
        
//         $pdf = PDF::loadView('exports.fiches_par_classe_pdf', $data);
        
//         $fileName = 'Fiches_par_classe_' . date('Ymd_His') . '.pdf';
//         return $pdf->download($fileName);
        
//     } catch (\Exception $e) {
//         return response()->json(['error' => 'Erreur lors de la génération PDF: ' . $e->getMessage()], 500);
//     }
// }
/**
 * Export de la liste d'affichage
 */
// public function exportListeAffichage(Request $request, $format)
public function genererListeAffichage(Request $request)
{
    try {
        $section = $request->section;
        $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
        
        // Normaliser les données avec les classes
        $inscriptionsAvecClasses = $this->normaliserDonneesAvecClasses($inscriptions, $section);
        
        
            $fileName = 'liste_affichage_' . date('Ymd_His') . '.xlsx';
            $export = new ListeClasseAffichageExport($inscriptionsAvecClasses, 'Liste d\'affichage');
            
            return Excel::download($export, $fileName, \Maatwebsite\Excel\Excel::XLSX);
        
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de l\'export: ' . $e->getMessage()], 500);
    }
}

/**
 * Génération PDF par classe - Version améliorée
 */
public function genererFichesPdfParClasse(Request $request)
{
    try {
        $section = $request->section;
        $typeFiche = $request->type_fiche ?? 'affichage';
        $includeLogo = filter_var($request->input('include_logo', true), FILTER_VALIDATE_BOOLEAN);
        $includeHeader = filter_var($request->input('include_header', true), FILTER_VALIDATE_BOOLEAN);
        
        // Récupérer les inscriptions
        $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
        $inscriptionsAvecClasses = $this->normaliserDonneesAvecClasses($inscriptions, $section);
        
        // Grouper par classe
        $classes = [];
        foreach ($inscriptionsAvecClasses as $inscription) {
            $classeName = $inscription['classe_annee']['classe']['libelle'] ?? 'Non classé';
            if (!isset($classes[$classeName])) {
                $classes[$classeName] = [];
            }
            $classes[$classeName][] = $inscription;
        }
        
        // Récupérer les infos de l'établissement
        $etablissement = Etablissement::find(Auth::user()->etablissement_id);
        
        $data = [
            'etablissement' => $etablissement,
            'classes' => $classes,
            'typeFiche' => $typeFiche,
            'includeLogo' => $includeLogo,
            'includeHeader' => $includeHeader,
            'title' => 'Listes d\'Affichage par Classe',
            'date' => date('d/m/Y'),
            'anneeScolaire' => '2024/2025' // À adapter selon votre logique
        ];
        
        // Configuration PDF
        $pdf = PDF::loadView('exports.listes_affichage_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);
        
        $fileName = 'Listes_Affichage_Classes_' . date('Ymd_His') . '.pdf';
        return $pdf->download($fileName);
        
    } catch (\Exception $e) {
        \Log::error('Erreur génération PDF: ' . $e->getMessage());
        return response()->json([
            'error' => 'Erreur lors de la génération PDF: ' . $e->getMessage()
        ], 500);
    }
}

//debut export registre bibliotheque, fiche dossier candidat, certificat scolarite, releve notes

/**
 * Générer le registre de bibliothèque (VIDE)
 */
public function genererRegistreBibliotheque(Request $request)
{
    try {
        $section = $request->section;
        $includeLogo = filter_var($request->input('include_logo', true), FILTER_VALIDATE_BOOLEAN);
        $includeSignature = filter_var($request->input('include_signature', true), FILTER_VALIDATE_BOOLEAN);
        
        // Limiter le nombre d'inscriptions pour éviter le timeout
        $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
        $inscriptionsAvecClasses = array_slice($this->normaliserDonneesAvecClasses($inscriptions, $section), 0, 10); // Limiter à 10
        
        $etablissement = Etablissement::find(Auth::user()->etablissement_id);
        
        $data = [
            'etablissement' => $etablissement,
            'inscriptions' => $inscriptionsAvecClasses,
            'includeLogo' => $includeLogo,
            'includeSignature' => $includeSignature,
            'title' => 'Registre de Bibliothèque',
            'dateGeneration' => date('d/m/Y'),
        ];
        
        $pdf = PDF::loadView('exports.registre_bibliotheque_pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        $fileName = 'registre_bibliotheque_' . date('Ymd_His') . '.pdf';
        return $pdf->download($fileName);
        
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la génération: ' . $e->getMessage()], 500);
    }
}

/**
 * Générer la fiche pour le dossier des candidats (VIDE)
 */
/**
 * Générer la fiche pour le dossier des candidats (TERMINALE et 3EME uniquement)
 */
public function genererFicheDossierCandidat(Request $request)
{
    try {
        $section = $request->section;
        $includeLogo = filter_var($request->input('include_logo', true), FILTER_VALIDATE_BOOLEAN);
        
        // Récupérer uniquement les élèves de Terminale et 3ème
        $inscriptions = $this->getInscriptionsTerminaleEtTroisieme($request, $section);
        
        $etablissement = Etablissement::find(Auth::user()->etablissement_id);
        
        $data = [
            'etablissement' => $etablissement,
            'inscriptions' => $inscriptions,
            'includeLogo' => $includeLogo,
            'title' => 'Fiche Dossier Candidat - Terminale/3ème',
            'dateGeneration' => date('d/m/Y'),
        ];
        
        $pdf = PDF::loadView('exports.fiche_dossier_candidat_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $fileName = 'fiche_dossier_candidat_terminale_3eme_' . date('Ymd_His') . '.pdf';
        return $pdf->download($fileName);
        
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la génération: ' . $e->getMessage()], 500);
    }
}

/**
 * Récupérer uniquement les inscriptions de Terminale et 3ème (TRI: Terminale d'abord)
 */
private function getInscriptionsTerminaleEtTroisieme(Request $request, $section)
{
    $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
    $inscriptionsAvecClasses = $this->normaliserDonneesAvecClasses($inscriptions, $section);
    
    $terminales = [];
    $troisiemes = [];
    
    foreach ($inscriptionsAvecClasses as $inscription) {
        $classeLibelle = $inscription['classe_annee']['classe']['libelle'] ?? '';
        $niveauLibelle = $inscription['niveau']['libelle'] ?? '';
        $niveauCode = $inscription['niveau']['code'] ?? '';
        
        // Convertir en minuscules pour la comparaison
        $classeLower = strtolower($classeLibelle);
        $niveauLower = strtolower($niveauLibelle);
        
        // Critères pour Terminale
        $isTerminale = 
            str_contains($classeLower, 'terminale') || 
            str_contains($niveauLower, 'terminale') ||
            str_contains($classeLower, 'tle') ||
            $niveauCode === 'Tle' ||
            $niveauCode === 'Term' ||
            str_contains($classeLower, 'terminal');
        
        // Critères pour 3ème
        $isTroisieme = 
            str_contains($classeLower, '3ème') || 
            str_contains($classeLower, '3eme') ||
            str_contains($niveauLower, '3ème') ||
            str_contains($niveauLower, '3eme') ||
            $niveauCode === '3ème' ||
            $niveauCode === '3eme' ||
            $niveauCode === '3e' ||
            str_contains($classeLower, 'troisième');
        
        if ($isTerminale) {
            $inscription['is_terminale'] = true;
            $terminales[] = $inscription;
        } elseif ($isTroisieme) {
            $inscription['is_terminale'] = false;
            $troisiemes[] = $inscription;
        }
    }
    
    // Combiner avec Terminale en premier
    $allInscriptions = array_merge($terminales, $troisiemes);
    
    return $allInscriptions;
}

// /**
//  * Générer le certificat de scolarité (OPTIMISÉ)
//  */
// public function genererCertificatScolarite(Request $request)
// {
//     try {
//         ini_set('max_execution_time', 300);
//         set_time_limit(300);
//         //set_time_limit(120); // Augmenter le timeout à 2 minutes
        
//         $section = $request->section;
//         $apprenantId = $request->apprenant_id;
//         $includeLogo = filter_var($request->input('include_logo', true), FILTER_VALIDATE_BOOLEAN);
        
//         // Si un apprenant spécifique est demandé
//         if ($apprenantId) {
//             $inscriptions = Inscription::with(['apprenant', 'niveau', 'annee', 'cycleFiliere.filiere'])
//                 ->where('apprenant_id', $apprenantId)
//                 ->get();
//         } else {
//             // Limiter à 5 inscriptions maximum pour éviter le timeout
//             $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
//             $inscriptions = array_slice($inscriptions, 0, 5);
//         }
        
//         $inscriptionsAvecClasses = $this->normaliserDonneesAvecClasses($inscriptions, $section);
        
//         $etablissement = Etablissement::find(Auth::user()->etablissement_id);
        
//         $data = [
//             'etablissement' => $etablissement,
//             'inscriptions' => $inscriptionsAvecClasses,
//             'includeLogo' => $includeLogo,
//             'title' => 'Certificat de Scolarité',
//             'dateGeneration' => date('d/m/Y'),
//         ];
        
//         $pdf = PDF::loadView('exports.certificat_scolarite_pdf', $data);
        
//         $fileName = 'certificat_scolarite_' . date('Ymd_His') . '.pdf';
        
//         return $pdf->download($fileName);
        
//     } catch (\Exception $e) {
//         return response()->json(['error' => 'Erreur lors de la génération: ' . $e->getMessage()], 500);
//     }
// }

// /**
//  * Générer le relevé de notes (OPTIMISÉ)
//  */
// public function genererReleveNotes(Request $request)
// {
//     try {
//         set_time_limit(120);
        
//         $section = $request->section;
//         $apprenantId = $request->apprenant_id;
//         $includeLogo = filter_var($request->input('include_logo', true), FILTER_VALIDATE_BOOLEAN);
        
//         if ($apprenantId) {
//             $inscriptions = Inscription::with(['apprenant', 'niveau', 'annee', 'cycleFiliere.filiere'])
//                 ->where('apprenant_id', $apprenantId)
//                 ->get();
//         } else {
//             $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
//             $inscriptions = array_slice($inscriptions, 0, 3); // Limiter à 3
//         }
        
//         $inscriptionsAvecClasses = $this->normaliserDonneesAvecClasses($inscriptions, $section);
        
//         // Récupérer les notes depuis la base de données
//         $donneesAvecNotes = [];
//         foreach ($inscriptionsAvecClasses as $inscription) {
//             $notes = $this->getNotesApprenant($inscription['apprenant_id'] ?? $inscription->apprenant_id);
            
//             $donneesAvecNotes[] = [
//                 'inscription' => $inscription,
//                 'notes' => $notes,
//                 'moyenne_generale' => $this->calculerMoyenneGenerale($notes)
//             ];
//         }
        
//         $etablissement = Etablissement::find(Auth::user()->etablissement_id);
        
//         $data = [
//             'etablissement' => $etablissement,
//             'donneesAvecNotes' => $donneesAvecNotes,
//             'includeLogo' => $includeLogo,
//             'title' => 'Relevé de Notes',
//             'dateGeneration' => date('d/m/Y'),
//         ];
        
//         $pdf = PDF::loadView('exports.releve_notes_pdf', $data);
//         $pdf->setPaper('A4', 'portrait');
        
//         $fileName = 'releve_notes_' . date('Ymd_His') . '.pdf';
//         return $pdf->download($fileName);
        
//     } catch (\Exception $e) {
//         return response()->json(['error' => 'Erreur lors de la génération: ' . $e->getMessage()], 500);
//     }
// }

// /**
//  * Générer le relevé de notes vide (OPTIMISÉ)
//  */
// /**
//  * Générer le relevé de notes vide PAR CLASSE et PAR MATIÈRE
//  */
// public function genererReleveNotesVide(Request $request)
// {
//     try {
//         // Vérifier que l'utilisateur est authentifié
//         if (!Auth::check()) {
//             return response()->json(['error' => 'Utilisateur non authentifié'], 401);
//         }

//         set_time_limit(120);
        
//         $section = $request->section;
//         $classeId = $request->classe_id; // Nouveau paramètre pour sélectionner une classe spécifique
//         $includeLogo = filter_var($request->input('include_logo', true), FILTER_VALIDATE_BOOLEAN);
        
//         // Récupérer l'établissement
//         $user = Auth::user();
//         $etablissement = Etablissement::find($user->etablissement_id);
        
//         if (!$etablissement) {
//             return response()->json(['error' => 'Établissement non trouvé'], 404);
//         }
        
//         // Récupérer les inscriptions groupées par classe
//         $classesAvecEleves = $this->getInscriptionsParClasse($request, $section, $classeId);
        
//         // Définir les matières par défaut selon la section
//         $matieres = $this->getMatieresParSection($section);
        
//         $data = [
//             'etablissement' => $etablissement,
//             'classesAvecEleves' => $classesAvecEleves,
//             'matieres' => $matieres,
//             'includeLogo' => $includeLogo,
//             'title' => 'Relevé de Notes - Modèle par Classe',
//             'dateGeneration' => date('d/m/Y'),
//         ];
        
//         $pdf = PDF::loadView('exports.releve_notes_vide_pdf', $data);
//         $pdf->setPaper('A4', 'portrait');
        
//         $fileName = 'releve_notes_par_classe_' . date('Ymd_His') . '.pdf';
//         return $pdf->download($fileName);
        
//     } catch (\Exception $e) {
//         \Log::error('Erreur génération relevé notes par classe: ' . $e->getMessage());
//         return response()->json(['error' => 'Erreur lors de la génération: ' . $e->getMessage()], 500);
//     }
// }

//debut
/**
 * Afficher la page de génération de documents paramétrable
 */
public function showGenererDocuments(Request $request)
{
    try {
        $section = $request->section;
        
        // Récupérer toutes les classes disponibles
        $classes = $this->getClassesDisponibles($section);
        
        // Récupérer les matières par section
        $matieres = $this->getMatieresParSection($section);
        
        // Types de documents disponibles
        $typesDocuments = [
            [
                'value' => 'releve_notes',
                'label' => '📊 Relevé de Notes',
                'description' => 'Fiche de notes par matière et par classe',
                'icon' => 'mdi-clipboard-list',
                'color' => '#3c80e7'
            ],
            [
                'value' => 'registre_bibliotheque',
                'label' => '📚 Registre Bibliothèque',
                'description' => 'Suivi des prêts de documents',
                'icon' => 'mdi-book-account',
                'color' => '#FF9800'
            ],
            [
                'value' => 'dossier_candidat',
                'label' => '📁 Dossier Candidat',
                'description' => 'Checklist documents pour examen',
                'icon' => 'mdi-folder-account',
                'color' => '#9C27B0'
            ],
            [
                'value' => 'certificat_scolarite',
                'label' => '🎓 Certificat de Scolarité',
                'description' => 'Attestation officielle de scolarité',
                'icon' => 'mdi-certificate',
                'color' => '#4CAF50'
            ]
        ];

        return Inertia::render('GenererDocuments/Index', [
            'section' => $section,
            'classes' => $classes,
            'matieres' => $matieres,
            'typesDocuments' => $typesDocuments,
            'vSectionID' => $section
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Erreur page génération documents: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage());
    }
}

/**
 * Générer un document selon les paramètres
 */
/**
 * Générer un document selon les paramètres
 */
/**
 * Générer un document selon les paramètres
 */
public function genererDocumentParametrable(Request $request)
{
    try {
        if (!Auth::check()) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        $section = $request->get('section');
        $typeDocument = $request->get('type_document');
        $classeId = $request->get('classe_id');
        $eleveId = $request->get('eleve_id'); // ← NOUVEAU PARAMÈTRE
        $matieresSelectionnees = $request->get('matieres', []);
        $options = $request->get('options', []);

        // Récupérer l'établissement
        $user = Auth::user();
        $etablissement = Etablissement::find($user->etablissement_id);
        
        if (!$etablissement) {
            return response()->json(['error' => 'Établissement non trouvé'], 404);
        }

        // Convertir la chaîne matières en tableau si nécessaire
        if (is_string($matieresSelectionnees)) {
            $matieresSelectionnees = [$matieresSelectionnees];
        }

        // S'assurer que $options est toujours un tableau
        if (is_string($options)) {
            $options = [$options];
        } elseif (!is_array($options)) {
            $options = [];
        }

        // Récupérer les données selon les paramètres
        $classesAvecEleves = $this->getInscriptionsParClasse($request, $section, $classeId);

        // Filtrer les matières si sélectionnées
        $toutesMatieres = $this->getMatieresParSection($section);
        $matieres = empty($matieresSelectionnees) ? $toutesMatieres : $matieresSelectionnees;

        // PRÉPARER LES DONNÉES DE BASE
        $data = [
            'etablissement' => $etablissement,
            'classesAvecEleves' => $classesAvecEleves,
            'matieres' => $matieres,
            'includeLogo' => in_array('include_logo', $options),
            'includeSignature' => in_array('include_signature', $options),
            'title' => $this->getTitreDocument($typeDocument),
            'dateGeneration' => date('d/m/Y'),
            'options' => $options
        ];

        // AJOUTER LES VARIABLES SPÉCIFIQUES POUR CHAQUE TYPE DE DOCUMENT
        $inscriptions = [];
        foreach ($classesAvecEleves as $classe) {
            if (isset($classe['eleves']) && is_array($classe['eleves'])) {
                $inscriptions = array_merge($inscriptions, $classe['eleves']);
            }
        }
        
        // FILTRER PAR ÉLÈVE SPÉCIFIQUE SI DEMANDÉ
        if ($eleveId) {
            $inscriptions = array_filter($inscriptions, function($inscription) use ($eleveId) {
                return ($inscription['apprenant']['id'] ?? null) == $eleveId;
            });
            
            // Si un élève spécifique est sélectionné, ajouter ses infos détaillées
            if (count($inscriptions) > 0) {
                $data['eleve_selectionne'] = $inscriptions[0]['apprenant'] ?? null;
            }
        }
        
        // Ajouter $inscriptions pour tous les documents
        $data['inscriptions'] = $inscriptions;

        // Charger la vue appropriée selon le type de document
        $viewName = $this->getViewDocument($typeDocument);

        if (!view()->exists($viewName)) {
            return response()->json(['error' => 'Type de document non supporté: ' . $typeDocument], 400);
        }

        $pdf = PDF::loadView($viewName, $data);
        
        // Configuration du papier selon le document
        if ($typeDocument === 'registre_bibliotheque') {
            $pdf->setPaper('A4', 'landscape');
        } else {
            $pdf->setPaper('A4', 'portrait');
        }

        $fileName = $this->getNomFichierPersonnalise($typeDocument, $eleveId, $inscriptions);
        return $pdf->download($fileName);
        
    } catch (\Exception $e) {
        \Log::error('Erreur génération document paramétrable: ' . $e->getMessage());
        return response()->json(['error' => 'Erreur lors de la génération: ' . $e->getMessage()], 500);
    }
}

/**
 * Récupérer les inscriptions avec filtres avancés
 */
private function getInscriptionsParClasseFiltree(Request $request, $section, $classeId = null, $niveauId = null, $eleveId = null)
{
    $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
    $inscriptionsAvecClasses = $this->normaliserDonneesAvecClasses($inscriptions, $section);
    
    // Grouper par classe
    $classes = [];
    
    foreach ($inscriptionsAvecClasses as $inscription) {
        $classeLibelle = $inscription['classe_annee']['classe']['libelle'] ?? 'Classe non définie';
        $currentClasseId = $inscription['classe_annee']['classe']['id'] ?? null;
        $currentNiveauId = $inscription['niveau']['id'] ?? null;
        $currentEleveId = $inscription['apprenant']['id'] ?? null;
        
        // Appliquer les filtres
        if ($classeId && $currentClasseId != $classeId) {
            continue;
        }
        
        if ($niveauId && $currentNiveauId != $niveauId) {
            continue;
        }
        
        if ($eleveId && $currentEleveId != $eleveId) {
            continue;
        }
        
        if (!isset($classes[$classeLibelle])) {
            $classes[$classeLibelle] = [
                'libelle' => $classeLibelle,
                'id' => $currentClasseId,
                'niveau' => $inscription['niveau']['libelle'] ?? '',
                'eleves' => []
            ];
        }
        
        $classes[$classeLibelle]['eleves'][] = $inscription;
    }
    
    return array_values($classes);
}

/**
 * Récupérer un élève par son ID
 */
private function getEleveById($eleveId)
{
    // Implémentez cette méthode selon votre modèle
    // Exemple :
    // return Apprenant::with(['inscriptions.classeAnnee.classe', 'inscriptions.niveau'])
    //     ->find($eleveId);
    
    // Pour l'instant, retournez null ou implémentez selon vos besoins
    return null;
}
/**
 * Générer un nom de fichier personnalisé avec le nom de l'élève
 */
private function getNomFichierPersonnalise($typeDocument, $eleveId, $inscriptions)
{
    $baseName = $this->getNomFichier($typeDocument);
    
    if ($eleveId && count($inscriptions) > 0) {
        $eleve = $inscriptions[0]['apprenant'] ?? null;
        if ($eleve) {
            $nomEleve = Str::slug($eleve['nom'] . '_' . $eleve['prenom']);
            return $baseName . '_' . $nomEleve . '_' . date('Ymd_His') . '.pdf';
        }
    }
    
    return $baseName . '_' . date('Ymd_His') . '.pdf';
}

/**
 * Récupérer les élèves d'une classe spécifique
 */
/**
 * Récupérer les élèves d'une classe spécifique - VERSION CORRIGÉE
 */
/**
 * Récupérer les élèves d'une classe spécifique
 */
public function getElevesParClasse(Request $request, $classeId)
{
    try {
        \Log::info("🔍 Récupération élèves pour classe ID: " . $classeId);

        // Vérifier d'abord si la classe existe
        $classe = \App\Models\Classe::find($classeId);
        if (!$classe) {
            return response()->json(['error' => 'Classe non trouvée'], 404);
        }

        // Récupérer les élèves via ApprenantClasseAnnee
        $apprenantsClasse = \App\Models\ApprenantClasseAnnee::with([
            'apprenant:id,nom,prenom,matricule',
            'classe_annee.classe:id,libelle'
        ])
        ->whereHas('classe_annee', function($query) use ($classeId) {
            $query->where('classe_id', $classeId);
        })
        ->whereHas('apprenant')
        ->get();

        $eleves = [];

        foreach ($apprenantsClasse as $apprenantClasse) {
            if ($apprenantClasse->apprenant) {
                $eleves[] = [
                    'id' => $apprenantClasse->apprenant->id,
                    'nom_complet' => $apprenantClasse->apprenant->nom . ' ' . $apprenantClasse->apprenant->prenom,
                    'matricule' => $apprenantClasse->apprenant->matricule ?? 'N/A',
                    'classe' => $apprenantClasse->classe_annee->classe->libelle ?? 'Classe inconnue'
                ];
            }
        }

        \Log::info("🎯 " . count($eleves) . " élève(s) trouvé(s) pour la classe " . $classe->libelle);

        return response()->json($eleves);

    } catch (\Exception $e) {
        \Log::error('❌ ERREUR getElevesParClasse: ' . $e->getMessage());
        return response()->json(['error' => 'Erreur serveur: ' . $e->getMessage()], 500);
    }
}

/**
 * Obtenir le nom de la vue selon le type de document
 */
private function getViewDocument($typeDocument)
{
    $views = [
        'releve_notes' => 'exports.releve_notes_par_matiere_pdf',
        'registre_bibliotheque' => 'exports.registre_bibliotheque_pdf',
        'dossier_candidat' => 'exports.fiche_dossier_candidat_pdf',
        'certificat_scolarite' => 'exports.certificat_scolarite_pdf'
    ];

    return $views[$typeDocument] ?? 'exports.releve_notes_par_matiere_pdf';
}

/**
 * Obtenir le titre du document
 */
private function getTitreDocument($typeDocument)
{
    $titres = [
        'releve_notes' => 'Relevé de Notes',
        'registre_bibliotheque' => 'Registre de Bibliothèque',
        'dossier_candidat' => 'Fiche Dossier Candidat',
        'certificat_scolarite' => 'Certificat de Scolarité'
    ];

    return $titres[$typeDocument] ?? 'Document';
}

/**
 * Obtenir le nom du fichier
 */
private function getNomFichier($typeDocument)
{
    $noms = [
        'releve_notes' => 'releve_notes',
        'registre_bibliotheque' => 'registre_bibliotheque',
        'dossier_candidat' => 'dossier_candidat',
        'certificat_scolarite' => 'certificat_scolarite'
    ];

    return $noms[$typeDocument] ?? 'document';
}
//fin

/**
 * Afficher la page de paramétrage
 */
public function showParametresReleveNotes(Request $request)
{
    try {
        $section = $request->section;
        
        // Récupérer toutes les classes disponibles
        $classes = $this->getClassesDisponibles($section);
        
        // Récupérer les matières par section
        $matieres = $this->getMatieresParSection($section);
        
        // Si pas de classes, créer des données de démo
        if (empty($classes)) {
            $classes = [
                ['id' => 1, 'libelle' => 'Terminale A', 'niveau' => 'Terminale'],
                ['id' => 2, 'libelle' => 'Terminale B', 'niveau' => 'Terminale'],
                ['id' => 3, 'libelle' => '3ème A', 'niveau' => '3ème'],
                ['id' => 4, 'libelle' => '3ème B', 'niveau' => '3ème'],
            ];
        }
        
        return Inertia::render('ReleveNotes/Parametres', [
            'section' => $section,
            'classes' => $classes,
            'matieres' => $matieres,
            'vSectionID' => $section
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Erreur page paramètres relevé notes: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage());
    }
}

/**
 * Générer le relevé de notes selon les paramètres
 */
/**
 * Générer le relevé de notes selon les paramètres (GET)
 */
public function genererReleveNotesParametrable(Request $request)
{
    try {
        if (!Auth::check()) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        $section = $request->get('section');
        $classeId = $request->get('classe_id');
        $matieresSelectionnees = $request->get('matieres');
        $format = $request->get('format', 'par_matiere');
        
        // Convertir la chaîne matières en tableau si nécessaire
        if (is_string($matieresSelectionnees)) {
            $matieresSelectionnees = [$matieresSelectionnees];
        }

        // Récupérer l'établissement
        $user = Auth::user();
        $etablissement = Etablissement::find($user->etablissement_id);
        
        if (!$etablissement) {
            return response()->json(['error' => 'Établissement non trouvé'], 404);
        }
        
        // Récupérer les données selon les paramètres
        $classesAvecEleves = $this->getInscriptionsParClasse($request, $section, $classeId);
        
        // Filtrer les matières si sélectionnées
        $toutesMatieres = $this->getMatieresParSection($section);
        $matieres = empty($matieresSelectionnees) ? $toutesMatieres : $matieresSelectionnees;
        
        $data = [
            'etablissement' => $etablissement,
            'classesAvecEleves' => $classesAvecEleves,
            'matieres' => $matieres,
            'includeLogo' => true,
            'title' => 'Relevé de Notes - Sélection Personnalisée',
            'dateGeneration' => date('d/m/Y'),
            'format' => $format
        ];
        
        // Charger la vue appropriée selon le format
        $viewName = $format === 'par_matiere' ? 'exports.releve_notes_par_matiere_pdf' : 'exports.releve_notes_parametrable_pdf';
        
        $pdf = PDF::loadView($viewName, $data);
        $pdf->setPaper('A4', 'portrait');
        
        $fileName = 'releve_notes_personnalise_' . date('Ymd_His') . '.pdf';
        return $pdf->download($fileName);
        
    } catch (\Exception $e) {
        \Log::error('Erreur génération relevé notes paramétrable: ' . $e->getMessage());
        return response()->json(['error' => 'Erreur lors de la génération: ' . $e->getMessage()], 500);
    }
}

/**
 * Générer le relevé pour une matière spécifique
 */
public function genererReleveNotesParMatiere($classeId, $matiere)
{
    try {
        if (!Auth::check()) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        // Récupérer l'établissement
        $user = Auth::user();
        $etablissement = Etablissement::find($user->etablissement_id);
        
        if (!$etablissement) {
            return response()->json(['error' => 'Établissement non trouvé'], 404);
        }
        
        // Récupérer la classe spécifique
        $request = new Request();
        $classesAvecEleves = $this->getInscriptionsParClasse($request, null, $classeId);
        
        if (empty($classesAvecEleves)) {
            return response()->json(['error' => 'Classe non trouvée'], 404);
        }
        
        $data = [
            'etablissement' => $etablissement,
            'classesAvecEleves' => $classesAvecEleves,
            'matieres' => [$matiere],
            'includeLogo' => true,
            'title' => 'Relevé de Notes - ' . $matiere,
            'dateGeneration' => date('d/m/Y'),
            'format' => 'fiche_unique'
        ];
        
        $pdf = PDF::loadView('exports.releve_notes_par_matiere_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $fileName = 'releve_' . Str::slug($matiere) . '_' . date('Ymd_His') . '.pdf';
        return $pdf->download($fileName);
        
    } catch (\Exception $e) {
        \Log::error('Erreur génération relevé par matière: ' . $e->getMessage());
        return response()->json(['error' => 'Erreur lors de la génération: ' . $e->getMessage()], 500);
    }
}

/**
 * Récupérer les classes disponibles
 */
private function getClassesDisponibles($section)
{
    $inscriptions = $this->ajaxInscriptionListe(new Request(), null, $section);
    $inscriptionsAvecClasses = $this->normaliserDonneesAvecClasses($inscriptions, $section);
    
    $classes = [];
    
    foreach ($inscriptionsAvecClasses as $inscription) {
        $classeLibelle = $inscription['classe_annee']['classe']['libelle'] ?? 'Classe non définie';
        $classeId = $inscription['classe_annee']['classe']['id'] ?? null;
        
        if ($classeId && !isset($classes[$classeId])) {
            $classes[$classeId] = [
                'id' => $classeId,
                'libelle' => $classeLibelle,
                'niveau' => $inscription['niveau']['libelle'] ?? ''
            ];
        }
    }
    
    return array_values($classes);
}
/**
 * Récupérer les inscriptions groupées par classe
 */
/**
 * Récupérer les inscriptions groupées par classe avec filtrage correct
 */
/**
 * Récupérer les inscriptions groupées par classe avec filtrage correct
 */
private function getInscriptionsParClasse(Request $request, $section, $classeId = null)
{
    $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
    $inscriptionsAvecClasses = $this->normaliserDonneesAvecClasses($inscriptions, $section);
    
    // Grouper par classe
    $classes = [];
    
    foreach ($inscriptionsAvecClasses as $inscription) {
        $classeLibelle = $inscription['classe_annee']['classe']['libelle'] ?? 'Classe non définie';
        $currentClasseId = $inscription['classe_annee']['classe']['id'] ?? null; // ← CHANGER LE NOM ICI
        
        // Si une classe spécifique est demandée, filtrer
        if ($classeId && $currentClasseId != $classeId) {
            continue;
        }
        
        if (!isset($classes[$classeLibelle])) {
            $classes[$classeLibelle] = [
                'libelle' => $classeLibelle,
                'id' => $currentClasseId, // ← UTILISER LE NOUVEAU NOM
                'eleves' => []
            ];
        }
        
        $classes[$classeLibelle]['eleves'][] = $inscription;
    }
    
    return array_values($classes);
}
/**
 * Définir les matières par section
 */
private function getMatieresParSection($section)
{
    $matieres = [
        '1' => ['Mathématiques', 'Français', 'Éveil', 'EPS', 'Arts'],
        '2' => ['Mathématiques', 'Français', 'Anglais', 'SVT', 'Physique-Chimie', 'Histoire-Géo', 'EPS'],
        '3' => ['Mathématiques', 'Informatique', 'Économie', 'Droit', 'Gestion', 'Communication'],
        '4' => ['Spécialité 1', 'Spécialité 2', 'Méthodologie', 'Recherche', 'Langues']
    ];
    
    return $matieres[$section] ?? ['Mathématiques', 'Français', 'Anglais'];
}
//fin ajout

// /**
//  * Générer la fiche de présence (pour impression/contrôle)
//  */
// /**
//  * Générer la fiche de présence (pour impression/contrôle)
//  */
// /**
//  * Générer la fiche de présence (pour impression/contrôle)
//  */
// public function genererFichePresence(Request $request)
// {
//     $section = $request->section;
    
//     // S'assurer que $section est un tableau si elle existe
//     if ($section && !is_array($section)) {
//         // Si c'est une chaîne JSON, la décoder
//         if (is_string($section) && json_decode($section)) {
//             $section = json_decode($section, true);
//         } else {
//             // Sinon, créer un tableau basique
//             $section = ['id' => $section];
//         }
//     }
    
//     $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
    
//     // Ajouter les informations de classe à chaque inscription
//     $inscriptionsAvecClasses = [];
    
//     // Si $inscriptions est une collection, convertir en tableau
//     $inscriptionsArray = is_array($inscriptions) ? $inscriptions : $inscriptions->toArray();
    
//     foreach ($inscriptionsArray as $inscriptionData) {
//         // Récupérer la classe de l'apprenant
//         $classeInfo = $this->getClasseForInscription($inscriptionData);
//         $inscriptionData['classe_annee'] = $classeInfo;
//         $inscriptionsAvecClasses[] = $inscriptionData;
//     }
    
//     $fileName = 'fiche_presence_' . date('Ymd_His') . '.xlsx';
//     $export = new InscriptionsExport($inscriptionsAvecClasses, $section, 'fiches');
    
//     return Excel::download($export, $fileName, \Maatwebsite\Excel\Excel::XLSX, [
//         'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
//     ]);
// }

// /**
//  * Générer la liste pour affichage en classe
//  */
// /**
//  * Générer la liste pour affichage en classe
//  */
// public function genererListeAffichage(Request $request)
// {
//     try {
//         // Récupérer la section depuis la requête ou utiliser une valeur par défaut
//         $section = $request->get('section', $request->input('section', 1));
        
//         if (!$section) {
//             return response()->json(['error' => 'Section non spécifiée. Ajoutez ?section=1 à l\'URL'], 400);
//         }

//         // Récupérer les inscriptions
//         $inscriptions = $this->ajaxInscriptionListe($request, null, $section);
        
//         if (empty($inscriptions)) {
//             return response()->json(['error' => 'Aucune inscription trouvée pour la section ' . $section], 404);
//         }

//         // CORRECTION : Utiliser la méthode corrigée
//         $inscriptions = $this->ajouterInfosClasseCorrige($inscriptions);
        
//         // Distribuer dans les classes A, B, C si nécessaire
//         $inscriptions = $this->distribuerParClasses($inscriptions);

//         $fileName = 'liste_affichage_' . date('Ymd_His') . '.xlsx';
        
//         // CORRECTION : Passer la section comme string simple
//         $export = new ListeClasseAffichageExport($inscriptions, $section);
        
//         return Excel::download($export, $fileName);
        
//     } catch (\Exception $e) {
//         \Log::error('Erreur génération liste affichage: ' . $e->getMessage());
//         return response()->json(['error' => 'Erreur lors de la génération: ' . $e->getMessage()], 500);
//     }
// }

// /**
//  * CORRECTION : Méthode corrigée pour ajouter les infos de classe (même logique que exports)
//  */
//     /**
//  * CORRECTION : Méthode corrigée pour ajouter les infos de classe (même logique que exports)
//  */
// private function ajouterInfosClasseCorrige($inscriptions)
// {
//     $result = [];
    
//     foreach ($inscriptions as $inscription) {
//         // CORRECTION : Gérer tous les types d'objets
//         if (is_array($inscription)) {
//             $inscriptionData = $inscription;
//         } elseif (is_object($inscription) && method_exists($inscription, 'toArray')) {
//             // Modèle Eloquent
//             $inscriptionData = $inscription->toArray();
//         } elseif (is_object($inscription)) {
//             // stdClass ou autre objet simple
//             $inscriptionData = json_decode(json_encode($inscription), true);
//         } else {
//             // Type inconnu, passer tel quel
//             $inscriptionData = $inscription;
//         }
        
//         // Récupérer la classe de l'apprenant (MÊME LOGIQUE QUE EXPORTS)
//         $classeInfo = $this->getClasseForInscription($inscriptionData);
        
//         // Ajouter les informations de classe (STRUCTURE UNIFORMISÉE)
//         $inscriptionData['classe_annee'] = $classeInfo;
//         $inscriptionData['niveau_code'] = $classeInfo['classe']['code'] ?? $inscriptionData['niveau']['code'] ?? 'NC';
//         $inscriptionData['classe_code'] = $classeInfo['classe']['code'] ?? 'Non classé';
//         $inscriptionData['classe_libelle'] = $classeInfo['classe']['libelle'] ?? 'Non classé';
        
//         $result[] = $inscriptionData;
//     }
    
//     return $result;
// }

// /**
//  * Récupérer les informations de classe pour une inscription
//  */

// /**
//  * Distribuer les élèves dans des classes selon la logique existante
//  * Version optimisée avec répartition équilibrée
//  */
//         /**
//  * Distribuer les élèves dans des classes selon la MÊME LOGIQUE que les exports
//  */
// private function distribuerParClasses($inscriptions)
// {
//     $groupedByClasse = [];
    
//     // Grouper par classe réelle (comme dans les exports)
//     foreach ($inscriptions as $inscription) {
//         $classeLibelle = $inscription['classe_libelle'] ?? 'Non classé';
        
//         if (!isset($groupedByClasse[$classeLibelle])) {
//             $groupedByClasse[$classeLibelle] = [];
//         }
        
//         $groupedByClasse[$classeLibelle][] = $inscription;
//     }
    
//     // Trier les classes dans le MÊME ORDRE que les exports
//     uksort($groupedByClasse, function($a, $b) {
//         $numA = $this->extractClassNumber($a);
//         $numB = $this->extractClassNumber($b);
        
//         // Ordre décroissant : 6ème avant 5ème (comme exports)
//         if ($numA !== $numB) {
//             return $numB <=> $numA;
//         }
        
//         // Si même niveau, tri alphabétique
//         return strcmp($a, $b);
//     });
    
//     // Trier les élèves par nom puis prénom dans chaque classe (COMME EXPORTS)
//     $result = [];
//     foreach ($groupedByClasse as $classeName => $elevesClasse) {
//         usort($elevesClasse, function($a, $b) {
//             $nomA = $a['apprenant']['nom'] ?? '';
//             $nomB = $b['apprenant']['nom'] ?? '';
//             $prenomA = $a['apprenant']['prenom'] ?? '';
//             $prenomB = $b['apprenant']['prenom'] ?? '';
            
//             if ($nomA === $nomB) {
//                 return strcmp($prenomA, $prenomB);
//             }
//             return strcmp($nomA, $nomB);
//         });
        
//         $result = array_merge($result, $elevesClasse);
//     }
    
//     return $result;
// }

// /**
//  * Extraire le numéro de classe (même méthode que exports)
//  */
// private function extractClassNumber(string $className): int
// {
//     preg_match('/\d+/', $className, $matches);
//     return isset($matches[0]) ? (int)$matches[0] : 99;
// }

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
