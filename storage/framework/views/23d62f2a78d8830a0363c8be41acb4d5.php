<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fiche de Présence - <?php echo e($etablissement->nom ?? 'Établissement'); ?></title>
    <style>
        @page {
            margin: 15px;
            <?php if($periode === 'mois'): ?>
                /* Adapter l'orientation en fonction du nombre de jours */
                <?php if($joursParPeriode <= 20): ?>
                    size: A4 portrait;
                <?php else: ?>
                    size: A4 landscape;
                <?php endif; ?>
            <?php else: ?>
                size: A4 portrait;
            <?php endif; ?>
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
            border-bottom: 2px solid #2C3E50;
            padding-bottom: 10px;
        }
        .logo-container {
            flex: 0 0 auto;
            width: 80px;
            text-align: center;
        }
        .logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }
        .school-info {
            flex: 1;
            text-align: center;
            padding: 0 20px;
        }
        .school-name {
            font-size: 18px;
            font-weight: bold;
            color: #2C3E50;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .school-details {
            font-size: 12px;
            color: #666;
        }
        .document-title {
            font-size: 16px;
            font-weight: bold;
            margin: 12px 0;
            text-align: center;
            color: #2C3E50;
            text-transform: uppercase;
            text-decoration: underline;
        }
        .class-info {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #3498DB;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 8px;
        }
        .info-item {
            padding: 8px;
            background: white;
            border-radius: 4px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }
        .matieres-item {
            grid-column: 1 / -1;
            padding: 8px;
            background: white;
            border-radius: 4px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            page-break-inside: auto;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
        }
        thead {
            display: table-header-group;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        th {
            background: #34495E;
            color: white;
            padding: 8px 4px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 12px;
            font-weight: bold;
        }
        td {
            padding: 6px 3px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            height: 24px;
        }
        .student-number {
            width: 35px;
        }
        .student-matricule {
            width: 100px;
        }
        .student-name {
            text-align: left;
            padding-left: 8px;
            min-width: 180px;
            font-size: 12px;
        }
        .day-cell {
            width: 20px;
            min-width: 20px;
            max-width: 20px;
        }
        .checkbox {
            font-size: 16px;
            line-height: 1;
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 1px solid #333;
            background: white;
        }
        .total-cell {
            background: #e8f5e8;
            font-weight: bold;
            width: 50px;
            font-size: 12px;
        }
        .signature-cell {
            width: 80px;
            background: #9eb2dbff;
            font-size: 11px;
        }
        .instructions {
            margin-top: 15px;
            padding: 10px;
            background: #fff9e6;
            border-radius: 4px;
            border-left: 4px solid #f39c12;
            font-size: 12px;
        }
        .signature-section {
            text-align: center;
            margin-top: 30px;
        }
        .signature-box {
            width: 45%;
        }
        .signature-line {
            width: 220px;
            height: 1px;
            background: #333;
            margin: 35px 0 8px 0;
            text-align: center;
        }
        .signature-label {
            font-size: 12px;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        .footer-instructions {
            margin-top: 15px;
            padding: 10px;
            background: #fff9e6;
            border-radius: 4px;
            border-left: 4px solid #f39c12;
            font-size: 12px;
            text-align: left;
        }
        .page-break {
            page-break-after: always;
        }
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        /* Optimisations pour le format paysage (mois avec beaucoup de jours) */
        <?php if($periode === 'mois' && $joursParPeriode > 20): ?>
        .student-name {
            min-width: 160px;
            max-width: 160px;
        }
        .day-cell {
            width: 18px;
            min-width: 18px;
            max-width: 18px;
        }
        table {
            font-size: 11px;
        }
        th, td {
            font-size: 11px;
            padding: 4px 1px;
        }
        <?php endif; ?>

        /* Optimisations pour les mois avec peu de jours */
        <?php if($periode === 'mois' && $joursParPeriode <= 20): ?>
        .student-name {
            min-width: 200px;
        }
        .day-cell {
            width: 22px;
            min-width: 22px;
            max-width: 22px;
        }
        <?php endif; ?>
    </style>
</head>
<body>
    <!-- Boucle sur chaque classe -->
    <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classeName => $inscriptions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <!-- En-tête avec logo et informations de l'école -->
        <div class="header">
            <div class="logo-container">
                <?php if($includeLogo && isset($etablissement->logo) && !empty($etablissement->logo)): ?>
                    <img class="logo" src="<?php echo e(public_path('logos/' . $etablissement->logo)); ?>" alt="Logo établissement">
                <?php elseif($includeLogo): ?>
                    <img class="logo" src="<?php echo e(public_path('logos/iat-logo.png')); ?>" alt="Logo par défaut">
                <?php endif; ?>
            </div>
            <div class="school-info">
                <div class="school-name"><?php echo e($etablissement->name ?? 'ÉTABLISSEMENT SCOLAIRE'); ?></div>
                <div class="school-details">
                    <?php echo e($etablissement->adresse ?? ''); ?> 
                    <?php if(isset($etablissement->telephone) && $etablissement->telephone): ?>
                        • Tél: <?php echo e($etablissement->telephone); ?>

                    <?php endif; ?>
                    <?php if(isset($etablissement->email) && $etablissement->email): ?>
                        • Email: <?php echo e($etablissement->email); ?>

                    <?php endif; ?>
                </div>
            </div>
            <div class="logo-container">
                <!-- Espace pour un éventuel logo à droite -->
            </div>
        </div>

        <!-- Titre du document -->
        <div class="document-title">
            FICHE DE PRÉSENCE - <?php echo e(strtoupper($periode)); ?>

            <?php if($periode === 'mois'): ?>
                - <?php echo e(DateTime::createFromFormat('!m', $mois)->format('F')); ?> <?php echo e($annee); ?>

            <?php endif; ?>
        </div>

        <!-- Informations de la classe -->
        <div class="class-info">
            <div class="info-grid">
                <div class="info-item">
                    <span>Classe: <?php echo e($classeName); ?></span>
                    <span style="margin-left: 30px;">Effectif: <?php echo e(count($inscriptions)); ?> élèves</span>
                    <span style="margin-left: 30px;">
                        <?php if($periode === 'mois'): ?>
                            Période: <?php echo e(DateTime::createFromFormat('!m', $mois)->format('F')); ?> <?php echo e($annee); ?>

                        <?php else: ?>
                            Période: <?php echo e($periodeLabel); ?>

                        <?php endif; ?>
                    </span>
                    <span style="margin-left: 30px;">Année Scolaire: <?php echo e(date('Y') . '/' . (date('Y') + 1)); ?></span>
                </div>
                <?php if(!empty($matieres)): ?>
                <div class="matieres-item">
                    <span>Matières: <?php echo e(implode(', ', $matieres)); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tableau des présences -->
        <table>
            <thead>
                <tr>
                    <th class="student-number">N°</th>
                    <th class="student-matricule">Matricule</th>
                    <th class="student-name">Nom et Prénom</th>
                    <!-- Colonnes dynamiques selon la période -->
                    <?php $__currentLoopData = $libellesJours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th class="day-cell"><?php echo e($jour); ?></th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($includeTotal): ?>
                    <th class="total-cell">Total</th>
                    <?php endif; ?>
                    <?php if($includeSignature): ?>
                    <th class="signature-cell">Signature</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $inscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $inscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="student-number"><?php echo e($index + 1); ?></td>
                    <td class="student-matricule"><?php echo e($inscription['apprenant']['matricule'] ?? 'N/A'); ?></td>
                    <td class="student-name">
                        <?php echo e($inscription['apprenant']['nom'] ?? ''); ?> <?php echo e($inscription['apprenant']['prenom'] ?? ''); ?>

                    </td>
                    <!-- Cases à cocher VIDES -->
                    <?php $__currentLoopData = $libellesJours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td class="day-cell">
                            <div></div>
                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($includeTotal): ?>
                    <td class="total-cell">0</td>
                    <?php endif; ?>
                    <?php if($includeSignature): ?>
                    <td class="signature-cell"></td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <!-- Section des signatures -->
        <?php if($includeSignature): ?>
        <div class="signature-section">
            <br>
            <br>
            <div class="signature-box signature-left">
                <div class="signature-label">
                    Le Responsable de la Classe
                    <span style="margin-left: 100px;"></span>
                    Le Chef d'Établissement
                </div>
            </div>
            <br>
            <br>
            <br>
            <div class="signature-line"></div>
        </div>
        <?php endif; ?>

        <!-- Instructions dans le footer -->
        <div class="footer-instructions">
            <div><strong>Instructions:</strong> Cochez (✓) les cases correspondantes aux jours de présence</div>
            <div><strong>Légende:</strong> □ = Absent | ✓ = Présent</div>
            <?php if($periode === 'mois'): ?>
            <div><em>Note: Les colonnes représentent les jours du mois de <?php echo e(DateTime::createFromFormat('!m', $mois)->format('F')); ?> (<?php echo e($joursParPeriode); ?> jours)</em></div>
            <?php endif; ?>
        </div>

        <!-- Saut de page sauf pour la dernière classe -->
        <?php if(!$loop->last): ?>
            <div class="page-break"></div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <!-- Pied de page -->
    <div class="footer">
        Document généré le <?php echo e($date); ?> | <?php echo e($etablissement->nom ?? 'Établissement scolaire'); ?>

        <?php if(isset($etablissement->slogan) && $etablissement->slogan): ?>
            <br><?php echo e($etablissement->slogan); ?>

        <?php endif; ?>
    </div>
</body>
</html><?php /**PATH C:\Users\MAHAMADOU\OneDrive\Documents\projet_synetcom\system_1\school\school-system\resources\views\exports\fiche_presence_pdf.blade.php ENDPATH**/ ?>