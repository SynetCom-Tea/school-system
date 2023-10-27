
<?php

use App\Models\Annee;
use Illuminate\Support\Facades\DB;

if (!function_exists('getAnneeEncours')) {
    function getAnneeEncours() {
        // Récupérer L'année encours
        $annee = Annee::getAnneeEnCours();
        return $annee;
    }
}