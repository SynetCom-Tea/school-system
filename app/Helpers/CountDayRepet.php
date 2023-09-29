<?php


/**
 * Write code on Method
 *
 * @return response()
 */

    if (!function_exists('countWeekdayOccurrences')) {
        function countWeekdayOccurrences($startDate, $endDate, $seances) {
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
                if (isset($seances[$dayOfWeekFrench])) {
                    $occurrences[$dayOfWeekFrench]['seances'] = $seances[$dayOfWeekFrench];
                    if ($occurrences[$dayOfWeekFrench]['date_debut'] === null) {
                        $occurrences[$dayOfWeekFrench]['date_debut'] = $currentDate->format('Y-m-d');
                    }
                }
        
                // Passer au jour suivant
                $currentDate->modify('+1 day');
            }
        
            return $occurrences;
        }
    }

    if (!function_exists('translateDayToFrench')) {
        function translateDayToFrench($dayOfWeek) {
            $translation = array(
                'Sunday' => 'Dimanche',
                'Monday' => 'Lundi',
                'Tuesday' => 'Mardi',
                'Wednesday' => 'Mercredi',
                'Thursday' => 'Jeudi',
                'Friday' => 'Vendredi',
                'Saturday' => 'Samedi'
            );
    
            return $translation[$dayOfWeek];
        }
    }