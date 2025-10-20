<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificat de Scolarité</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px; 
            line-height: 1.3;
            margin: 0;
            padding: 15px;
        }
        .certificate-container {
            border: 3px double #000;
            padding: 20px;
            margin: 10px auto;
            max-width: 700px;
            position: relative;
            min-height: 95vh;
            box-sizing: border-box;
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
            margin-bottom: 8px;
        }
        .watermark {
            position: absolute;
            opacity: 0.08;
            font-size: 80px;
            transform: rotate(-45deg);
            top: 35%;
            left: 15%;
            z-index: -1;
        }
        .student-info {
            margin: 15px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #3c80e7;
        }
        .info-row {
            display: flex;
            margin-bottom: 6px;
            padding: 3px 0;
        }
        .info-label {
            font-weight: bold;
            min-width: 150px;
            flex-shrink: 0;
        }
        .signature-area {
            margin-top: 30px;
            text-align: right;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 250px;
            margin-left: auto;
            margin-top: 40px;
            padding-top: 3px;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 10px;
            color: #666;
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
        }
        .stamp {
            position: absolute;
            bottom: 80px;
            right: 30px;
            border: 2px solid red;
            padding: 8px;
            transform: rotate(5deg);
            font-weight: bold;
            color: red;
            font-size: 10px;
        }
        .certificate-content {
            margin-bottom: 60px;
        }
        h1 {
            font-size: 18px;
            margin: 8px 0;
        }
        h2 {
            font-size: 16px;
            margin: 6px 0;
        }
        h3 {
            font-size: 14px;
            margin: 5px 0;
        }
        p {
            margin: 8px 0;
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
            <h1>{{ $etablissement->name ?? 'ÉTABLISSEMENT SCOLAIRE' }}</h1>
            <h2>CERTIFICAT DE SCOLARITÉ</h2>
            <p style="font-style: italic;">Année Scolaire {{ date('Y') }}-{{ date('Y')+1 }}</p>
        </div>

        @foreach($inscriptions as $index => $inscription)
            @if($index > 0)
                <div style="page-break-before: always;"></div>
            @endif

            <div class="certificate-content">
                <div class="student-info">
                    <h3>INFORMATIONS DE L'ÉLÈVE</h3>
                    
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

                <div style="margin: 20px 0; text-align: justify; line-height: 1.5;">
                    <p>Je soussigné(e), <strong>Directeur(trice) de {{ $etablissement->name ?? "l'établissement" }}</strong>, certifie que :</p>
                    
                    <div style="background: #f0f8ff; padding: 12px; margin: 12px 0; border-left: 4px solid #3c80e7;">
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
            </div>

            <div class="footer">
                <p>{{ $etablissement->adresse ?? '' }} - {{ $etablissement->telephone ?? '' }}</p>
                <p>Certificat généré électroniquement le {{ $dateGeneration }}</p>
            </div>
        @endforeach
    </div>
</body>
</html>