<?php


/**
 * Write code on Method
 *
 * @return response()
 */


 if (!function_exists('assignRang')) {
    function assignRang($detailsNotes) {
        $totalMoyenne = 0;
        foreach ($detailsNotes as $details) {
            $totalMoyenne += $details['moyenne'];
        }
        $averageMoyenneDetailsNotes = count($detailsNotes) > 0 ? number_format($totalMoyenne / count($detailsNotes), 2) : 0;
        return $averageMoyenneDetailsNotes;
    }
}