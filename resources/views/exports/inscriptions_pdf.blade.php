<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 15px; }
        .school-name { font-size: 16px; font-weight: bold; }
        .report-title { font-size: 14px; margin: 8px 0; font-weight: bold; }
        .classe-header { 
            background-color: #2c3e50; 
            color: white; 
            padding: 8px; 
            margin: 12px 0 8px 0; 
            font-weight: bold; 
            border-radius: 4px;
        }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        th, td { border: 1px solid #bdc3c7; padding: 5px; text-align: left; }
        th { 
            background-color: #ecf0f1; 
            font-weight: bold; 
            font-size: 10px;
        }
        .footer { 
            margin-top: 20px; 
            text-align: center; 
            font-size: 10px; 
            color: #7f8c8d;
        }
        .montant-restant { 
            font-weight: bold; 
            color: #e74c3c;
        }
        .montant-paye { 
            color: #27ae60;
        }
        .statut-valide { color: #27ae60; font-weight: bold; }
        .statut-attente { color: #f39c12; font-weight: bold; }
        .statut-rejete { color: #e74c3c; font-weight: bold; }
        .page-break { page-break-after: always; }
        .resume-classe {
            font-size: 10px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name">{{ $etablissement->name ?? 'Établissement' }}</div>
        <div class="report-title">{{ $title }}</div>
        <div>Date d'édition: {{ $date }}</div>
    </div>

    @php 
        $totalGeneral = 0;
        $totalMontantRestant = 0;
        
        // Grouper par classe
        $groupedInscriptions = [];
        foreach ($inscriptions as $inscription) {
            $classeName = $inscription['classe_annee']['classe']['libelle'] ?? 
                         ($inscription['niveau']['libelle'] ?? 'Non classé');
            if (!isset($groupedInscriptions[$classeName])) {
                $groupedInscriptions[$classeName] = [];
            }
            $groupedInscriptions[$classeName][] = $inscription;
        }
        
        // Trier les classes par ordre (6ème, 5ème, etc.)
        uksort($groupedInscriptions, function($a, $b) {
            // Extraire le numéro de classe
            preg_match('/\d+/', $a, $matchesA);
            preg_match('/\d+/', $b, $matchesB);
            
            $numA = isset($matchesA[0]) ? (int)$matchesA[0] : 99;
            $numB = isset($matchesB[0]) ? (int)$matchesB[0] : 99;
            
            // Ordre décroissant : 6ème avant 5ème
            if ($numA !== $numB) {
                return $numB - $numA;
            }
            
            // Si même niveau, tri alphabétique
            return strcmp($a, $b);
        });
    @endphp

    @foreach($groupedInscriptions as $classeName => $classeInscriptions)
        @php
            // Trier les élèves par nom puis prénom
            usort($classeInscriptions, function($a, $b) {
                $nomA = $a['apprenant']['nom'] ?? '';
                $nomB = $b['apprenant']['nom'] ?? '';
                $prenomA = $a['apprenant']['prenom'] ?? '';
                $prenomB = $b['apprenant']['prenom'] ?? '';
                
                if ($nomA === $nomB) {
                    return strcmp($prenomA, $prenomB);
                }
                return strcmp($nomA, $nomB);
            });
            
            $totalClasse = count($classeInscriptions);
            $totalGeneral += $totalClasse;
            
            // Calculer le total des montants restants pour la classe
            $totalRestantClasse = 0;
            foreach ($classeInscriptions as $insc) {
                $totalRestantClasse += $insc['montant_restant'] ?? 0;
            }
            $totalMontantRestant += $totalRestantClasse;
        @endphp
        
        <div class="classe-header">
            Classe: {{ $classeName }} 
            <span class="resume-classe">({{ $totalClasse }} élève(s) - Restant à payer: {{ number_format($totalRestantClasse, 0, ',', ' ') }} FCFA) et Total payé: {{ number_format($totalClasse > 0 ? ($inscriptions->sum('montant_total_frais') - $totalRestantClasse) : 0, 0, ',', ' ') }} FCFA</span>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="10%">Matricule</th>
                    <th width="15%">Nom & Prénom</th>
                    <th width="12%">Date Naissance</th>
                    <th width="8%">Sexe</th>
                    <th width="10%">Date Inscription</th>
                    <th width="8%">Statut</th>
                    <th width="12%">Total Frais</th>
                    <th width="12%">Total Payé</th>
                    <th width="12%">Restant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classeInscriptions as $index => $inscription)
                @php
                    $montantRestant = $inscription['montant_restant'] ?? 0;
                    $montantTotal = $inscription['montant_total_frais'] ?? 0;
                    $montantPaye = $inscription['montant_total_verse'] ?? 0;
                    
                    // Classe CSS pour le statut
                    $statutClass = '';
                    if (($inscription['statut'] ?? 0) == 1) $statutClass = 'statut-valide';
                    elseif (($inscription['statut'] ?? 0) == 0) $statutClass = 'statut-attente';
                    elseif (($inscription['statut'] ?? 0) == 2) $statutClass = 'statut-rejete';
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $inscription['apprenant']['matricule'] ?? 'N/A' }}</td>
                    <td>{{ $inscription['apprenant']['nom'] ?? '' }} {{ $inscription['apprenant']['prenom'] ?? '' }}</td>
                    <td>{{ $inscription['apprenant']['date_naissance'] ?? '' }}</td>
                    <td>{{ $inscription['apprenant']['sexe'] ?? '' }}</td>
                    <td>{{ $inscription['date_inscription'] ?? ($inscription['created_at'] ? date('d/m/Y', strtotime($inscription['created_at'])) : 'N/A') }}</td>
                    <td class="{{ $statutClass }}">
                        @if(($inscription['statut'] ?? 0) == 0) En attente
                        @elseif(($inscription['statut'] ?? 0) == 1) Validé
                        @elseif(($inscription['statut'] ?? 0) == 2) Rejeté
                        @else Inconnu @endif
                    </td>
                    <td>{{ number_format($montantTotal, 0, ',', ' ') }} FCFA</td>
                    <td class="montant-paye">{{ number_format($montantPaye, 0, ',', ' ') }} FCFA</td>
                    <td class="montant-restant">{{ number_format($montantRestant, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div class="footer">
        <p>Généré le {{ date('d/m/Y à H:i') }} | 
           Total: {{ $totalGeneral }} inscription(s) | 
           Total restant à payer: {{ number_format($totalMontantRestant, 0, ',', ' ') }} FCFA
           Total payé: {{ number_format($totalGeneral > 0 ? ($inscriptions->sum('montant_total_frais') - $totalMontantRestant) : 0, 0, ',', ' ') }} FCFA
        </p>
    </div>
</body>
</html>