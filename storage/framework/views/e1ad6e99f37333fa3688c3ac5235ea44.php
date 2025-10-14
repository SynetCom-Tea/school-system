<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de versement - Double</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            display: flex;
            justify-content: center;
            gap: 0px;
            padding: -5px;
        }
        .receipt {
            width: 665px;
            background-color: #fff;
            border: 2px solid #333;
            border-radius: 15px;
            padding: 20px;
            box-sizing: border-box;
        }
        .receipt h1 {
            font-size: 17px;
            color: #141414ff;
            text-align: center;
        }
        .receipt p {
            font-size: 12px;
            color: #130303ff;
            margin: 8px 0;
        }
        .receipt .info {
            border-top: 1px solid #333;
            border-bottom: 1px solid #333;
            padding: 10px 0;
        }
        .logo {
            text-align: left;
            margin-bottom: 12px;
            margin-top: -10px;
            margin-left: -10px;
        }
        .logo img {
            max-width: 25%;
        }
        .dotted-line {
            width: 100%;
            border-top: 2px dotted #333;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Premier reçu -->
        <div class="receipt">
            <div class="logo">
                <img src="team.png" alt="Logo de l'entreprise">
            </div>
            <div style="margin-bottom: 20px; text-align:right; margin-top:-160px;">
                 <?php if($etablissement->logo === null): ?>
                <img style="max-width:40%; height: 10%;" src="logos/iat-logo.png" alt="Logo de l'entreprise">
                <?php else: ?>
                <img style="max-width:30%; height: 12%" src="logos/<?php echo e($etablissement->logo); ?>" alt="Logo de l'entreprise">
                <?php endif; ?>
            </div>
            
            <p style="margin-bottom: 20px; text-align:center; margin-top:-120px; font-size: 16px;">
                <br>
                <b style="margin-top: -10px;"><strong><?php echo e($etablissement->name); ?></strong></b><br>
                <b style="margin-top: 5px;">Rue de l'<?php echo e($etablissement->adresse); ?></b><br>
                <b style="margin-top: 5px;">Tel: <?php echo e($etablissement->telephone); ?></b><br>
                <b style="margin-top: 5px;"><?php echo e($etablissement->ville); ?>-Niger</b>
            </p>
            
            <br>
            
             
            <h1>Reçu de versement du<br><?php echo e($versement->frais->etablissement_type_frais->type_frais->libelle); ?></h1>
            <h1 style="font-size: 15px;">Date du versement: <?php echo e($versement->date_versement); ?></h1>
            <p><span style="float: left;">Nom & Prénom: <strong><?php echo e($versement->inscription->apprenant->nom); ?> <?php echo e($versement->inscription->apprenant->prenom); ?></strong></span> &nbsp; <span style="float:right;">Montant versé: <strong><?php echo e($versement->montant); ?> FCFA</strong></span> </p>
            <p><span style="float: left;">Référence de l'inscription: <strong><?php echo e($versement->inscription->apprenant->matricule); ?></strong></span> <span style="float:right;">Montant restant: <strong><?php echo e(($versement->frais->montant - $somme_verse)); ?></strong></span></p>
            <br><br>
            <div class="info">
                <p>Année Scolaire: <?php echo e($versement->inscription->annee->libelle); ?></p>
                <?php if($section == '1' || $section == '2'): ?>
                <p>Classe: <?php echo e($classe->libelle ?? 'Non classé'); ?> </p>
                <?php else: ?>
                <p>Section: <?php echo e($versement->inscription->niveau->code); ?> <?php echo e($versement->inscription->cycleFiliere->code); ?> </p>
                <?php endif; ?>
            </div>
            <p style="text-align: center; margin-top: 20px;">Merci pour votre confiance!</p>      
        </div>
        <br>


        
        <br>
        <!-- Deuxième reçu (copie) -->
        <div class="receipt">
            <div class="logo">
                <img src="team.png" alt="Logo de l'entreprise">
            </div>
            <div style="margin-bottom: 20px; text-align:right; margin-top:-160px;">
                 <?php if($etablissement->logo === null): ?>
                <img style="max-width:40%; height: 10%;" src="logos/iat-logo.png" alt="Logo de l'entreprise">
                <?php else: ?>
                <img style="max-width:30%; height: 23%" src="logos/<?php echo e($etablissement->logo); ?>" alt="Logo de l'entreprise">
                <?php endif; ?>
            </div>
            <p style="margin-bottom: 20px; text-align:center; margin-top:-120px; font-size: 18px;">
                <b style="margin-top: -10px;"><strong><?php echo e($etablissement->name); ?></strong></b><br>
                <b style="margin-top: 5px;">Rue de <?php echo e($etablissement->adresse); ?></b><br>
                <b style="margin-top: 5px;">Tel: <?php echo e($etablissement->telephone); ?></b><br>
                <b style="margin-top: 5px;"><?php echo e($etablissement->ville); ?>-Niger</b>
            </p>
               
            <h1>Reçu de versement du<br><?php echo e($versement->frais->etablissement_type_frais->type_frais->libelle); ?></h1>
            <h1 style="font-size: 15px;">Date du versement: <?php echo e($versement->date_versement); ?></h1>
            <p><span style="float: left;">Nom & Prénom: <strong><?php echo e($versement->inscription->apprenant->nom); ?> <?php echo e($versement->inscription->apprenant->prenom); ?></strong></span> &nbsp; <span style="float:right;">Montant versé: <strong><?php echo e($versement->montant); ?> FCFA</strong></span> </p>
            <p><span style="float: left;">Référence de l'inscription: <strong><?php echo e($versement->inscription->apprenant->matricule); ?></strong></span> <span style="float:right;">Montant restant: <strong><?php echo e(($versement->frais->montant - $somme_verse)); ?></strong></span></p>
            <br><br>
            <div class="info">
                <p>Année Scolaire: <?php echo e($versement->inscription->annee->libelle); ?></p>
                <?php if($section == '1' || $section == '2'): ?>
                <p>Classe: <?php echo e($classe->libelle ?? 'Non classé'); ?> </p>
                <?php else: ?>
                <p>Section: <?php echo e($versement->inscription->niveau->code); ?> <?php echo e($versement->inscription->cycleFiliere->code); ?> </p>
                <?php endif; ?>
            </div>
            <p style="text-align: center; margin-top: 20px;">Merci pour votre confiance!</p>      
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\MAHAMADOU\OneDrive\Documents\projet_synetcom\system_1\school\school-system\resources\views/recu_versement.blade.php ENDPATH**/ ?>