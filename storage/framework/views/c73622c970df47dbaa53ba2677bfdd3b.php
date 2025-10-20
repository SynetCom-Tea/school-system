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
        <?php if($includeLogo && $etablissement->logo): ?>
            <img src="<?php echo e(public_path('storage/' . $etablissement->logo)); ?>" class="logo">
        <?php endif; ?>
        <h2 style="margin: 5px 0;"><?php echo e($etablissement->name ?? 'ÉTABLISSEMENT SCOLAIRE'); ?></h2>
        <h3 style="margin: 5px 0; color: #3c80e7;">REGISTRE DE BIBLIOTHÈQUE</h3>
        <p style="margin: 5px 0;">Année Scolaire <?php echo e(date('Y')); ?>-<?php echo e(date('Y')+1); ?></p>
    </div>

    <div class="instructions">
        <strong>Instructions :</strong> Ce registre est à remplir manuellement pour le suivi des prêts de documents. 
        Inscrire le nom du document, les dates de prêt et de retour prévue, et faire signer l'emprunteur.
    </div>

    <?php $__currentLoopData = $inscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $inscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="empty-section">
            <div class="student-info">
                Élève: <strong><?php echo e($inscription['apprenant']['nom']); ?> <?php echo e($inscription['apprenant']['prenom']); ?></strong> 
                | Classe: <?php echo e($inscription['classe_annee']['classe']['libelle'] ?? 'Non classé'); ?> 
                | Matricule: <?php echo e($inscription['apprenant']['matricule'] ?? 'N/A'); ?>

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
                        <?php if($includeSignature): ?>
                        <th style="width: 15%;">Signature Emprunteur</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i = 1; $i <= 8; $i++): ?>
                    <tr>
                        <td style="text-align: center;"><?php echo e($i); ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: center;"></td>
                        <?php if($includeSignature): ?>
                        <td></td>
                        <?php endif; ?>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
            
            <div style="margin-top: 10px; font-size: 10px; text-align: right;">
                <em>Lignes 1 à 8 - Page <?php echo e(ceil(($index + 1) / 2)); ?></em>
            </div>
        </div>
        
        <?php if(($index + 1) % 2 == 0 && ($index + 1) < count($inscriptions)): ?>
            <div class="page-break"></div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="footer">
        <p>Registre généré le <?php echo e($dateGeneration); ?> | <?php echo e($etablissement->name ?? 'Établissement Scolaire'); ?></p>
        <p>Service Bibliothèque</p>
    </div>
</body>
</html><?php /**PATH C:\Users\MAHAMADOU\OneDrive\Documents\projet_synetcom\system_1\school\school-system\resources\views/exports/registre_bibliotheque_pdf.blade.php ENDPATH**/ ?>