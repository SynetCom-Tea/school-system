<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fiche Dossier Candidat</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .logo { max-width: 100px; max-height: 100px; }
        .candidat-info { margin: 15px 0; padding: 10px; border: 1px solid #ddd; }
        .checkbox-group { display: flex; flex-wrap: wrap; gap: 15px; margin: 10px 0; }
        .checkbox-item { display: flex; align-items: center; }
        .checkbox { width: 15px; height: 15px; border: 1px solid #000; margin-right: 5px; }
        .signature { margin-top: 30px; border-top: 1px solid #000; width: 200px; padding-top: 5px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <?php if($includeLogo && $etablissement->logo): ?>
            <img src="<?php echo e(public_path('storage/' . $etablissement->logo)); ?>" class="logo">
        <?php endif; ?>
        <h2><?php echo e($etablissement->name); ?></h2>
        <h3>FICHE DOSSIER CANDIDAT</h3>
    </div>

    <?php $__currentLoopData = $inscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $inscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="candidat-info">
            <h4>Candidat: <?php echo e($inscription['apprenant']['nom']); ?> <?php echo e($inscription['apprenant']['prenom']); ?></h4>
            <p>Classe: <?php echo e($inscription['classe_annee']['classe']['libelle'] ?? 'Non classé'); ?></p>
            
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <span>Acte de Naissance</span>
                </div>
                <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <span>Nationalité</span>
                </div>
                <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <span>Attestation BEPC</span>
                </div>
                <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <span>Photo d'identité</span>
                </div>
                <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <span>Frais versés</span>
                </div>
                <div class="checkbox-item">
                    <div class="checkbox"></div>
                    <span>Bulletins précédents</span>
                </div>
            </div>
            
            <div class="signature">
                Signature: ____________________
            </div>
        </div>
        
        <?php if(($index + 1) % 4 == 0): ?>
            <div class="page-break"></div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="footer">
        <p>Généré le <?php echo e($dateGeneration); ?></p>
    </div>
</body>
</html><?php /**PATH C:\Users\MAHAMADOU\OneDrive\Documents\projet_synetcom\system_1\school\school-system\resources\views/exports/fiche_dossier_candidat_pdf.blade.php ENDPATH**/ ?>