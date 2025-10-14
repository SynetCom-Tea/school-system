<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu d'inscription</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            /* background-color: #f5f5f5; */
            margin: 0;
            padding: 0;
        }
        .receipt {
            width: 550px;
            margin: 20px auto;
            background-color: #fff;
            border: 2px solid #333;
            border-radius: 15px;
            padding: 20px;
        }
        .receipt h1 {
            font-size: 17px;
            color: #0c0202ff;
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt p {
            font-size: 18px;
            color: #0e0101ff;
            margin: 8px 0;
        }
        .receipt .info {
            border-top: 1px solid #333;
            border-bottom: 1px solid #333;
            padding: 10px 0;
        }
        .logo {
            text-align: left;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 30%;
            /* height: auto; */
        }
        .dotted-line {
            width: 100%;
            border-top: 2px dotted #333;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="logo">
            <img src="team.png" alt="Logo de l'entreprise">
        </div>
        <div style="margin-bottom: 20px; text-align:right; margin-top:-160px;">
            <?php if($etablissement->logo === null): ?>
            <img style="max-width:30%; height: 11%;" src="logos/defaultLogo.png" alt="Logo de l'entreprise">
            <?php else: ?>
            <img style="max-width:30%; height:11%" src="logos/<?php echo e($etablissement->logo); ?>" alt="Logo de l'entreprise">
            <?php endif; ?>
        </div>
        <p style="margin-bottom: 20px; text-align:center; margin-top:-120px;">
       
            <b style="margin-top: -10px;"><strong><?php echo e($etablissement->name); ?></strong></b><br>
            <b style="margin-top: 5px;">Rue de <?php echo e($etablissement->adresse); ?></b><br>
            <b style="margin-top: 5px;">Tel: <?php echo e($etablissement->telephone); ?></b><br>
            <b style="margin-top: 5px;"><?php echo e($etablissement->ville); ?>-Niger</b>
      
        </p>
        <br>
        <br>
        <br>
        <div class="dotted-line"></div>
        <h1>Reçu d'inscription</h1>
        <h1 style="font-size: 16px;">Date de l'inscription: <?php echo e($inscription->date_inscription); ?></h1>
        <p><span style="float: left;">Nom & Prénom: <strong><?php echo e($inscription->apprenant->nom); ?> <?php echo e($inscription->apprenant->prenom); ?></strong></span> <br> &nbsp; <span style="float:right;">Référence de l'inscription: <strong><?php echo e($inscription->apprenant->matricule); ?></strong></span> <br> <br></p>
       
       
        <div class="info">
            <p>Année Scolaire: <?php echo e($inscription->annee->libelle); ?></p>
            <?php if($section == '1' || $section == '2'): ?>
            <p>Niveau: <?php echo e($classe->code); ?> </p>
            <?php else: ?>
            <p>Section: <?php echo e($inscription->niveau->code); ?> <?php echo e($inscription->cycleFiliere->code); ?> </p>
            <?php endif; ?>
        </div>
         <p style="text-align: center; margin-top: 20px;">Merci pour votre inscription!</p>      
    </div>
</body>
</html><?php /**PATH C:\Users\MAHAMADOU\OneDrive\Documents\projet_synetcom\system_1\school\school-system\resources\views\recu_inscription.blade.php ENDPATH**/ ?>