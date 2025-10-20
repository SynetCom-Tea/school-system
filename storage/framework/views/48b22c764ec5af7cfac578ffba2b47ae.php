<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fiche Dossier Candidat - Terminale/3ème</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 13px; 
            margin: 0;
            padding: 20px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 25px; 
            border-bottom: 3px solid #3c80e7; 
            padding-bottom: 20px;
        }
        .logo { 
            max-width: 90px; 
            max-height: 90px;
        }
        .candidate-card {
            border: 2px solid #3c80e7;
            margin: 25px 0;
            padding: 25px;
            page-break-inside: avoid;
            background: white;
            border-radius: 8px;
        }
        .candidate-header {
            background-color: #3c80e7;
            color: white;
            padding: 15px;
            margin: -25px -25px 20px -25px;
            text-align: center;
            border-radius: 6px 6px 0 0;
        }
        .instructions {
            background-color: #e8f4ff;
            border: 2px solid #3c80e7;
            padding: 12px;
            margin: 15px 0;
            border-radius: 6px;
            font-size: 12px;
            text-align: center;
        }
        .checkbox-section {
            margin: 20px 0;
        }
        .checkbox-grid { 
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin: 15px 0;
        }
        .checkbox-item { 
            display: flex;
            align-items: center;
            padding: 5px 0;
        }
        .checkbox { 
            width: 20px; 
            height: 20px; 
            border: 2px solid #333; 
            margin-right: 10px;
            background: white;
            flex-shrink: 0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin: 15px 0;
        }
        .info-item {
            padding: 8px 0;
            border-bottom: 1px dotted #ddd;
        }
        .info-label {
            font-weight: bold;
            color: #333;
            min-width: 140px;
            display: inline-block;
        }
        .signature-area {
            margin-top: 25px;
        }
        .signature-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 20px;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 100%;
            margin-top: 40px;
            padding-top: 5px;
            text-align: center;
        }
        .page-break { 
            page-break-after: always;
        }
        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 11px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .section-title {
            background-color: #3c80e7;
            color: white;
            padding: 8px 12px;
            margin: 20px -25px 15px -25px;
            text-align: center;
            font-weight: bold;
        }
        .candidate-number {
            font-size: 18px;
            font-weight: bold;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <?php if($includeLogo && $etablissement->logo): ?>
            <img src="<?php echo e(public_path('storage/' . $etablissement->logo)); ?>" class="logo">
        <?php endif; ?>
        <h2 style="margin: 8px 0; color: #2c3e50;"><?php echo e($etablissement->name ?? 'ÉTABLISSEMENT SCOLAIRE'); ?></h2>
        <h3 style="margin: 5px 0; color: #3c80e7;">FICHE DE SUIVI DU DOSSIER CANDIDAT</h3>
        <h4 style="margin: 5px 0; color: #666;">CLASSE DE TERMINALE / 3ÈME</h4>
        <p style="margin: 5px 0; font-weight: bold;">Année Scolaire <?php echo e(date('Y')); ?>-<?php echo e(date('Y')+1); ?></p>
    </div>

    <div class="instructions">
        <strong>📝 INSTRUCTIONS :</strong> Cochez les cases lorsque les documents sont fournis par le candidat. 
        Cette fiche doit être remplie manuellement par le service de scolarité.
    </div>

    <?php if(empty($inscriptions)): ?>
        <div style="text-align: center; padding: 50px; color: #666; background: #f9f9f9; border-radius: 8px;">
            <h3 style="color: #999;">Aucun élève de Terminale ou 3ème trouvé</h3>
            <p>Il n'y a actuellement aucun élève inscrit en classe de Terminale ou 3ème.</p>
        </div>
    <?php else: ?>
        <?php $__currentLoopData = $inscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $inscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="candidate-card">
                <div class="candidate-header">
                    <h3 style="margin: 0; font-size: 16px; display: flex; align-items: center; justify-content: center;">
                        <span class="candidate-number">#<?php echo e($index + 1); ?></span>
                        DOSSIER CANDIDAT - TERMINALE/3ÈME
                    </h3>
                </div>

                <!-- Informations de l'élève -->
                <div class="section-title">
                    INFORMATIONS DU CANDIDAT
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nom et Prénom :</span> 
                        <strong><?php echo e($inscription['apprenant']['nom']); ?> <?php echo e($inscription['apprenant']['prenom']); ?></strong>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Matricule :</span> 
                        <?php echo e($inscription['apprenant']['matricule'] ?? 'Non attribué'); ?>

                    </div>
                    <div class="info-item">
                        <span class="info-label">Classe :</span> 
                        <strong><?php echo e($inscription['classe_annee']['classe']['libelle'] ?? $inscription['niveau']['libelle'] ?? 'Non spécifié'); ?></strong>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date de dépôt :</span> 
                        _________________________
                    </div>
                </div>

                <!-- Documents à cocher -->
                <div class="section-title">
                    DOCUMENTS À FOURNIR
                </div>

                <div class="checkbox-section">
                    <div class="checkbox-grid">
                        <!-- Documents communs à tous -->
                        <div class="checkbox-item">
                            <div class="checkbox"></div>
                            <span><strong>Acte de Naissance (Original)</strong></span>
                        </div>
                        <div class="checkbox-item">
                            <div class="checkbox"></div>
                            <span><strong>Certificat de Nationalité</strong></span>
                        </div>
                        <div class="checkbox-item">
                            <div class="checkbox"></div>
                            <span><strong>Photos 4x4 (4 exemplaires)</strong></span>
                        </div>
                        <div class="checkbox-item">
                            <div class="checkbox"></div>
                            <span><strong>Quittance frais de dépôt</strong></span>
                        </div>
                        
                        <!-- Document conditionnel pour la 3ème -->
                        <?php
                            $classeLibelle = strtolower($inscription['classe_annee']['classe']['libelle'] ?? '');
                            $isTroisieme = str_contains($classeLibelle, '3ème') || str_contains($classeLibelle, '3eme');
                        ?>
                        <?php if($isTroisieme): ?>
                        <div class="checkbox-item">
                            <div class="checkbox"></div>
                            <span><strong>Attestation du BEPC</strong></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Signatures -->
                <div class="signature-area">
                    <div class="signature-grid">
                        <div>
                            <div class="signature-line">
                                Signature du Candidat
                            </div>
                            <div style="margin-top: 5px; font-size: 11px; text-align: center;">
                                Fait à ____________________, le ____________________
                            </div>
                        </div>
                        <div>
                            <div class="signature-line">
                                Signature du Responsable
                            </div>
                            <div style="margin-top: 5px; font-size: 11px; text-align: center;">
                                Vu et vérifié le ____________________
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saut de page après chaque candidat pour une meilleure lisibilité -->
            <?php if(($index + 1) < count($inscriptions)): ?>
                <div class="page-break"></div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <div class="footer">
        <p><strong><?php echo e($etablissement->name ?? 'Établissement Scolaire'); ?></strong> | Service de Scolarité</p>
        <p>Fiche générée le <?php echo e($dateGeneration); ?> | Document officiel</p>
    </div>
</body>
</html><?php /**PATH C:\Users\MAHAMADOU\OneDrive\Documents\projet_synetcom\system_1\school\school-system\resources\views/exports/fiche_dossier_candidat_pdf.blade.php ENDPATH**/ ?>