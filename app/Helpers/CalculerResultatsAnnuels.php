<?php

use App\Models\HistoriqueBulletin;

if (!function_exists('calculerResultatsAnnuels')) {
    /**
     * Calculate annual results (moyenne_annuelle, rang_annuel, etc.) for Semestre II.
     *
     * @param array $resultatsSemestre2
     * @param int $classeId
     * @param string $periodeLibelle
     * @return array
     */
    function calculerResultatsAnnuels($resultatsSemestre2, $classeId, $periodeLibelle)
    {
        if (stripos($periodeLibelle, 'Semestre II') === false) {
            return $resultatsSemestre2;
        }

        $resultsWithAnnual = [];

        foreach ($resultatsSemestre2 as $resultat) {
            $bulletinS1 = HistoriqueBulletin::where('apprenant_id', $resultat['apprenant_id'])
                ->where('classe_annee_id', $classeId)
                ->where('statut', 1)
                ->where(function ($query) {
                    $query->where('periode', 'like', '%Semestre I%');
                })
                ->latest()
                ->first();

            $resultat['moyenne_semestre_1'] = $bulletinS1->moyenne_details_notes ?? null;
            $resultat['moyenne_semestre_2'] = $resultat['moyenne_details_notes'] ?? null;
            $resultat['rang_semestre_1'] = $bulletinS1->rang ?? null;
            $resultat['rang_semestre_2'] = $resultat['rang'] ?? null;

            if ($bulletinS1) {
                $moyenneS1 = (float) $bulletinS1->moyenne_details_notes;
                $moyenneS2 = (float) $resultat['moyenne_details_notes'];
                $resultat['moyenne_annuelle'] = round(($moyenneS1 + $moyenneS2) / 2, 2);
            } else {
                $resultat['moyenne_annuelle'] = null;
            }

            $resultsWithAnnual[] = $resultat;
        }

        $annualAverages = [];

        foreach ($resultsWithAnnual as $resultat) {
            if ($resultat['moyenne_annuelle'] !== null) {
                $annualAverages[$resultat['apprenant_id']] = $resultat['moyenne_annuelle'];
            }
        }

        if (empty($annualAverages)) {
            return $resultsWithAnnual;
        }

        arsort($annualAverages);

        $position = 1;
        $positionsParMoyenne = [];
        $rangsParApprenant = [];

        foreach ($annualAverages as $apprenantId => $moyenne) {
            $moyenneKey = number_format((float) $moyenne, 2, '.', '');

            if (!isset($positionsParMoyenne[$moyenneKey])) {
                $positionsParMoyenne[$moyenneKey] = $position;
                $rangsParApprenant[$apprenantId] = $position . 'e';
            } else {
                $rangsParApprenant[$apprenantId] = $positionsParMoyenne[$moyenneKey] . 'e ex';
            }

            $position++;
        }

        $moyennesAnnuelles = array_values($annualAverages);
        $plusForteMoyenne = max($moyennesAnnuelles);
        $plusFaibleMoyenne = min($moyennesAnnuelles);

        foreach ($resultsWithAnnual as &$resultat) {
            $resultat['rang_annuel'] = $rangsParApprenant[$resultat['apprenant_id']] ?? null;
            $resultat['plus_forte_moyenne_annuelle'] = $plusForteMoyenne;
            $resultat['plus_faible_moyenne_annuelle'] = $plusFaibleMoyenne;
        }
        unset($resultat);

        return $resultsWithAnnual;
    }
}

if (!function_exists('sauvegarderResultatsAnnuels')) {
    /**
     * Save annual results to historique_bulletins.
     *
     * @param HistoriqueBulletin $bulletin
     * @param array $resultat
     * @return void
     */
    function sauvegarderResultatsAnnuels($bulletin, $resultat)
    {
        if (array_key_exists('moyenne_annuelle', $resultat)) {
            $bulletin->update([
                'moyenne_annuelle' => $resultat['moyenne_annuelle'],
                'rang_annuel' => $resultat['rang_annuel'] ?? null,
                'plus_forte_moyenne_annuelle' => $resultat['plus_forte_moyenne_annuelle'] ?? null,
                'plus_faible_moyenne_annuelle' => $resultat['plus_faible_moyenne_annuelle'] ?? null,
                'moyenne_semestre_1' => $resultat['moyenne_semestre_1'] ?? null,
                'moyenne_semestre_2' => $resultat['moyenne_semestre_2'] ?? null,
                'rang_semestre_1' => $resultat['rang_semestre_1'] ?? null,
                'rang_semestre_2' => $resultat['rang_semestre_2'] ?? null,
            ]);
        }
    }
}
