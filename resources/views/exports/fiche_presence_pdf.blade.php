<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fiche de Présence - {{ $etablissement->nom ?? 'Établissement' }}</title>
    <style>
        @page {
            margin: 15px;
            @if($periode === 'mois')
                size: A4 landscape;
            @else
                size: A4 portrait;
            @endif
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
            border-bottom: 2px solid #2C3E50;
            padding-bottom: 10px;
        }
        .logo-container {
            flex: 0 0 auto;
            width: 80px;
            text-align: center;
        }
        .logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }
        .school-info {
            flex: 1;
            text-align: center;
            padding: 0 20px;
        }
        .school-name {
            font-size: 18px;
            font-weight: bold;
            color: #2C3E50;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .school-details {
            font-size: 12px;
            color: #666;
        }
        .document-title {
            font-size: 16px;
            font-weight: bold;
            margin: 12px 0;
            text-align: center;
            color: #2C3E50;
            text-transform: uppercase;
            text-decoration: underline;
        }
        .class-info {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #3498DB;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            margin-bottom: 8px;
        }
        .info-item {
            padding: 8px;
            background: white;
            border-radius: 4px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }
        .matieres-item {
            grid-column: 1 / -1;
            padding: 8px;
            background: white;
            border-radius: 4px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            page-break-inside: auto;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
        }
        thead {
            display: table-header-group;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        th {
            background: #34495E;
            color: white;
            padding: 8px 4px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 12px;
            font-weight: bold;
        }
        td {
            padding: 6px 3px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            height: 24px;
        }
        .student-number {
            width: 35px;
        }
        .student-matricule {
            width: 100px;
        }
        .student-name {
            text-align: left;
            padding-left: 8px;
            min-width: 180px;
            font-size: 12px;
        }
        .day-cell {
            width: 20px;
            min-width: 20px;
            max-width: 20px;
        }
        .checkbox {
            font-size: 16px;
            line-height: 1;
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 1px solid #333;
            background: white;
        }
        .total-cell {
            background: #e8f5e8;
            font-weight: bold;
            width: 50px;
            font-size: 12px;
        }
        .signature-cell {
            width: 80px;
            background: #fff9e6;
            font-size: 11px;
        }
        .instructions {
            margin-top: 15px;
            padding: 10px;
            background: #fff9e6;
            border-radius: 4px;
            border-left: 4px solid #f39c12;
            font-size: 12px;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding: 0 25px;
        }
        .signature-box {
            width: 45%;
        }
        .signature-line {
            width: 220px;
            height: 1px;
            background: #333;
            margin: 35px 0 8px 0;
        }
        .signature-left .signature-line {
            margin-left: 0;
        }
        .signature-right .signature-line {
            margin-right: 0;
            margin-left: auto;
        }
        .signature-label {
            font-size: 12px;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        .page-break {
            page-break-after: always;
        }
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        /* Optimisations pour le format paysage (mois) */
        @if($periode === 'mois')
        .student-name {
            min-width: 160px;
            max-width: 160px;
        }
        .day-cell {
            width: 18px;
            min-width: 18px;
            max-width: 18px;
        }
        table {
            font-size: 12px;
        }
        th, td {
            font-size: 12px;
            padding: 5px 2px;
        }
        @endif
    </style>
</head>
<body>
    <!-- Boucle sur chaque classe -->
    @foreach($classes as $classeName => $inscriptions)
        <!-- En-tête avec logo et informations de l'école -->
        <div class="header">
            <div class="logo-container">
                @if($includeLogo && isset($etablissement->logo) && !empty($etablissement->logo))
                    <img class="logo" src="{{ public_path('logos/' . $etablissement->logo) }}" alt="Logo établissement">
                @elseif($includeLogo)
                    <img class="logo" src="{{ public_path('logos/iat-logo.png') }}" alt="Logo par défaut">
                @endif
            </div>
            <div class="school-info">
                <div class="school-name">{{ $etablissement->name ?? 'ÉTABLISSEMENT SCOLAIRE' }}</div>
                <div class="school-details">
                    {{ $etablissement->adresse ?? '' }} 
                    @if(isset($etablissement->telephone) && $etablissement->telephone)
                        • Tél: {{ $etablissement->telephone }}
                    @endif
                    @if(isset($etablissement->email) && $etablissement->email)
                        • Email: {{ $etablissement->email }}
                    @endif
                </div>
            </div>
            <div class="logo-container">
                <!-- Espace pour un éventuel logo à droite -->
            </div>
        </div>

        <!-- Titre du document -->
        <div class="document-title">
            FICHE DE PRÉSENCE - {{ strtoupper($periode) }}
        </div>

        <!-- Informations de la classe -->
        <div class="class-info">
            <div class="info-grid">
                <div class="info-item">
                    <span>Classe: {{ $classeName }}</span>
                </div>
                <div class="info-item">
                    <span>Période: {{ ucfirst($periode) }}</span>
                </div>
                <div class="info-item">
                    <span>Effectif: {{ count($inscriptions) }} élèves</span>
                </div>
                <div class="matieres-item">
                    <span>Année Scolaire: {{ date('Y') . '/' . (date('Y') + 1) }}</span>
                </div>
                @if(!empty($matieres))
                <div class="matieres-item">
                    <span>Matières: {{ implode(', ', $matieres) }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Tableau des présences -->
        <table>
            <thead>
                <tr>
                    <th class="student-number">N°</th>
                    <th class="student-matricule">Matricule</th>
                    <th class="student-name">Nom et Prénom</th>
                    <!-- Colonnes dynamiques selon la période -->
                    @foreach($libellesJours as $jour)
                        <th class="day-cell">{{ $jour }}</th>
                    @endforeach
                    @if($includeTotal)
                    <th class="total-cell">Total</th>
                    @endif
                    @if($includeSignature)
                    <th class="signature-cell">Signature</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($inscriptions as $index => $inscription)
                <tr>
                    <td class="student-number">{{ $index + 1 }}</td>
                    <td class="student-matricule">{{ $inscription['apprenant']['matricule'] ?? 'N/A' }}</td>
                    <td class="student-name">
                        {{ $inscription['apprenant']['nom'] ?? '' }} {{ $inscription['apprenant']['prenom'] ?? '' }}
                    </td>
                    <!-- Cases à cocher VIDES -->
                    @foreach($libellesJours as $jour)
                        <td class="day-cell">
                            <div ></div>
                        </td>
                    @endforeach
                    @if($includeTotal)
                    <td class="total-cell">0</td>
                    @endif
                    @if($includeSignature)
                    <td class="signature-cell"></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Instructions et légende -->
        <div class="instructions">
            <div><strong>Instructions:</strong> Cochez (✓) les cases correspondantes aux jours de présence</div>
            <div><strong>Légende:</strong> □ = Absent | ✓ = Présent</div>
            @if($periode === 'mois')
            <div><em>Note: Les colonnes 01 à 31 représentent les jours du mois</em></div>
            @endif
        </div>

        <!-- Section des signatures -->
        @if($includeSignature)
        <div class="signature-section">
            <div class="signature-box signature-left">
                <div class="signature-label">Le Responsable de la Classe</div>
                <div class="signature-line"></div>
          
                <div class="signature-label">Le Chef d'Établissement</div>
                <div class="signature-line"></div>
            </div>
        </div>
        @endif

        <!-- Saut de page sauf pour la dernière classe -->
        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

    <!-- Pied de page -->
    <div class="footer">
        Document généré le {{ $date }} | {{ $etablissement->nom ?? 'Établissement scolaire' }}
        @if(isset($etablissement->slogan) && $etablissement->slogan)
            <br>{{ $etablissement->slogan }}
        @endif
    </div>
</body>
</html>