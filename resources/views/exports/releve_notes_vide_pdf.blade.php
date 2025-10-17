<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relevé de Notes Vide</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .logo { max-width: 100px; max-height: 100px; }
        .student-info { margin: 15px 0; }
        .table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        .table th { background-color: #f5f5f5; font-weight: bold; }
        .empty-cell { height: 25px; }
        .summary { margin-top: 15px; padding: 10px; background-color: #f9f9f9; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        @if($includeLogo && $etablissement->logo)
            <img src="{{ public_path('storage/' . $etablissement->logo) }}" class="logo">
        @endif
        <h2>{{ $etablissement->name }}</h2>
        <h3>RELEVÉ DE NOTES - MODÈLE VIDE</h3>
    </div>

    @foreach($inscriptions as $index => $inscription)
        <div class="student-info">
            <h4>Élève: {{ $inscription['apprenant']['nom'] }} {{ $inscription['apprenant']['prenom'] }}</h4>
            <p>Classe: {{ $inscription['classe_annee']['classe']['libelle'] ?? 'Non classé' }}</p>
            <p>Année Scolaire: {{ $inscription['annee']['libelle'] ?? '2024/2025' }}</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Coefficient</th>
                    <th>Interrogations</th>
                    <th>Moyenne Int.</th>
                    <th>Devoir/Composition</th>
                    <th>Moyenne/20</th>
                    <th>Observation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matieres as $matiere)
                <tr>
                    <td>{{ $matiere }}</td>
                    <td></td>
                    <td>
                        <table style="width: 100%; border: none;">
                            <tr>
                                <td style="border: none;"></td>
                                <td style="border: none;"></td>
                                <td style="border: none;"></td>
                                <td style="border: none;"></td>
                                <td style="border: none;"></td>
                                <td style="border: none;"></td>
                            </tr>
                        </table>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <strong>Moyenne Générale: ________/20</strong>
        </div>

        @if(($index + 1) % 2 == 0)
            <div class="page-break"></div>
        @endif
    @endforeach

    <div class="footer">
        <p>Généré le {{ $dateGeneration }}</p>
    </div>
</body>
</html>