<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registre de Bibliothèque</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px; 
            margin: 0;
            padding: 15px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px; 
            border-bottom: 2px solid #333; 
            padding-bottom: 15px;
        }
        .logo { 
            max-width: 80px; 
            max-height: 80px;
        }
        .instructions {
            background-color: #fff8e1;
            border: 1px solid #ffd54f;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            font-size: 11px;
        }
        .empty-section {
            margin: 20px 0;
            page-break-inside: avoid;
        }
        .empty-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 10px 0;
            font-size: 11px;
        }
        .empty-table th, .empty-table td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left;
            height: 35px;
        }
        .empty-table th { 
            background-color: #f5f5f5; 
            font-weight: bold;
            text-align: center;
        }
        .student-info {
            background-color: #e8f4ff;
            padding: 8px 12px;
            margin-bottom: 5px;
            border-radius: 4px;
            font-weight: bold;
        }
        .page-break { 
            page-break-after: always;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        @if($includeLogo && isset($etablissement->logo) && !empty($etablissement->logo))
            <img class="logo" src="{{ public_path('logos/' . $etablissement->logo) }}" alt="Logo établissement">
        @elseif($includeLogo)
            <img class="logo" src="{{ public_path('logos/iat-logo.png') }}" alt="Logo par défaut">
        @endif
        <h2 style="margin: 5px 0;">{{ $etablissement->name ?? 'ÉTABLISSEMENT SCOLAIRE' }}</h2>
        <h3 style="margin: 5px 0; color: #3c80e7;">REGISTRE DE BIBLIOTHÈQUE</h3>
        <p style="margin: 5px 0;">Année Scolaire {{ date('Y') }}-{{ date('Y')+1 }}</p>
    </div>

    <div class="instructions">
        <strong>Instructions :</strong> Ce registre est à remplir manuellement pour le suivi des prêts de documents. 
        Inscrire le nom du document, les dates de prêt et de retour prévue, et faire signer l'emprunteur.
    </div>

    @if(isset($inscriptions) && count($inscriptions) > 0)
        @foreach($inscriptions as $index => $inscription)
            <div class="empty-section">
                <div class="student-info">
                    Élève: <strong>{{ $inscription['apprenant']['nom'] }} {{ $inscription['apprenant']['prenom'] }}</strong> 
                    | Classe: {{ $inscription['classe_annee']['classe']['libelle'] ?? 'Non classé' }} 
                    | Matricule: {{ $inscription['apprenant']['matricule'] ?? 'N/A' }}
                </div>
                
                <table class="empty-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">N°</th>
                            <th style="width: 30%;">Nom du Document</th>
                            <th style="width: 15%;">Date de Prise</th>
                            <th style="width: 15%;">Date de Retour Prévue</th>
                            <th style="width: 10%;">Date de Retour Effective</th>
                            <th style="width: 10%;">État</th>
                            @if($includeSignature)
                            <th style="width: 15%;">Signature Emprunteur</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 8; $i++)
                        <tr>
                            <td style="text-align: center;">{{ $i }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: center;"></td>
                            @if($includeSignature)
                            <td></td>
                            @endif
                        </tr>
                        @endfor
                    </tbody>
                </table>
                
                <div style="margin-top: 10px; font-size: 10px; text-align: right;">
                    <em>Lignes 1 à 8 - Page {{ ceil(($index + 1) / 2) }}</em>
                </div>
            </div>
            
            @if(($index + 1) % 2 == 0 && ($index + 1) < count($inscriptions))
                <div class="page-break"></div>
            @endif
        @endforeach
    @else
        <div style="text-align: center; padding: 20px; color: #666;">
            <p>Aucune inscription trouvée pour la génération du registre de bibliothèque.</p>
        </div>
    @endif

    <div class="footer">
        <p>Registre généré le {{ $dateGeneration }} | {{ $etablissement->name ?? 'Établissement Scolaire' }}</p>
        <p>Service Bibliothèque</p>
    </div>
</body>
</html>