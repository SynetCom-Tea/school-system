<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relevé de Notes - <?php echo e($matieres[0] ?? 'Matière'); ?></title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 9px; 
            margin: 0;
            padding: 8px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 10px; 
            border-bottom: 2px solid #3c80e7; 
            padding-bottom: 8px;
        }
        .logo { 
            max-width: 50px; 
            max-height: 50px;
            margin-bottom: 5px;
        }
        .classe-header {
            background: #3c80e7;
            color: white;
            padding: 8px;
            text-align: center;
            border-radius: 4px;
            margin-bottom: 8px;
            font-size: 10px;
            font-weight: bold;
        }
        .matiere-title {
            background: #495057;
            color: white;
            padding: 6px 10px;
            text-align: center;
            border-radius: 3px;
            margin: 8px 0;
            font-size: 10px;
            font-weight: bold;
        }
        .info-etablissement {
            background: #f8f9fa;
            padding: 6px;
            border-radius: 3px;
            margin: 6px 0;
            text-align: center;
            font-size: 8px;
            border: 1px solid #dee2e6;
        }
        .notes-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 7px;
        }
        .notes-table th {
            background: #6c757d;
            color: white;
            padding: 5px 3px;
            border: 1px solid #dee2e6;
            font-weight: bold;
            text-align: center;
        }
        .notes-table td {
            padding: 4px 3px;
            border: 1px solid #dee2e6;
            text-align: center;
        }
        .student-name {
            text-align: left;
            padding-left: 5px !important;
            font-weight: 500;
            font-size: 7px;
            line-height: 1.1;
        }
        .interrogations-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            padding: 1px;
        }
        .interro-cell {
            border: 1px solid #adb5bd;
            height: 12px;
            background: white;
        }
        .coefficient-cell {
            background: #e9ecef;
            font-weight: bold;
        }
        .moyenne-cell {
            background: #e8f4ff;
            font-weight: bold;
        }
        .devoir-cell {
            background: #fff3cd;
        }
        .composition-cell {
            background: #ffeaa7;
        }
        .signature-area {
            margin-top: 15px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #000;
            display: inline-block;
            width: 120px;
            margin: 0 8px;
            padding-top: 2px;
            text-align: center;
            font-size: 7px;
        }
        .professeur-info {
            background: #e8f4ff;
            padding: 4px 8px;
            border-radius: 3px;
            margin: 6px 0;
            font-size: 8px;
            border-left: 3px solid #3c80e7;
        }
        .page-break { 
            page-break-after: always;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 7px;
            color: #6c757d;
            padding-top: 5px;
            border-top: 1px solid #dee2e6;
        }
        .compact-text {
            font-size: 7px;
            line-height: 1.1;
        }
    </style>
</head>
<body>
    <!-- En-tête avec logo et informations établissement -->
    <div class="header">
     <?php if($includeLogo && isset($etablissement->logo) && !empty($etablissement->logo)): ?>
            <img class="logo" src="<?php echo e(public_path('logos/' . $etablissement->logo)); ?>" alt="Logo établissement">
        <?php elseif($includeLogo): ?>
            <img class="logo" src="<?php echo e(public_path('logos/iat-logo.png')); ?>" alt="Logo par défaut">
        <?php endif; ?>
        <h1 style="margin: 2px 0; color: #2c3e50; font-size: 11px;"><?php echo e($etablissement->name ?? 'ÉTABLISSEMENT SCOLAIRE'); ?></h1>
        <h2 style="margin: 1px 0; color: #3c80e7; font-size: 10px;">RELEVÉ DE NOTES</h2>
        <p style="margin: 1px 0; color: #6c757d; font-size: 8px;">Année Scolaire <?php echo e(date('Y')); ?>-<?php echo e(date('Y')+1); ?></p>
    </div>

    <?php if(empty($classesAvecEleves)): ?>
        <div style="text-align: center; padding: 20px; color: #6c757d;">
            <p>Aucune donnée disponible</p>
        </div>
    <?php else: ?>
        <?php $__currentLoopData = $classesAvecEleves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!-- En-tête de la classe -->
            <div class="classe-header">
                CLASSE : <?php echo e($classe['libelle']); ?>

            </div>

            <!-- Informations établissement -->
            <div class="info-etablissement">
                <div style="display: flex; justify-content: space-between; font-size: 7px;">
                    <div><strong>Établissement:</strong> <?php echo e($etablissement->name ?? ''); ?></div>
                    <div><strong>Année:</strong> <?php echo e(date('Y')); ?>-<?php echo e(date('Y')+1); ?></div>
                    <div>
                        <strong>Période:</strong> 
                        <select style="border: none; background: transparent; font-size: 7px; width: 60px;">
                            <option>Trim.1</option>
                            <option>Trim.2</option>
                            <option>Trim.3</option>
                        </select>
                    </div>
                </div>
            </div>

            <?php $__currentLoopData = $matieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!-- Titre de la matière -->
                <div class="matiere-title">
                    MATIÈRE : <?php echo e($matiere); ?>

                </div>

                <!-- Informations professeur -->
                <div class="professeur-info">
                    <strong>Professeur :</strong> ______________________ &nbsp; 
                    <strong>Date :</strong> __/__/______
                </div>

                <!-- Tableau des notes -->
                <table class="notes-table">
                    <thead>
                        <tr>
                            <th style="width: 4%;">N°</th>
                            <th style="width: 22%;">Nom et Prénom</th>
                            <th style="width: 4%;">Coef</th>
                            <th style="width: 18%;">Interros /20</th>
                            <th style="width: 6%;">Moy Int</th>
                            <th style="width: 6%;">Dev /20</th>
                            <th style="width: 6%;">Comp /20</th>
                            <th style="width: 6%;">Moy /20</th>
                            <th style="width: 12%;">Observation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $classe['eleves']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $eleve): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="font-weight: bold; background: #f8f9fa;"><?php echo e($index + 1); ?></td>
                            <td class="student-name">
                                <strong><?php echo e($eleve['apprenant']['nom'] ?? 'NON RENSEIGNÉ'); ?></strong>
                                <?php echo e($eleve['apprenant']['prenom'] ?? ''); ?>

                            </td>
                            <td class="coefficient-cell">__</td>
                            <td>
                                <div class="interrogations-grid">
                                    <?php for($i = 1; $i <= 4; $i++): ?>
                                    <div class="interro-cell"></div>
                                    <?php endfor; ?>
                                </div>
                            </td>
                            <td style="background: #f8f9fa; font-weight: bold;">__</td>
                            <td class="devoir-cell">__</td>
                            <td class="composition-cell">__</td>
                            <td class="moyenne-cell">__</td>
                            <td style="text-align: left; padding-left: 3px; font-size: 6px;">
                                ________
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        <!-- Lignes supplémentaires -->
                        <?php for($i = count($classe['eleves']); $i < 15; $i++): ?>
                        <tr>
                            <td style="font-weight: bold; background: #f8f9fa;"><?php echo e($i + 1); ?></td>
                            <td class="student-name">___________________</td>
                            <td class="coefficient-cell">__</td>
                            <td>
                                <div class="interrogations-grid">
                                    <?php for($j = 1; $j <= 4; $j++): ?>
                                    <div class="interro-cell"></div>
                                    <?php endfor; ?>
                                </div>
                            </td>
                            <td style="background: #f8f9fa;">__</td>
                            <td class="devoir-cell">__</td>
                            <td class="composition-cell">__</td>
                            <td class="moyenne-cell">__</td>
                            <td style="text-align: left; padding-left: 3px; font-size: 6px;">
                                ________
                            </td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>

                <!-- Signatures -->
                <div class="signature-area">
                    <div style="display: flex; justify-content: space-around;">
                        <div>
                            <div class="signature-line">Professeur</div>
                        </div>
                        <div>
                            <div class="signature-line">Censeur</div>
                        </div>
                        <div>
                            <div class="signature-line">Chef Étab.</div>
                        </div>
                    </div>
                </div>

                <!-- Saut de page après chaque matière -->
                <?php if(!$loop->last): ?>
                    <div class="page-break"></div>
                    <!-- Réafficher l'en-tête sur les pages suivantes -->
                    <div class="header" style="margin-bottom: 8px;">
                        <h3 style="margin: 1px 0; color: #3c80e7; font-size: 9px;">SUITE - <?php echo e($classe['libelle']); ?></h3>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <div class="footer">
        <p><strong><?php echo e($etablissement->name ?? 'Établissement Scolaire'); ?></strong> - Généré le <?php echo e($dateGeneration); ?></p>
    </div>
</body>
</html><?php /**PATH C:\Users\MAHAMADOU\OneDrive\Documents\projet_synetcom\system_1\school\school-system\resources\views/exports/releve_notes_par_matiere_pdf.blade.php ENDPATH**/ ?>