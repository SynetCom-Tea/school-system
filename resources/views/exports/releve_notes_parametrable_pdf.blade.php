<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relevé de Notes - Sélection Personnalisée</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 10px; 
            margin: 0;
            padding: 15px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px; 
            border-bottom: 3px solid #3c80e7; 
            padding-bottom: 15px;
        }
        .logo { 
            max-width: 80px; 
            max-height: 80px;
            margin-bottom: 10px;
        }
        .classe-section {
            background: white;
            border: 2px solid #3c80e7;
            border-radius: 8px;
            margin: 20px 0;
            page-break-inside: avoid;
        }
        .classe-header {
            background: linear-gradient(135deg, #3c80e7, #2c6cc4);
            color: white;
            padding: 15px;
            border-radius: 6px 6px 0 0;
            text-align: center;
        }
        .matiere-section {
            margin: 15px;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background: #f8f9fa;
        }
        .matiere-title {
            background: #495057;
            color: white;
            padding: 10px 15px;
            margin: -12px -12px 12px -12px;
            border-radius: 4px 4px 0 0;
            font-weight: bold;
            font-size: 14px;
        }
        .notes-table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
            font-size: 9px;
        }
        .notes-table th {
            background: #6c757d;
            color: white;
            padding: 8px 4px;
            border: 1px solid #dee2e6;
            font-weight: bold;
            text-align: center;
        }
        .notes-table td {
            padding: 6px 4px;
            border: 1px solid #dee2e6;
            text-align: center;
        }
        .student-name {
            text-align: left;
            padding-left: 8px !important;
            font-weight: 500;
        }
        .interrogations-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2px;
            padding: 2px;
        }
        .interro-cell {
            border: 1px solid #adb5bd;
            height: 16px;
            background: white;
        }
        .coefficient-cell {
            background: #e9ecef;
            font-weight: bold;
        }
        .moyenne-cell {
            background: #e8f4ff;
            font-weight: bold;
        }
        .devoir-cell {
            background: #fff3cd;
        }
        .composition-cell {
            background: #ffeaa7;
        }
        .page-break { 
            page-break-after: always;
        }
        .signature-area {
            margin-top: 30px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #000;
            display: inline-block;
            width: 180px;
            margin: 0 15px;
            padding-top: 4px;
            text-align: center;
            font-size: 9px;
        }
        .professeur-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px dashed #dee2e6;
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
        <h1 style="margin: 5px 0; color: #2c3e50;">{{ $etablissement->name ?? 'ÉTABLISSEMENT SCOLAIRE' }}</h1>
        <h2 style="margin: 3px 0; color: #3c80e7;">RELEVÉ DE NOTES - SÉLECTION PERSONNALISÉE</h2>
        <p style="margin: 2px 0; color: #6c757d;">Année Scolaire {{ date('Y') }}-{{ date('Y')+1 }}</p>
    </div>

    @if(empty($classesAvecEleves))
        <div style="text-align: center; padding: 50px; color: #6c757d;">
            <h3>Aucune donnée disponible</h3>
            <p>Aucune inscription trouvée pour les paramètres sélectionnés.</p>
        </div>
    @else
        @foreach($classesAvecEleves as $classeIndex => $classe)
            <div class="classe-section">
                <div class="classe-header">
                    <h2 style="margin: 0; font-size: 16px;">CLASSE : {{ $classe['libelle'] }}</h2>
                </div>

                @foreach($matieres as $matiereIndex => $matiere)
                    <div class="matiere-section">
                        <div class="matiere-title">
                            📚 MATIÈRE : {{ $matiere }}
                        </div>

                        <table class="notes-table">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">N°</th>
                                    <th style="width: 25%;">Nom et Prénom</th>
                                    <th style="width: 5%;">Coef.</th>
                                    <th style="width: 20%;">Interrogations /20</th>
                                    <th style="width: 8%;">Moy. Int.</th>
                                    <th style="width: 8%;">Devoir /20</th>
                                    <th style="width: 8%;">Comp. /20</th>
                                    <th style="width: 8%;">Moy. /20</th>
                                    <th style="width: 13%;">Observation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classe['eleves'] as $index => $eleve)
                                <tr>
                                    <td style="font-weight: bold;">{{ $index + 1 }}</td>
                                    <td class="student-name">
                                        {{ $eleve['apprenant']['nom'] ?? '' }} 
                                        {{ $eleve['apprenant']['prenom'] ?? '' }}
                                    </td>
                                    <td class="coefficient-cell">___</td>
                                    <td>
                                        <div class="interrogations-grid">
                                            @for($i = 1; $i <= 4; $i++)
                                            <div class="interro-cell"></div>
                                            @endfor
                                        </div>
                                    </td>
                                    <td style="background: #f8f9fa;">___</td>
                                    <td class="devoir-cell">___</td>
                                    <td class="composition-cell">___</td>
                                    <td class="moyenne-cell">___</td>
                                    <td style="text-align: left; padding-left: 4px;">_______</td>
                                </tr>
                                @endforeach
                                
                                @for($i = count($classe['eleves']); $i < 8; $i++)
                                <tr>
                                    <td style="font-weight: bold;">{{ $i + 1 }}</td>
                                    <td class="student-name">___________________</td>
                                    <td class="coefficient-cell">___</td>
                                    <td>
                                        <div class="interrogations-grid">
                                            @for($j = 1; $j <= 4; $j++)
                                            <div class="interro-cell"></div>
                                            @endfor
                                        </div>
                                    </td>
                                    <td style="background: #f8f9fa;">___</td>
                                    <td class="devoir-cell">___</td>
                                    <td class="composition-cell">___</td>
                                    <td class="moyenne-cell">___</td>
                                    <td style="text-align: left; padding-left: 4px;">_______</td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>

                        <div class="professeur-line">
                            <div>
                                <strong>Professeur :</strong> _________________________
                            </div>
                            <div>
                                <div class="signature-line" style="width: 120px;">
                                    Signature
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(($matiereIndex + 1) % 2 == 0 && ($matiereIndex + 1) < count($matieres))
                        <div class="page-break"></div>
                    @endif
                @endforeach

                <div class="signature-area">
                    <div class="signature-line">Le Professeur Principal</div>
                    <div class="signature-line">Le Censeur</div>
                    <div class="signature-line">Le Chef d'Établissement</div>
                </div>
            </div>

            @if(($classeIndex + 1) < count($classesAvecEleves))
                <div class="page-break"></div>
            @endif
        @endforeach
    @endif
</body>
</html>