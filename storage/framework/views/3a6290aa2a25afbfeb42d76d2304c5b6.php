<!DOCTYPE html>
<html>
<head>
    <title><?php echo e($title); ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 15px; }
        .school-name { font-size: 16px; font-weight: bold; }
        .report-title { font-size: 14px; margin: 8px 0; font-weight: bold; }
        .classe-header { 
            background-color: #2c3e50; 
            color: white; 
            padding: 8px; 
            margin: 12px 0 8px 0; 
            font-weight: bold; 
            border-radius: 4px;
        }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        th, td { border: 1px solid #bdc3c7; padding: 5px; text-align: left; }
        th { 
            background-color: #ecf0f1; 
            font-weight: bold; 
            font-size: 10px;
        }
        .footer { 
            margin-top: 20px; 
            text-align: center; 
            font-size: 10px; 
            color: #7f8c8d;
        }
        .montant-restant { 
            font-weight: bold; 
            color: #e74c3c;
        }
        .montant-paye { 
            color: #27ae60;
        }
        .statut-valide { color: #27ae60; font-weight: bold; }
        .statut-attente { color: #f39c12; font-weight: bold; }
        .statut-rejete { color: #e74c3c; font-weight: bold; }
        .page-break { page-break-after: always; }
        .resume-classe {
            font-size: 10px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name"><?php echo e($etablissement->name ?? 'Établissement'); ?></div>
        <div class="report-title"><?php echo e($title); ?></div>
        <div>Date d'édition: <?php echo e($date); ?></div>
    </div>

    <?php 
        $totalGeneral = 0;
        $totalMontantRestant = 0;
        $totalMontantPaye = 0;
        $totalFraisGeneral = 0;
        
        // Grouper par classe
        $groupedInscriptions = [];
        foreach ($inscriptions as $inscription) {
            $classeName = $inscription['classe_annee']['classe']['libelle'] ?? 
                         ($inscription['niveau']['libelle'] ?? 'Non classé');
            if (!isset($groupedInscriptions[$classeName])) {
                $groupedInscriptions[$classeName] = [];
            }
            $groupedInscriptions[$classeName][] = $inscription;
        }
        
        // Trier les classes par ordre (6ème, 5ème, etc.)
        uksort($groupedInscriptions, function($a, $b) {
            // Extraire le numéro de classe
            preg_match('/\d+/', $a, $matchesA);
            preg_match('/\d+/', $b, $matchesB);
            
            $numA = isset($matchesA[0]) ? (int)$matchesA[0] : 99;
            $numB = isset($matchesB[0]) ? (int)$matchesB[0] : 99;
            
            // Ordre décroissant : 6ème avant 5ème
            if ($numA !== $numB) {
                return $numB - $numA;
            }
            
            // Si même niveau, tri alphabétique
            return strcmp($a, $b);
        });
    ?>

    <?php $__currentLoopData = $groupedInscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classeName => $classeInscriptions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            // Trier les élèves par nom puis prénom
            usort($classeInscriptions, function($a, $b) {
                $nomA = $a['apprenant']['nom'] ?? '';
                $nomB = $b['apprenant']['nom'] ?? '';
                $prenomA = $a['apprenant']['prenom'] ?? '';
                $prenomB = $b['apprenant']['prenom'] ?? '';
                
                if ($nomA === $nomB) {
                    return strcmp($prenomA, $prenomB);
                }
                return strcmp($nomA, $nomB);
            });
            
            $totalClasse = count($classeInscriptions);
            $totalGeneral += $totalClasse;
            
            // Calculer les totaux spécifiques à la classe
            $totalRestantClasse = 0;
            $totalPayeClasse = 0;
            $totalFraisClasse = 0;
            
            foreach ($classeInscriptions as $insc) {
                $totalRestantClasse += $insc['montant_restant'] ?? 0;
                $totalPayeClasse += $insc['montant_total_verse'] ?? 0;
                $totalFraisClasse += $insc['montant_total_frais'] ?? 0;
            }
            
            // Ajouter aux totaux généraux
            $totalMontantRestant += $totalRestantClasse;
            $totalMontantPaye += $totalPayeClasse;
            $totalFraisGeneral += $totalFraisClasse;
        ?>
        
        <div class="classe-header">
            Classe: <?php echo e($classeName); ?> 
            <span class="resume-classe">(<?php echo e($totalClasse); ?> élève(s) - Restant à payer: <?php echo e(number_format($totalRestantClasse, 0, ',', ' ')); ?> FCFA) et Total payé: <?php echo e(number_format($totalPayeClasse, 0, ',', ' ')); ?> FCFA</span>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="10%">Matricule</th>
                    <th width="15%">Nom & Prénom</th>
                    <th width="12%">Date Naissance</th>
                    <th width="8%">Sexe</th>
                    <th width="10%">Date Inscription</th>
                    <th width="8%">Statut</th>
                    <th width="12%">Total Frais</th>
                    <th width="12%">Total Payé</th>
                    <th width="12%">Restant</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $classeInscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $inscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $montantRestant = $inscription['montant_restant'] ?? 0;
                    $montantTotal = $inscription['montant_total_frais'] ?? 0;
                    $montantPaye = $inscription['montant_total_verse'] ?? 0;
                    
                    // Classe CSS pour le statut
                    $statutClass = '';
                    if (($inscription['statut'] ?? 0) == 1) $statutClass = 'statut-valide';
                    elseif (($inscription['statut'] ?? 0) == 0) $statutClass = 'statut-attente';
                    elseif (($inscription['statut'] ?? 0) == 2) $statutClass = 'statut-rejete';
                ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($inscription['apprenant']['matricule'] ?? 'N/A'); ?></td>
                    <td><?php echo e($inscription['apprenant']['nom'] ?? ''); ?> <?php echo e($inscription['apprenant']['prenom'] ?? ''); ?></td>
                    <td><?php echo e($inscription['apprenant']['date_naissance'] ?? ''); ?></td>
                    <td><?php echo e($inscription['apprenant']['sexe'] ?? ''); ?></td>
                    <td><?php echo e($inscription['date_inscription'] ?? ($inscription['created_at'] ? date('d/m/Y', strtotime($inscription['created_at'])) : 'N/A')); ?></td>
                    <td class="<?php echo e($statutClass); ?>">
                        <?php if(($inscription['statut'] ?? 0) == 0): ?> Non payé
                        <?php elseif(($inscription['statut'] ?? 0) == 1): ?> Payé
                        <?php elseif(($inscription['statut'] ?? 0) == 2): ?> Rejeté
                        <?php else: ?> Inconnu <?php endif; ?>
                    </td>
                    <td><?php echo e(number_format($montantTotal, 0, ',', ' ')); ?> FCFA</td>
                    <td class="montant-paye"><?php echo e(number_format($montantPaye, 0, ',', ' ')); ?> FCFA</td>
                    <td class="montant-restant"><?php echo e(number_format($montantRestant, 0, ',', ' ')); ?> FCFA</td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="footer">
        <p>Généré le <?php echo e(date('d/m/Y à H:i')); ?> | 
           Total: <?php echo e($totalGeneral); ?> inscription(s) | 
           Total restant à payer: <?php echo e(number_format($totalMontantRestant, 0, ',', ' ')); ?> FCFA |
           Total payé: <?php echo e(number_format($totalMontantPaye, 0, ',', ' ')); ?> FCFA
        </p>
    </div>
</body>
</html><?php /**PATH C:\Users\SYNETCOM\Desktop\projects\school-system\resources\views/exports/inscriptions_pdf.blade.php ENDPATH**/ ?>