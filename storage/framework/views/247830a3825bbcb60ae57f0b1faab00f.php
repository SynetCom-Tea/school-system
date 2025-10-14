<!DOCTYPE html>
<html>
<head>
    <title><?php echo e($title); ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11pt; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5pt; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20pt; }
        .header h1 { margin-bottom: 5pt; }
        .header h2 { margin-top: 0; margin-bottom: 5pt; }
        .footer { margin-top: 30pt; text-align: right; font-size: 10pt; }
    </style>
</head>
<body>
    <div class="header">
        <h1><?php echo e($etablissement->name); ?></h1>
        <h2><?php echo e($title); ?></h2>
        <p>Date d'édition: <?php echo e($date); ?></p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Nom & Prénom</th>
                <th>Date/Lieu Naissance</th>
                <th>Sexe</th>
                <th>Niveau/Classe</th>
                <th>Date inscription</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $inscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <?php if(isset($inscription['apprenant'])): ?>
                    <td><?php echo e($inscription['apprenant']['matricule'] ?? 'N/A'); ?></td>
                    <td><?php echo e($inscription['apprenant']['nom'] ?? ''); ?> <?php echo e($inscription['apprenant']['prenom'] ?? ''); ?></td>
                    <td><?php echo e($inscription['apprenant']['date_naissance'] ?? ''); ?> à <?php echo e($inscription['apprenant']['lieu_naissance'] ?? ''); ?></td>
                    <td><?php echo e($inscription['apprenant']['sexe'] ?? ''); ?></td>
                    
                    <?php if(isset($inscription['classe_annee'])): ?>
                        <td><?php echo e($inscription['classe_annee']['classe']['niveau']['libelle'] ?? ''); ?> / <?php echo e($inscription['classe_annee']['classe']['libelle'] ?? ''); ?></td>
                    <?php else: ?>
                        <td><?php echo e($inscription['niveau']['libelle'] ?? ''); ?> / <?php echo e($inscription['cycle_filiere']['filiere']['name'] ?? ''); ?></td>
                    <?php endif; ?>
                    
                    <td><?php echo e($inscription['date_inscription'] ?? ($inscription['created_at'] ? date('d/m/Y', strtotime($inscription['created_at'])) : 'N/A')); ?></td>
                    <td>
                        <?php if(($inscription['statut'] ?? 0) == 0): ?> En attente
                        <?php elseif(($inscription['statut'] ?? 0) == 1): ?> Validé
                        <?php elseif(($inscription['statut'] ?? 0) == 2): ?> Rejeté
                        <?php else: ?> Inconnu <?php endif; ?>
                    </td>
                <?php else: ?>
                    <td colspan="7">Données d'inscription incomplètes</td>
                <?php endif; ?>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    
    <div class="footer">
        <p>Généré le <?php echo e(date('d/m/Y à H:i')); ?> | Total: <?php echo e(count($inscriptions)); ?> inscription(s)</p>
    </div>
</body>
</html><?php /**PATH C:\Users\MAHAMADOU\OneDrive\Documents\projet_synetcom\system_1\school\school-system\resources\views\exports\inscriptions_word.blade.php ENDPATH**/ ?>