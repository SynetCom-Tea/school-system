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
            // Vérifier que $seances n'est pas vide
            if (empty($seances)) {
                return ['occurrences' => $occurrences, 'events' => $events];
            }
            
            $startDateTime = new DateTime($startDate);
            $endDateTime = new DateTime($endDate);
            $currentDate = clone $startDateTime;

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
                $dayOfWeek = $currentDate->format('l');
                $dayOfWeekFrench = translateDayToFrench($dayOfWeek);

                if (isset($occurrences[$dayOfWeekFrench])) {
                    $occurrences[$dayOfWeekFrench]['occurrences']++;

                    foreach ($seances as $seance) {
                        // CORRECTION : Vérification robuste des données
                        $seanceArray = is_object($seance) ? $seance->toArray() : $seance;
                        
                        // Vérifier que la séance a les clés nécessaires
                        if (!isset($seanceArray['jour']) || !isset($seanceArray['heure_debut']) || !isset($seanceArray['heure_fin'])) {
                            continue; // Passer à la séance suivante
                        }
                        
                        if ($seanceArray['jour'] === $dayOfWeekFrench) {
                            $dateSeance = clone $currentDate;
                            
                            $heureDebut = substr($seanceArray['heure_debut'] ?? '', 0, 5);
                            $heureFin = substr($seanceArray['heure_fin'] ?? '', 0, 5);
                            
                            $event = [
                                'title' => ($seanceArray['nom_matiere'] ?? 'Matière') . ', Salle de classe',
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