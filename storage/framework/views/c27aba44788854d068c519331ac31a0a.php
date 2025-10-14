<?php $__currentLoopData = $donnees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donnee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin par classe</title>
    <style type="text/css">
        td,
        th {
            border: 0.5px solid black;
    
        }

        table {
            width: 100%;
            
            font-family: helvetica;
            line-height: 5mm;
            border-collapse: collapse;
        }
        h2 {
            margin: 0;
            padding: 0;
        }
        p {
            margin: 5px;
        }
       
        body {
            /* background-image: url(logos/armoirie.png); */
            background-repeat: no-repeat;
            background-position: center; 
            
            /* background-size: contain; */
            opacity: 1;
        }
    
        .border th {
            border: 1px solid #000;
            color: white;
            background: #717375;
            padding: 5px;
            font-weight: normal;
            font-size: 14px;
            text-align: center;
        }
        .border td {
            border: 1px solid #CFD1D2;
            padding: 5px 10px;
            text-align: center;
        }
        
        .no-border {
            border-right: 1px solid #CFD1D2;
            border-left: none;
            border-top: none;
            border-bottom: none;
        }
        .space {
            padding-top: 250px;
        }
    
        .p10 {
            width: 10%;
        }
        .p15 {
            width: 15%;
        }
        .p25 {
            width: 25%;
        }
        .p50 {
            width: 50%;
        }
        .p60 {
            width: 60%;
        }
        .p75 {
            width: 75%;
        }
    </style>
</head>
<body>
    <!-- Entete de page -->
    <!-- <div style="background-image:url(test2.jpg)"> -->
        
    <div>
        <div style="position:absolute; margin-top:10px;">
            <?php if($section == '1' || $section == '2'): ?>
            <b><i style="font-size: 13px; margin: 5px;">REPUBLIQUE DU NIGER</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">MINISTERE DE L'EDUCATION NATIONALE</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">DREN NIAMEY</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">DDEN NIAMEY IV</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">IESG NY IV</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;"><?php echo e($etablissement->name); ?></i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">ANNEE SCOLAIRE : <?php echo e($donnee['bulletin']->classe_annee->annee->libelle); ?></i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">SEMESTRE : <?php echo e($donnee['bulletin']->periode); ?></i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">SECTION :  <?php if($section == '1'): ?> Primaire <?php elseif($section == '2'): ?> Sécondaire <?php elseif($section == '3'): ?> Supérieur <?php endif; ?></i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">NIVEAU : <?php echo e($donnee['bulletin']->classe_annee->classe->niveau->libelle); ?> </i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">FILIERE : <?php echo e($donnee['bulletin']->nom_classe); ?> </i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;"><?php echo e($etablissement->adresse); ?></i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">Tel: <?php echo e($etablissement->telephone); ?> / Email: <?php echo e($etablissement->email); ?></i></b><br>
            <b><i style="font-size: 13px; margin: 5px;"><?php echo e($etablissement->ville); ?> - Niger</i></b><br>
            <?php else: ?>
            <b><i style="font-size: 13px; margin: 5px;">REPUBLIQUE DU NIGER</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">MINISTERE DE L'ENSEIGNEMENT SUPERIEUR</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">NIVEAU : <?php echo e($donnee['bulletin']->classe_annee->classe->niveau->libelle); ?> </i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">FILIERE : <?php echo e($donnee['bulletin']->nom_classe); ?> </i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;"><?php echo e($etablissement->adresse); ?></i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">Tel: <?php echo e($etablissement->telephone); ?> / Email: <?php echo e($etablissement->email); ?></i></b><br>
            <b><i style="font-size: 13px; margin: 5px;"><?php echo e($etablissement->ville); ?> - Niger</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;"><?php echo e($etablissement->name); ?></i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">SEMESTRE : <?php echo e($donnee['bulletin']->periode); ?></i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">SECTION :  <?php if($section == '1'): ?> Primaire <?php elseif($section == '2'): ?> Sécondaire <?php elseif($section == '3'): ?> Supérieur <?php endif; ?></i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">ANNEE SCOLAIRE : <?php echo e($donnee['bulletin']->classe_annee->annee->libelle); ?></i>&nbsp;&nbsp;</b><br>      
        
            <?php endif; ?>
            <?php if($section == '3' || $section == '4'): ?>
            <b><i style="font-size: 13px; margin: 5px;">REPUBLIQUE DU NIGER</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">MINISTERE DE L'ENSEIGNEMENT SUPERIEUR</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">NIVEAU : <?php echo e($donnee['bulletin']->classe_annee->classe->niveau->libelle); ?> </i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">FILIERE : <?php echo e($donnee['bulletin']->nom_classe); ?> </i>&nbsp;&nbsp;</b><br>

            <?php endif; ?>
            
        </div>
        <div style="position:absolute;margin-top:10px;margin-left:300px">
            <?php if($etablissement->logo === null): ?>
            <img style="max-width:50%; height:auto" src="team.png" alt="Logo de l'entreprise">
            <?php else: ?>
            <img style="max-width:50%; height:auto" src="logos/<?php echo e($etablissement->logo); ?>" alt="Logo de l'entreprise">
            <?php endif; ?>
        </div>
        <div style="position:absolute;margin-top:10px;margin-left:480px">
        <?php if($section == '1' || $section == '2'): ?>
            <b><i style="font-size: 13px; margin: 5px;">ANNEE SCOLAIRE : <?php echo e($donnee['bulletin']->classe_annee->annee->libelle); ?></i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">SEMESTRE : <?php echo e($donnee['bulletin']->periode); ?></i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">SECTION :  <?php if($section == '1'): ?> Primaire <?php elseif($section == '2'): ?> Sécondaire <?php elseif($section == '3'): ?> Supérieur <?php endif; ?></i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">NIVEAU : <?php echo e($donnee['bulletin']->classe_annee->classe->niveau->libelle); ?> </i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">FILIERE : <?php echo e($donnee['bulletin']->nom_classe); ?> </i>&nbsp;&nbsp;</b><br>
        <?php endif; ?>
        <?php if($section == '3' || $section == '4'): ?>
        
            <b><i style="font-size: 13px; margin: 5px;">SEMESTRE : <?php echo e($donnee['bulletin']->periode); ?></i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">SECTION :  <?php if($section == '1'): ?> Primaire <?php elseif($section == '2'): ?> Sécondaire <?php elseif($section == '3'): ?> Supérieur <?php endif; ?></i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;"><?php echo e($etablissement->name); ?></i></b><br>
        <?php endif; ?>
        </div>
    </div>
               

    <!-- titre du bulletin -->
    <div style="background-color: grey;margin-left: 250px; width: 210px; height: 30px; margin-top: 150px;">
        <b style="font-size: 20px;">BULLETIN DE NOTES</b> 
    </div>
    

    <div style="margin-top: 10px; position:absolute">
    <b style="font-size: 13px;">Matricule :</b> <?php echo e($donnee['bulletin']->matricule_apprenant); ?> <br>

        <!-- <b style="font-size: 13px;">Prof responsable de la classe : <span style="color:green">NON DEFINI</span></b> <br> -->
        <b style="font-size: 13px;">Moyenne obtenue : <?php echo e($donnee['bulletin']->moyenne_details_notes); ?> / 20</b>
    </div>
    <div style="margin-top: 10px; margin-left: 400px; position:absolute">
        <!-- <b style="font-size: 13px;">Prof responsable de la classe : <span style="color:green">NON DEFINI</span></b> <br> -->
        <b style="font-size: 13px;">Nom et Prénom de l'étudiant :</b> <?php echo e($donnee['bulletin']->nom_prenom_apprenant); ?> <br>

        <!-- <b style="font-size: 13px;">Rang : <?php echo e($donnee['bulletin']->rang); ?>e</b> -->
    </div>

    <table style="margin-top: 60px; position:absolute; font-size: 13px;text-align:center;">
    <thead>
        <tr>
            <th>Unités d'Enseignement</th>
            <th colspan="2">Matieres constitutives de l'UE</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <!-- <td>Code</td> -->
            <td>Intitulé</td>
            <!-- <td>Crédit</td> -->
            <td>Intitulés</td>
            <td>Crédit / Note</td>
        </tr>
        <!-- les données -->
        <?php $__currentLoopData = $donnee['bulletin']->groupUe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nom => $ue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <!-- <td>101</td> -->
            <td><?php echo e($nom); ?></td>
            <!-- <td>5</td> -->
            <td colspan="2">
                <table>
                <?php $__currentLoopData = $ue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($ligne->nom_matiere); ?></td>
                        <td style="text-align:center;"><?php echo e($ligne->coefficient); ?></td>
                        <td style="text-align:center;"><?php echo e($ligne->note_generale); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <!-- les données -->

        <!-- Ajoutez d'autres lignes de données au besoin -->
    </tbody>
</table>
</body>
</html>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\Users\MAHAMADOU\OneDrive\Documents\projet_synetcom\system_1\school\school-system\resources\views\superieur\bulletin_par_classe.blade.php ENDPATH**/ ?>