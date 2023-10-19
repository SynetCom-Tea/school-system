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
        function getClasses($anneeScolaireId, $sectionEtablissement) {
            // Récupérer les niveaux pour toutes les sections
            $classeAnnees = ClasseAnnee::where('annee_id', $anneeScolaireId)->pluck('classe_id');
            $classes = Classe::whereIn('id', $classeAnnees)->whereIn('etablissement_section_id', $sectionEtablissement)->get();
    
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