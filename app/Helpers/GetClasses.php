<?php


/**
 * Write code on Method
 *
 * @return response()
 */

use App\Models\Classe;
use App\Models\ClasseAnnee;
use Illuminate\Support\Facades\DB;
use Modules\Enseignement\Entities\Matiere;

    if (!function_exists('getClasses')) {
        function getClasses($anneeScolaireId, $sectionEtablissement, $classe = null) {
            $query = Classe::join('classe_annees', 'classes.id', '=', 'classe_annees.classe_id')
                ->whereIn('classe_annees.annee_id', [$anneeScolaireId])
                ->whereIn('classes.etablissement_section_id', $sectionEtablissement);

            // Add condition if $classe is not null
            if ($classe !== null) {
                $query->where('classe_annees.id', $classe);
            }

            $classes = $query->get();
            return $classes;
        }
    }


    if (!function_exists('getSectionEtablissement')) {
        function getSectionEtablissement($etablissementId, $sectionId) {
            // Récupérer les matieres pour toutes les sections
            $sectionEtablissement = DB::table('etablissement_section')
                ->where('etablissement_id', $etablissementId)
                ->where('section_id', $sectionId)
                ->pluck('id');
            // dd($etablissementId, $sectionId, $sectionEtablissement);
            return $sectionEtablissement;
        }
    }

    if (!function_exists('getMatieres')) {
        function getMatieres($sectionEtablissement) {
            // Récupérer les matieres pour toutes les sections
            $matieres = Matiere::whereIn('etablissement_section_id', $sectionEtablissement)->get();
            return $matieres;
        }
    }

    if (!function_exists('getNiveauxMatieres')) {
        function getNiveauxMatieres($matieres, $niveaux) {
            // Récupérer les niveaux pour toutes les sections
            
                $niveauMatiere = DB::table('niveau_matieres')
                    ->whereIn('niveau_id', $niveaux)
                    ->whereIn('matiere_id', $matieres)
                    ->get();
    
            return $niveauMatiere;
        }
    }