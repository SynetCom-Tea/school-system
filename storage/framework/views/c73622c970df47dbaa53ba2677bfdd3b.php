<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registre de Bibliothèque</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .logo { max-width: 100px; max-height: 100px; }
        .table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f5f5f5; font-weight: bold; }
        .signature-cell { height: 50px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <?php if($includeLogo && $etablissement->logo): ?>
            <img src="<?php echo e(public_path('storage/' . $etablissement->logo)); ?>" class="logo">
        <?php endif; ?>
        <h2><?php echo e($etablissement->name); ?></h2>
        <h3>REGISTRE DE BIBLIOTHÈQUE</h3>
        <p>Période du <?php echo e(date('d/m/Y', strtotime($dateDebut))); ?> au <?php echo e(date('d/m/Y', strtotime($dateFin))); ?></p>
    </div>

    <?php $__currentLoopData = $donneesBibliotheque; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $donnee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="section">
            <h4>Élève: <?php echo e($donnee['apprenant']['nom']); ?> <?php echo e($donnee['apprenant']['prenom']); ?> - Classe: <?php echo e($donnee['classe']); ?></h4>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom du Document</th>
                        <th>Date de Prise</th>
                        <th>Date de Retour Prévue</th>
                        <?php if($includeSignature): ?>
                        <th>Signature</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $donnee['documents']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($document['nom_document']); ?></td>
                        <td><?php echo e($document['date_prise']); ?></td>
                        <td><?php echo e($document['date_retour']); ?></td>
                        <?php if($includeSignature): ?>
                        <td class="signature-cell"><?php echo e($document['signature']); ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <?php if(($index + 1) % 3 == 0): ?>
            <div class="page-break"></div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="footer">
        <p>Généré le <?php echo e($dateGeneration); ?></p>
    </div>
</body>
</html><?php /**PATH C:\Users\MAHAMADOU\OneDrive\Documents\projet_synetcom\system_1\school\school-system\resources\views/exports/registre_bibliotheque_pdf.blade.php ENDPATH**/ ?>