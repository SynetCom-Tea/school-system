<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11pt; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5pt; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20pt; }
        .header h1 { margin-bottom: 5pt; }
        .header h2 { margin-top: 0; margin-bottom: 5pt; }
        .footer { margin-top: 30pt; text-align: right; font-size: 10pt; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $etablissement->name }}</h1>
        <h2>{{ $title }}</h2>
        <p>Date d'édition: {{ $date }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Nom & Prénom</th>
                <th>Date/Lieu Naissance</th>
                <th>Sexe</th>
                <th>Niveau/Classe</th>
                <th>Date inscription</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscriptions as $inscription)
            <tr>
                @if(isset($inscription['apprenant']))
                    <td>{{ $inscription['apprenant']['matricule'] ?? 'N/A' }}</td>
                    <td>{{ $inscription['apprenant']['nom'] ?? '' }} {{ $inscription['apprenant']['prenom'] ?? '' }}</td>
                    <td>{{ $inscription['apprenant']['date_naissance'] ?? '' }} à {{ $inscription['apprenant']['lieu_naissance'] ?? '' }}</td>
                    <td>{{ $inscription['apprenant']['sexe'] ?? '' }}</td>
                    
                    @if(isset($inscription['classe_annee']))
                        <td>{{ $inscription['classe_annee']['classe']['niveau']['libelle'] ?? '' }} / {{ $inscription['classe_annee']['classe']['libelle'] ?? '' }}</td>
                    @else
                        <td>{{ $inscription['niveau']['libelle'] ?? '' }} / {{ $inscription['cycle_filiere']['filiere']['name'] ?? '' }}</td>
                    @endif
                    
                    <td>{{ $inscription['date_inscription'] ?? ($inscription['created_at'] ? date('d/m/Y', strtotime($inscription['created_at'])) : 'N/A') }}</td>
                    <td>
                        @if(($inscription['statut'] ?? 0) == 0) En attente
                        @elseif(($inscription['statut'] ?? 0) == 1) Validé
                        @elseif(($inscription['statut'] ?? 0) == 2) Rejeté
                        @else Inconnu @endif
                    </td>
                @else
                    <td colspan="7">Données d'inscription incomplètes</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Généré le {{ date('d/m/Y à H:i') }} | Total: {{ count($inscriptions) }} inscription(s)</p>
    </div>
</body>
</html>