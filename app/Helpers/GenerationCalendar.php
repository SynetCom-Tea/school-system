<?php


/**
 * Write code on Method
 *
 * @return response()
 */

 if (!function_exists('generationCalendar')) {
    function generationCalendar($startDate, $endDate, $seances) {
        $occurrences = array(
            'Dimanche' => ['occurrences' => 0, 'seances' => [], 'date_debut' => null],
            'Lundi' => ['occurrences' => 0, 'seances' => [], 'date_debut' => null],
            'Mardi' => ['occurrences' => 0, 'seances' => [], 'date_debut' => null],
            'Mercredi' => ['occurrences' => 0, 'seances' => [], 'date_debut' => null],
            'Jeudi' => ['occurrences' => 0, 'seances' => [], 'date_debut' => null],
            'Vendredi' => ['occurrences' => 0, 'seances' => [], 'date_debut' => null],
            'Samedi' => ['occurrences' => 0, 'seances' => [], 'date_debut' => null]
        );

        $startDateTime = new DateTime($startDate);
        $endDateTime = new DateTime($endDate);

        $currentDate = $startDateTime;
        while ($currentDate <= $endDateTime) {
            $dayOfWeek = $currentDate->format('l');
            $dayOfWeekFrench = translateDayToFrench($dayOfWeek);

            // Incrémenter le compteur pour ce jour de la semaine
            $occurrences[$dayOfWeekFrench]['occurrences']++;

            // Ajouter les séances pour ce jour de la semaine
            foreach ($seances as $key => $seance) {
                if ($seance['jour'] === $dayOfWeekFrench) {
                    $dateSeance = (new DateTime($seance['date_debut']))->add(new DateInterval('P' . ($key * 7) . 'D'));
                    $seance['date_seance'] = $dateSeance->format('Y-m-d');
                    $occurrences[$dayOfWeekFrench]['seances'][] = $seance;

                    // Générer l'événement
                    $heureDebut = substr($seance['heure_debut'], 0, 5);
                    $heureFin = substr($seance['heure_fin'], 0, 5);
                    $event = [
                        'title' => $seance['nom_matiere'] . ', ' . 'Salle de classe',
                        'with' => $seance['enseignant_nom'] . ' ' . $seance['enseignant_prenom'],
                        'time' => [
                            'start' => $seance['date_seance'] . ' ' . $heureDebut,
                            'end' => $seance['date_seance'] . ' ' . $heureFin
                        ],
                        'isEditable' => true,
                        'id' => uniqid(),
                        'colorScheme' => 'meetings',
                    ];
                    $events[] = $event;

                    if ($occurrences[$dayOfWeekFrench]['date_debut'] === null) {
                        $occurrences[$dayOfWeekFrench]['date_debut'] = $currentDate->format('Y-m-d');
                    }
                }
            }
            // Passer au jour suivant
            $currentDate->modify('+1 day');
        }


        return ['occurrences' => $occurrences, 'events' => $events];
    }
}
