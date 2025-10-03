<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste d'Affichage - {{ $etablissement->nom ?? 'Établissement' }}</title>
    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 25px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #2C3E50;
            padding-bottom: 15px;
            position: relative;
        }
        .logo-right {
            position: absolute;
            right: 0;
            top: 0;
            text-align: right;
        }
        .logo {
            max-width: 120px;
            max-height: 80px;
        }
        .school-name {
            font-size: 60px;
            font-weight: bold;
            color: #2C3E50;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .school-details {
            font-size: 35px;
            color: #666;
            margin-bottom: 5px;
        }
        .document-title {
            font-size: 25px;
            font-weight: bold;
            margin: 15px 0;
            text-align: center;
            color: #2C3E50;
            text-transform: uppercase;
        }
        .class-info {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #3498DB;
        }
        .info-line {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
        }
        .info-block {
            padding: 6px 12px;
            background: white;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            page-break-inside: auto;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        thead {
            display: table-header-group;
        }
        th {
            background: #34495E;
            color: white;
            padding: 8px 5px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 25px;
            font-weight: bold;
        }
        td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 25px;
        }
        .student-number {
            width: 40px;
            text-align: center;
        }
        .student-matricule {
            width: 100px;
            text-align: center;
        }
        .student-name {
            text-align: left;
            padding-left: 8px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 25px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        .page-break {
            page-break-after: always;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
            font-size: 25px;
        }
        .striped tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .signature-area {
            margin-top: 30px;
            text-align: right;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            margin-left: auto;
            padding-top: 5px;
            font-size: 30px;
        }
    </style>
</head>
<body>
    <!-- En-tête avec logo et informations de l'école -->
    <div class="header">
        <!-- Logo à droite -->
        <div class="logo-right">
            @if($includeLogo && isset($etablissement->logo) && !empty($etablissement->logo))
                <img class="logo" src="{{ public_path('logos/' . $etablissement->logo) }}" alt="Logo établissement">
            @elseif($includeLogo)
                <img class="logo" src="{{ public_path('logos/iat-logo.png') }}" alt="Logo par défaut">
            @endif
        </div>
        
        <!-- Informations de l'école -->
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
    </div>

    <!-- Boucle sur chaque classe -->
    @foreach($classes as $classeName => $inscriptions)
        <!-- Titre du document -->
        <div class="document-title">
            LISTE D'AFFICHAGE - {{ $classeName }}
        </div>

        <!-- Informations de la classe -->
        <div class="class-info">
            <div class="info-line">
                <span class="info-block">
                    <strong>Effectif:</strong> {{ count($inscriptions) }} élèves
                </span>
                <span class="info-block">
                    <strong>Année Scolaire:</strong> {{ date('Y') . '/' . (date('Y') + 1) }}
                </span>
            </div>
        </div>

        <!-- Tableau des élèves -->
        <table class="striped">
            <thead>
                <tr>
                    <th class="student-number">N°</th>
                    <th class="student-matricule">Matricule</th>
                    <th class="student-name">Nom et Prénom</th>
                    <th width="60">Sexe</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inscriptions as $index => $inscription)
                <tr class="student-item">
                    <td class="student-number">{{ $index + 1 }}</td>
                    <td class="student-matricule">
                        {{ $inscription['apprenant']['matricule'] ?? 'N/A' }}
                    </td>
                    <td class="student-name">
                        <strong>{{ $inscription['apprenant']['nom'] ?? '' }} {{ $inscription['apprenant']['prenom'] ?? '' }}</strong>
                    </td>
                    <td>
                        {{ $inscription['apprenant']['sexe'] ?? 'N/A' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="no-data">
                        Aucun élève trouvé dans cette classe
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Signature -->
        <div class="signature-area">
            <div class="signature-line">
                Signature du Responsable
            </div>
        </div>

        <!-- Saut de page sauf pour la dernière classe -->
        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

    <!-- Pied de page -->
    <div class="footer">
        Document généré le {{ date('d/m/Y à H:i') }} | {{ $etablissement->nom ?? 'Établissement scolaire' }}
        @if(isset($etablissement->slogan) && $etablissement->slogan)
            <br>{{ $etablissement->slogan }}
        @endif
    </div>
</body>
</html>