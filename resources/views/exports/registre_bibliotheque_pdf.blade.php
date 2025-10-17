<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registre de Bibliothèque</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .logo { max-width: 100px; max-height: 100px; }
        .table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f5f5f5; font-weight: bold; }
        .signature-cell { height: 50px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        @if($includeLogo && $etablissement->logo)
            <img src="{{ public_path('storage/' . $etablissement->logo) }}" class="logo">
        @endif
        <h2>{{ $etablissement->name }}</h2>
        <h3>REGISTRE DE BIBLIOTHÈQUE</h3>
        <p>Période du {{ date('d/m/Y', strtotime($dateDebut)) }} au {{ date('d/m/Y', strtotime($dateFin)) }}</p>
    </div>

    @foreach($donneesBibliotheque as $index => $donnee)
        <div class="section">
            <h4>Élève: {{ $donnee['apprenant']['nom'] }} {{ $donnee['apprenant']['prenom'] }} - Classe: {{ $donnee['classe'] }}</h4>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom du Document</th>
                        <th>Date de Prise</th>
                        <th>Date de Retour Prévue</th>
                        @if($includeSignature)
                        <th>Signature</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($donnee['documents'] as $document)
                    <tr>
                        <td>{{ $document['nom_document'] }}</td>
                        <td>{{ $document['date_prise'] }}</td>
                        <td>{{ $document['date_retour'] }}</td>
                        @if($includeSignature)
                        <td class="signature-cell">{{ $document['signature'] }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if(($index + 1) % 3 == 0)
            <div class="page-break"></div>
        @endif
    @endforeach

    <div class="footer">
        <p>Généré le {{ $dateGeneration }}</p>
    </div>
</body>
</html>