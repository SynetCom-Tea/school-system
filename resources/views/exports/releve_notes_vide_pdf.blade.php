<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relevé de Notes - Modèle par Classe</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 10px; 
            margin: 0;
            padding: 10px;
            background: #fafafa;
        }
        .header { 
            text-align: center; 
            margin-bottom: 15px; 
            border-bottom: 3px solid #3c80e7; 
            padding-bottom: 10px;
            background: white;
            padding: 12px;
            border-radius: 6px;
        }
        .logo { 
            max-width: 70px; 
            max-height: 70px;
            margin-bottom: 8px;
        }
        .classe-section {
            background: white;
            border: 2px solid #3c80e7;
            border-radius: 6px;
            margin: 15px 0;
            page-break-inside: avoid;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .classe-header {
            background: linear-gradient(135deg, #3c80e7, #2c6cc4);
            color: white;
            padding: 10px 15px;
            border-radius: 4px 4px 0 0;
            text-align: center;
        }
        .classe-title {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }
        .matiere-section {
            margin: 10px;
            padding: 8px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            background: #f8f9fa;
        }
        .matiere-title {
            background: #495057;
            color: white;
            padding: 6px 10px;
            margin: -8px -8px 8px -8px;
            border-radius: 3px 3px 0 0;
            font-weight: bold;
            font-size: 11px;
        }
        .notes-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 8px;
        }
        .notes-table th {
            background: #6c757d;
            color: white;
            padding: 6px 3px;
            border: 1px solid #dee2e6;
            font-weight: bold;
            text-align: center;
        }
        .notes-table td {
            padding: 4px 3px;
            border: 1px solid #dee2e6;
            text-align: center;
            background: white;
        }
        .student-name {
            text-align: left;
            padding-left: 6px !important;
            font-weight: 500;
        }
        .interrogations-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 1px;
            padding: 1px;
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
            color: #3c80e7;
        }
        .devoir-cell {
            background: #fff3cd;
        }
        .page-break { 
            page-break-after: always;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 8px;
            color: #6c757d;
            padding-top: 8px;
            border-top: 1px solid #dee2e6;
        }
        .instructions {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 4px;
            padding: 6px 10px;
            margin: 8px 0;
            font-size: 8px;
            text-align: center;
        }
        .empty-data {
            text-align: center;
            padding: 30px;
            color: #6c757d;
            font-style: italic;
            background: #f8f9fa;
            border-radius: 6px;
            margin: 15px 0;
        }
        .professeur-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 5px;
            padding-top: 4px;
            border-top: 1px dashed #dee2e6;
        }
        .signature-line {
            border-top: 1px solid #495057;
            padding-top: 2px;
            text-align: center;
            font-size: 7px;
            color: #6c757d;
            width: 120px;
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
        <h1 style="margin: 3px 0; color: #2c3e50; font-size: 16px;">
            {{ $etablissement->name ?? 'ÉTABLISSEMENT SCOLAIRE' }}
        </h1>
        <h2 style="margin: 2px 0; color: #3c80e7; font-size: 12px;">RELEVÉ DE NOTES - MODÈLE PAR CLASSE</h2>
        <p style="margin: 1px 0; color: #6c757d; font-size: 10px;">Année Scolaire {{ date('Y') }}-{{ date('Y')+1 }}</p>
    </div>

    <div class="instructions">
        <strong>📝 MODÈLE POUR SAISIE MANUELLE - UNE FICHE PAR MATIÈRE ET PAR CLASSE</strong>
    </div>

    @if(empty($classesAvecEleves))
        <div class="empty-data">
            <h3 style="color: #6c757d;">Aucune classe trouvée</h3>
            <p>Aucune inscription disponible pour générer les relevés de notes.</p>
        </div>
    @else
        @foreach($classesAvecEleves as $classeIndex => $classe)
            <div class="classe-section">
                <!-- En-tête de la classe -->
                <div class="classe-header">
                    <h2 class="classe-title">CLASSE : {{ $classe['libelle'] }}</h2>
                </div>

                <!-- Pour chaque matière, créer une section -->
                @foreach($matieres as $matiereIndex => $matiere)
                    <div class="matiere-section">
                        <div class="matiere-title">
                            📚 MATIÈRE : {{ $matiere }}
                        </div>

                        <!-- Tableau des notes pour cette matière -->
                        <table class="notes-table">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">N°</th>
                                    <th style="width: 25%;">Nom et Prénom de l'Élève</th>
                                    <th style="width: 6%;">Coef.</th>
                                    <th style="width: 35%;">Interrogations (note / 20)</th>
                                    <th style="width: 8%;">Moy. Int.</th>
                                    <th style="width: 10%;">Dev/Comp</th>
                                    <th style="width: 11%;">Moy/20</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classe['eleves'] as $eleveIndex => $eleve)
                                <tr>
                                    <!-- Numéro -->
                                    <td style="font-weight: bold;">{{ $eleveIndex + 1 }}</td>
                                    
                                    <!-- Nom et Prénom -->
                                    <td class="student-name">
                                        {{ $eleve['apprenant']['nom'] ?? '' }} 
                                        {{ $eleve['apprenant']['prenom'] ?? '' }}
                                    </td>
                                    
                                    <!-- Coefficient -->
                                    <td class="coefficient-cell">
                                        ____
                                    </td>
                                    
                                    <!-- Interrogations (6 cases) -->
                                    <td>
                                        <div class="interrogations-grid">
                                            @for($i = 1; $i <= 6; $i++)
                                            <div class="interro-cell" title="Interro {{ $i }}"></div>
                                            @endfor
                                        </div>
                                    </td>
                                    
                                    <!-- Moyenne Interros -->
                                    <td style="background: #f8f9fa; font-weight: bold;">
                                        ___
                                    </td>
                                    
                                    <!-- Devoir/Composition -->
                                    <td class="devoir-cell">
                                        ___
                                    </td>
                                    
                                    <!-- Moyenne/20 -->
                                    <td class="moyenne-cell">
                                        ___
                                    </td>
                                </tr>
                                @endforeach
                                
                                <!-- Lignes vides supplémentaires pour nouveaux élèves -->
                                @for($i = count($classe['eleves']); $i < 5; $i++)
                                <tr>
                                    <td style="font-weight: bold;">{{ $i + 1 }}</td>
                                    <td class="student-name">_________________________</td>
                                    <td class="coefficient-cell">____</td>
                                    <td>
                                        <div class="interrogations-grid">
                                            @for($j = 1; $j <= 6; $j++)
                                            <div class="interro-cell"></div>
                                            @endfor
                                        </div>
                                    </td>
                                    <td style="background: #f8f9fa;">___</td>
                                    <td class="devoir-cell">___</td>
                                    <td class="moyenne-cell">___</td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>

                        <!-- Section professeur et signatures -->
                        <div class="professeur-line">
                            <div>
                                <strong>Professeur :</strong> _________________________
                            </div>
                            <div>
                                <div class="signature-line">
                                    Signature du Professeur
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Saut de page après 3 matières ou à la fin de la classe -->
                    @if(($matiereIndex + 1) % 3 == 0 && ($matiereIndex + 1) < count($matieres))
                        <div class="page-break"></div>
                        <div style="text-align: center; margin-bottom: 10px;">
                            <strong>Suite - {{ $classe['libelle'] }} - Page {{ ceil(($matiereIndex + 1) / 3) + 1 }}</strong>
                        </div>
                    @endif
                @endforeach

                <!-- Signature du chef de classe en bas de la fiche de classe -->
                <div style="text-align: center; margin: 15px 0; padding-top: 10px; border-top: 2px solid #3c80e7;">
                    <div style="display: inline-block; margin: 0 20px;">
                        <div class="signature-line">Le Professeur Principal</div>
                    </div>
                    <div style="display: inline-block; margin: 0 20px;">
                        <div class="signature-line">Le Censeur</div>
                    </div>
                    <div style="display: inline-block; margin: 0 20px;">
                        <div class="signature-line">Le Chef d'Établissement</div>
                    </div>
                </div>
            </div>

            <!-- Saut de page après chaque classe -->
            @if(($classeIndex + 1) < count($classesAvecEleves))
                <div class="page-break"></div>
            @endif
        @endforeach
    @endif

    <div class="footer">
        <p><strong>{{ $etablissement->name ?? 'Établissement Scolaire' }}</strong> - Direction des Études</p>
        <p>Modèle par classe généré le {{ $dateGeneration }} | Document confidentiel</p>
    </div>
</body>
</html>