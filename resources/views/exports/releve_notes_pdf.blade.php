<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relevé de Notes</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .logo { max-width: 100px; max-height: 100px; }
        .student-info { margin: 15px 0; }
        .table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        .table th { background-color: #f5f5f5; font-weight: bold; }
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
        <h3>RELEVÉ DE NOTES</h3>
    </div>

    @foreach($donneesAvecNotes as $index => $donnee)
        <div class="student-info">
            <h4>Élève: {{ $donnee['inscription']['apprenant']['nom'] }} {{ $donnee['inscription']['apprenant']['prenom'] }}</h4>
            <p>Classe: {{ $donnee['inscription']['classe_annee']['classe']['libelle'] ?? 'Non classé' }}</p>
            <p>Année Scolaire: {{ $donnee['inscription']['annee']['libelle'] ?? '2024/2025' }}</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Coefficient</th>
                    <th>Note/20</th>
                    <th>Observation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donnee['notes'] as $note)
                <tr>
                    <td>{{ $note->matiere }}</td>
                    <td>{{ $note->coefficient }}</td>
                    <td>{{ $note->note }}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <strong>Moyenne Générale: {{ $donnee['moyenne_generale'] }}/20</strong>
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