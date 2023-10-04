<?php


/**
 * Write code on Method
 *
 * @return response()
 */

use App\Models\Classe;
use App\Models\ClasseAnnee;
use Illuminate\Support\Facades\DB;

    if (!function_exists('getClasses')) {
        function getClasses($anneeScolaireId, $etablissementId, $sectionId) {
            // Récupérer les niveaux pour toutes les sections
            $sectionEtablissement = DB::table('etablissement_section')
                ->where('etablissement_id', $etablissementId)
                ->where('section_id', $sectionId)
                ->pluck('id');
            $classeAnnees = ClasseAnnee::where('annee_id', $anneeScolaireId)->pluck('classe_id');
            $classes = Classe::whereIn('id', $classeAnnees)->whereIn('etablissement_section_id', $sectionEtablissement)->get();
    
            return $classes;
        }
    }