<?php


/**
 * Write code on Method
 *
 * @return response()
 */

if (!function_exists('generationCalendar')) {
    function generationCalendar($startDate, $endDate, $seances) {
        $occurrences = [
            'Dimanche' => ['occurrences' => 0, 'seances' => [], 'date_debut' => null],
            'Lundi' => ['occurrences' => 0, 'seances' => [], 'date_debut' => null],
            'Mardi' => ['occurrences' => 0, 'seances' => [], 'date_debut' => null],
            'Mercredi' => ['occurrences' => 0, 'seances' => [], 'date_debut' => null],
            'Jeudi' => ['occurrences' => 0, 'seances' => [], 'date_debut' => null],
            'Vendredi' => ['occurrences' => 0, 'seances' => [], 'date_debut' => null],
            'Samedi' => ['occurrences' => 0, 'seances' => [], 'date_debut' => null]
        ];
        
        $events = [];
        
        try {
            $startDateTime = new DateTime($startDate);
            $endDateTime = new DateTime($endDate);
            $currentDate = clone $startDateTime;

            // Premièrement, créer un mapping des jours de la semaine
            $daysMapping = [
                'Lundi' => 'Monday',
                'Mardi' => 'Tuesday', 
                'Mercredi' => 'Wednesday',
                'Jeudi' => 'Thursday',
                'Vendredi' => 'Friday',
                'Samedi' => 'Saturday',
                'Dimanche' => 'Sunday'
            ];

            while ($currentDate <= $endDateTime) {
                $dayOfWeek = $currentDate->format('l'); // Jour en anglais
                $dayOfWeekFrench = translateDayToFrench($dayOfWeek);

                if (isset($occurrences[$dayOfWeekFrench])) {
                    $occurrences[$dayOfWeekFrench]['occurrences']++;

                    foreach ($seances as $seance) {
                        // Convertir l'objet en tableau si nécessaire
                        $seanceArray = is_object($seance) ? $seance->toArray() : $seance;
                        
                        if ($seanceArray['jour'] === $dayOfWeekFrench) {
                            // Utiliser la date courante plutôt qu'un calcul basé sur $key
                            $dateSeance = clone $currentDate;
                            
                            // Générer l'événement
                            $heureDebut = substr($seanceArray['heure_debut'], 0, 5);
                            $heureFin = substr($seanceArray['heure_fin'], 0, 5);
                            
                            $event = [
                                'title' => $seanceArray['nom_matiere'] . ', Salle de classe',
                                'with' => ($seanceArray['enseignant_nom'] ?? '') . ' ' . ($seanceArray['enseignant_prenom'] ?? ''),
                                'time' => [
                                    'start' => $dateSeance->format('Y-m-d') . ' ' . $heureDebut,
                                    'end' => $dateSeance->format('Y-m-d') . ' ' . $heureFin
                                ],
                                'color' => "green",
                                'colorScheme' => "meetings",
                                'isEditable' => true,
                                'id' => uniqid(),
                            ];
                            
                            $events[] = $event;
                            
                            // Ajouter à occurrences
                            $seanceWithDate = $seanceArray;
                            $seanceWithDate['date_seance'] = $dateSeance->format('Y-m-d');
                            $occurrences[$dayOfWeekFrench]['seances'][] = $seanceWithDate;

                            if ($occurrences[$dayOfWeekFrench]['date_debut'] === null) {
                                $occurrences[$dayOfWeekFrench]['date_debut'] = $currentDate->format('Y-m-d');
                            }
                        }
                    }
                }
                
                $currentDate->modify('+1 day');
            }
        } catch (Exception $e) {
            error_log("Erreur dans generationCalendar: " . $e->getMessage());
        }

        return ['occurrences' => $occurrences, 'events' => $events];
    }
}