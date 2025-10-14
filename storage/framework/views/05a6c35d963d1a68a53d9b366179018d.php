<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste d'Affichage - <?php echo e($etablissement->nom ?? 'Établissement'); ?></title>
    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 25px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #2C3E50;
            padding-bottom: 15px;
        }
        .school-name {
            font-size: 50px;
            font-weight: bold;
            color: #2C3E50;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .school-details {
            font-size: 30px;
            color: #666;
            margin-bottom: 5px;
        }
        .document-title {
            font-size: 25px;
            font-weight: bold;
            margin: 15px 0;
            text-align: center;
            color: #2C3E50;
            text-transform: uppercase;
        }
        .class-info {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #3498DB;
        }
        .info-line {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            flex-wrap: nowrap;
        }
        .info-block {
            padding: 5px 10px;
            background: white;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 24px;
            white-space: nowrap;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            page-break-inside: auto;
            font-size: 30px;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        thead {
            display: table-header-group;
        }
        th {
            background: #34495E;
            color: white;
            padding: 10px 5px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 28px;
            font-weight: bold;
        }
        td {
            padding: 8px 5px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 26px;
        }
        .student-number {
            width: 50px;
            text-align: center;
        }
        .student-matricule {
            width: 120px;
            text-align: center;
        }
        .student-name {
            text-align: left;
            padding-left: 10px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 25px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .page-break {
            page-break-after: always;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
            font-size: 25px;
        }
        .striped tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .signature-area {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .signature-block {
            text-align: center;
            width: 45%;
        }
        .signature-line {
            border-top: 2px solid #333;
            width: 100%;
            margin-top: 60px;
            padding-top: 5px;
            font-size: 26px;
        }
        .page-header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #2C3E50;
            padding-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Boucle sur chaque classe -->
    <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classeName => $inscriptions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            // Calculer les statistiques de genre pour cette classe
            $nombreFilles = 0;
            $nombreGarcons = 0;
            
            foreach($inscriptions as $inscription) {
                $sexe = $inscription['apprenant']['sexe'] ?? '';
                $sexe = trim($sexe);
                
                // Méthode robuste de détection du genre
                if (preg_match('/^(f|femme|féminin|feminin|fille)/i', $sexe)) {
                    $nombreFilles++;
                } elseif (preg_match('/^(m|homme|masculin|garçon|garcon)/i', $sexe)) {
                    $nombreGarcons++;
                }
            }
        ?>

        <!-- En-tête de l'établissement POUR CHAQUE CLASSE -->
        <div class="page-header">
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

        <!-- Titre du document -->
        <div class="document-title">
            LISTE D'AFFICHAGE - <?php echo e($classeName); ?>

        </div>

        <!-- Informations de la classe -->
        <div class="class-info">
            <div class="info-line">
                <span class="info-block"><strong>Effectif Total:</strong> <?php echo e(count($inscriptions)); ?> élèves</span>
                <span class="info-block"><strong>Filles:</strong> <?php echo e($nombreFilles); ?></span>
                <span class="info-block"><strong>Garçons:</strong> <?php echo e($nombreGarcons); ?></span>
                <span class="info-block"><strong>Année Scolaire:</strong> <?php echo e(date('Y') . '/' . (date('Y') + 1)); ?></span>
            </div>
        </div>

        <!-- Tableau des élèves -->
        <table class="striped">
            <thead>
                <tr>
                    <th class="student-number">N°</th>
                    <!-- <th class="student-matricule">Matricule</th> -->
                    <th class="student-name">Nom et Prénom</th>
                    <th width="80">Sexe</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $inscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $inscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="student-item">
                    <td class="student-number"><?php echo e($index + 1); ?></td>
                    <!-- <td class="student-matricule">
                        <?php echo e($inscription['apprenant']['matricule'] ?? 'N/A'); ?>

                    </td> -->
                    <td class="student-name">
                        <strong><?php echo e($inscription['apprenant']['nom'] ?? ''); ?> <?php echo e($inscription['apprenant']['prenom'] ?? ''); ?></strong>
                    </td>
                    <td>
                        <?php echo e($inscription['apprenant']['sexe'] ?? 'N/A'); ?>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="no-data">
                        Aucun élève trouvé dans cette classe
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

     <!-- Signatures alignées sur une seule ligne -->
<!-- <div style="display: flex; justify-content: space-between; margin-top: 60px;"> -->
  <!-- Bloc 1 : Responsable de la Classe -->
  <!-- <div style="text-align: center; width: 45%;">
    <div style="border-bottom: 1px solid #000; height: 2px; margin-bottom: 5px;"></div>
    <strong>Le Responsable de la Classe</strong>
  </div> -->

  <!-- Bloc 2 : Chef d'Établissement -->
  <!-- <div style="text-align: center; width: 45%;">
    <div style="border-bottom: 1px solid #000; height: 2px; margin-bottom: 5px;"></div>
    <strong>Le Chef d'Établissement</strong>
  </div>
</div> -->

<div style="display: flex; justify-content: space-between; margin-top: 60px;">
  <!-- Bloc 1 : Responsable de la Classe -->
  <div style="text-align: center; width: 45%;">
    <div style="border-bottom: 1px solid #000; height: 2px; margin-bottom: 5px;"></div>
    <strong>Le Proviseur</strong>
    <div style="border-bottom: 1px solid #000; height: 2px; margin-bottom: 5px;"></div>
  </div>


        <!-- Saut de page sauf pour la dernière classe -->
        <?php if(!$loop->last): ?>
            <div class="page-break"></div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <!-- Pied de page -->
    <div class="footer">
        <!-- Document généré le <?php echo e(date('d/m/Y à H:i')); ?> | <?php echo e($etablissement->nom ?? 'Établissement scolaire'); ?> -->
        <?php if(isset($etablissement->slogan) && $etablissement->slogan): ?>
            <br><?php echo e($etablissement->slogan); ?>

        <?php endif; ?>
    </div>
</body>
</html><?php /**PATH C:\Users\MAHAMADOU\OneDrive\Documents\projet_synetcom\system_1\school\school-system\resources\views\exports\listes_affichage_pdf.blade.php ENDPATH**/ ?>