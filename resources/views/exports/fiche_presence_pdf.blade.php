<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fiche de Présence - {{ $etablissement->nom ?? 'Établissement' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2C3E50;
            padding-bottom: 20px;
        }
        .logo {
            max-width: 150px;
            max-height: 100px;
            margin-bottom: 10px;
        }
        .school-info {
            margin-bottom: 10px;
        }
        .school-name {
            font-size: 24px;
            font-weight: bold;
            color: #2C3E50;
            margin-bottom: 5px;
        }
        .school-details {
            font-size: 14px;
            color: #666;
        }
        .document-title {
            font-size: 20px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
            color: #2C3E50;
        }
        .class-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .info-item {
            padding: 10px;
            background: #e9ecef;
            border-radius: 3px;
        }
        .info-label {
            font-weight: bold;
            color: #2C3E50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background: #34495E;
            color: white;
            padding: 12px 8px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 12px;
        }
        td {
            padding: 10px 8px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 11px;
        }
        .student-name {
            text-align: left;
        }
        .checkbox-cell {
            width: 30px;
        }
        .checkbox {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #333;
            border-radius: 3px;
            margin: 0 auto;
        }
        .total-cell {
            background: #f8f9fa;
            font-weight: bold;
        }
        .signature-cell {
            height: 40px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- En-tête avec logo et informations de l'école -->
    <div class="header">
        @if($includeLogo && isset($etablissement->logo))
            <img src="{{ $etablissement->logo }}" class="logo" alt="Logo établissement">
        @endif
        
        <div class="school-info">
            <div class="school-name">{{ $etablissement->nom ?? 'ÉTABLISSEMENT SCOLAIRE' }}</div>
            <div class="school-details">
                {{ $etablissement->adresse ?? '' }} 
                @if(isset($etablissement->telephone))
                    • Tél: {{ $etablissement->telephone }}
                @endif
                @if(isset($etablissement->email))
                    • Email: {{ $etablissement->email }}
                @endif
            </div>
        </div>
    </div>

    <!-- Boucle sur chaque classe -->
    @foreach($classes as $classeName => $inscriptions)
        <!-- Titre du document -->
        <div class="document-title">
            FICHE DE PRÉSENCE - {{ strtoupper($periode) }}
        </div>

        <!-- Informations de la classe -->
        <div class="class-info">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Classe:</span> {{ $classeName }}
                </div>
                <div class="info-item">
                    <span class="info-label">Période:</span> {{ ucfirst($periode) }}
                </div>
                <div class="info-item">
                    <span class="info-label">Effectif:</span> {{ count($inscriptions) }} élèves
                </div>
            </div>
            @if(!empty($matieres))
            <div class="info-item">
                <span class="info-label">Matières:</span> {{ implode(', ', $matieres) }}
            </div>
            @endif
        </div>

        <!-- Tableau des présences -->
        <table>
            <thead>
                <tr>
                    <th width="40">N°</th>
                    <th width="100">Matricule</th>
                    <th>Nom et Prénom</th>
                    @for($i = 1; $i <= 31; $i++)
                        <th width="30">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</th>
                    @endfor
                    <th width="60">Total</th>
                    <th width="120">Signature</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inscriptions as $index => $inscription)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $inscription['apprenant']['matricule'] ?? 'N/A' }}</td>
                    <td class="student-name">
                        {{ $inscription['apprenant']['nom'] ?? '' }} {{ $inscription['apprenant']['prenom'] ?? '' }}
                    </td>
                    @for($i = 1; $i <= 31; $i++)
                        <td class="checkbox-cell">
                            <div class="checkbox"></div>
                        </td>
                    @endfor
                    <td class="total-cell"></td>
                    <td class="signature-cell"></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Légende et instructions -->
        <div style="margin-top: 30px; font-size: 12px; color: #666;">
            <p><strong>Instructions:</strong> Cochez (✓) les cases correspondantes aux jours de présence</p>
            <p><strong>Légende:</strong> □ = Absent | ✓ = Présent</p>
        </div>

        <!-- Saut de page sauf pour la dernière classe -->
        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

    <!-- Pied de page -->
    <div class="footer">
        Document généré le {{ $date }} | {{ $etablissement->nom ?? 'Établissement scolaire' }}
    </div>
</body>
</html>