<?php


/**
 * Write code on Method
 *
 * @return response()
 */

    if (!function_exists('countWeekdayOccurrences')) {
        function countWeekdayOccurrences($startDate, $endDate, $seances) {
            $occurrences = array(
                'Dimanche' => ['occurrences' => 0, 'seances' => [], 'dateStart' => null],
                'Lundi' => ['occurrences' => 0, 'seances' => [], 'dateStart' => null],
                'Mardi' => ['occurrences' => 0, 'seances' => [], 'dateStart' => null],
                'Mercredi' => ['occurrences' => 0, 'seances' => [], 'dateStart' => null],
                'Jeudi' => ['occurrences' => 0, 'seances' => [], 'dateStart' => null],
                'Vendredi' => ['occurrences' => 0, 'seances' => [], 'dateStart' => null],
                'Samedi' => ['occurrences' => 0, 'seances' => [], 'dateStart' => null]
            );

            $startDateTime = new DateTime($startDate);
            $endDateTime = new DateTime($endDate);

            $currentDate = $startDateTime;
            while ($currentDate <= $endDateTime) {
                $dayOfWeek = $currentDate->format('l');
                $dayOfWeekFrench = translateDayToFrench($dayOfWeek);
        
                // Incrémenter le compteur pour ce jour de la semaine
                $occurrences[$dayOfWeekFrench]['occurrences']++;
                $occurrences[$dayOfWeekFrench]['dateStart'] = $startDateTime;
                // Ajouter les séances pour ce jour de la semaine
                if (isset($seances[$dayOfWeekFrench])) {
                    $occurrences[$dayOfWeekFrench]['seances'] = $seances[$dayOfWeekFrench];
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