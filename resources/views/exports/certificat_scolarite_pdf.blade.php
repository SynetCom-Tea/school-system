<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificat de Scolarité</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 14px; 
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .certificate-container {
            border: 3px double #000;
            padding: 30px;
            margin: 20px auto;
            max-width: 800px;
            position: relative;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px;
            border-bottom: 2px solid #333; 
            padding-bottom: 20px;
        }
        .logo { 
            max-width: 120px; 
            max-height: 120px;
            margin-bottom: 10px;
        }
        .watermark {
            position: absolute;
            opacity: 0.1;
            font-size: 120px;
            transform: rotate(-45deg);
            top: 30%;
            left: 10%;
            z-index: -1;
        }
        .student-info {
            margin: 25px 0;
            padding: 20px;
            background-color: #f9f9f9;
            border-left: 4px solid #3c80e7;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
            padding: 5px 0;
        }
        .info-label {
            font-weight: bold;
            min-width: 200px;
        }
        .signature-area {
            margin-top: 50px;
            text-align: right;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 300px;
            margin-left: auto;
            margin-top: 60px;
            padding-top: 5px;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #666;
        }
        .stamp {
            position: absolute;
            bottom: 50px;
            right: 50px;
            border: 2px solid red;
            padding: 10px;
            transform: rotate(5deg);
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="watermark">CERTIFICAT</div>
        
        <div class="header">
            @if($etablissement->logo)
                <img src="{{ public_path('storage/' . $etablissement->logo) }}" class="logo">
            @endif
            <h1 style="margin: 10px 0; color: #2c3e50;">{{ $etablissement->name ?? 'ÉTABLISSEMENT SCOLAIRE' }}</h1>
            <h2 style="margin: 5px 0; color: #3c80e7;">CERTIFICAT DE SCOLARITÉ</h2>
            <p style="margin: 5px 0; font-style: italic;">Année Scolaire {{ date('Y') }}-{{ date('Y')+1 }}</p>
        </div>

        @foreach($inscriptions as $index => $inscription)
            @if($index > 0)
                <div style="page-break-before: always;"></div>
            @endif

            <div class="student-info">
                <h3 style="color: #2c3e50; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                    INFORMATIONS DE L'ÉLÈVE
                </h3>
                
                <div class="info-row">
                    <span class="info-label">Nom et Prénom(s) :</span>
                    <span>{{ $inscription['apprenant']['nom'] }} {{ $inscription['apprenant']['prenom'] }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Matricule :</span>
                    <span>{{ $inscription['apprenant']['matricule'] ?? 'Non attribué' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Date de Naissance :</span>
                    <span>{{ date('d/m/Y', strtotime($inscription['apprenant']['date_naissance'])) }} à {{ $inscription['apprenant']['lieu_naissance'] ?? 'Non renseigné' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Classe :</span>
                    <span>{{ $inscription['classe_annee']['classe']['libelle'] ?? $inscription['niveau']['libelle'] ?? 'Non classé' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Niveau :</span>
                    <span>{{ $inscription['niveau']['libelle'] ?? 'Non spécifié' }}</span>
                </div>
                
                @if(isset($inscription['cycleFiliere']) && $inscription['cycleFiliere'])
                <div class="info-row">
                    <span class="info-label">Filière :</span>
                    <span>{{ $inscription['cycleFiliere']['filiere']['name'] ?? '' }}</span>
                </div>
                @endif
                
                <div class="info-row">
                    <span class="info-label">Année Scolaire :</span>
                    <span>{{ $inscription['annee']['libelle'] ?? date('Y') . '/' . (date('Y')+1) }}</span>
                </div>
            </div>

            <div style="margin: 30px 0; text-align: justify; line-height: 1.6;">
                <p>Je soussigné(e), <strong>Directeur(trice) de {{ $etablissement->name ?? "l'établissement" }}</strong>, certifie que :</p>
                
                <div style="background: #f0f8ff; padding: 15px; margin: 15px 0; border-left: 4px solid #3c80e7;">
                    <strong>{{ $inscription['apprenant']['nom'] }} {{ $inscription['apprenant']['prenom'] }}</strong>
                </div>
                
                <p>est régulièrement inscrit(e) dans notre établissement pour l'année scolaire <strong>{{ $inscription['annee']['libelle'] ?? date('Y') . '/' . (date('Y')+1) }}</strong> 
                en classe de <strong>{{ $inscription['classe_annee']['classe']['libelle'] ?? $inscription['niveau']['libelle'] ?? 'Non classé' }}</strong>.</p>
                
                <p>Le présent certificat est délivré à l'intéressé(e) pour servir et valoir ce que de droit.</p>
            </div>

            <div class="signature-area">
                <div class="signature-line">
                    Le Directeur
                </div>
            </div>

            <div class="stamp">
                VU ET CERTIFIÉ<br>
                {{ date('d/m/Y') }}
            </div>

            <div class="footer">
                <p>{{ $etablissement->adresse ?? '' }} - {{ $etablissement->telephone ?? '' }}</p>
                <p>Certificat généré électroniquement le {{ $dateGeneration }}</p>
            </div>
        @endforeach
    </div>
</body>
</html>