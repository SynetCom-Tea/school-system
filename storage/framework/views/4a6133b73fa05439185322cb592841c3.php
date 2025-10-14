<?php $__currentLoopData = $donnees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donnee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin par classe</title>
</head>
<style>
        body {
            margin: 0;
            padding: 0;
        }
        .table1 {
            float: left; 
            font-weight: normal;
            font-size: 14px; 
            border-collapse: collapse;
        }
        .table2 {
           
            margin-left: 530px;
            font-weight: normal;
            font-size: 14px; 
            border-collapse: collapse;
        }
        tr {
            text-align: center;
        }
        td,
        th {
            border: 0.5px solid black;
    
        }
        .container {
            width: 95%;
            height: 70%;
            margin: 20px auto;
            background-color: #fff;
            border: 2px solid #333;
            border-radius: 15px;
            padding: 20px; /* Assure que le conteneur entoure les tableaux */
        }
        .justify {
            margin-top: 30px;
        }
        .middle {
            text-align: center;
        }
        .row {
            display: flex;
            justify-content: space-between;
            padding: 10px; /* Ajout d'un padding pour une meilleure lisibilité */
        }
    </style>
<body>
    <!-- Annee scolaire -->
    <div class="middle"><b>ANNEE SCOLAIRE: <?php echo e($donnee['bulletin']->classe_annee->annee->libelle); ?></b></div>
    <!-- Le nom de l'eleve de l'enseignant(e) et de la classe -->
    <div style="margin-top: 30px">
        <b>
            NOM DE L'ELEVE :
        </b> <?php echo e($donnee['bulletin']->nom_prenom_apprenant); ?> 
        <b style="margin-left: 100px">
            COURS : 
        </b> <?php echo e($donnee['bulletin']->classe_annee->classe->code); ?>

        <b style="margin-left: 70px">
            TENU PAR : 
        </b> Mme Hajia Aissa
    </div>
    <!-- le tableau recapitulatif -->
    <div class="container">
        <table class="table1">
            <thead>
                <tr>
                    <th colspan="2" width="90" height="35">Matiere d'education & d'enseignement</th>
                    <th width="25">Oct</th>
                    <th width="25">Nov</th>
                    <th width="25">Dec</th>
                    <th width="25">Jan</th>
                    <th width="25">Fev</th>
                    <th width="25">Mar</th>
                    <th width="25">Avr</th>
                    <th width="25">Mai</th>
                    <th width="25">Jui</th>
                    <th width="25">M.A</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" width="90" height="20">Nombre d'absence (en demi-journée)</td>
                    <td width="25"></td>
                    <td width="10"></td>
                    <td width="25"></td>
                    <td width="25"></td>
                    <td width="25"></td>
                    <td width="25"></td>
                    <td width="25"></td>
                    <td width="25"></td>
                    <td width="25"></td>
                    <td width="25"></td>
                </tr>
                <!-- debut de la boucle -->
                <?php $__currentLoopData = $donnee['detail']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td width="90" height="20"><?php echo e($note->nom_matiere); ?></td>
                    <td width="25"><?php echo e($note->notation_matiere); ?></td>
                    <td width="10"><?php if($donnee['bulletin']->periode == 'Octobre'): ?> <?php echo e($note->note); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Novembre'): ?> <?php echo e($note->note); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Décembre'): ?> <?php echo e($note->note); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Janvier'): ?> <?php echo e($note->note); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Février'): ?> <?php echo e($note->note); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Mars'): ?> <?php echo e($note->note); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Avril'): ?> <?php echo e($note->note); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Mai'): ?> <?php echo e($note->note); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Juin'): ?> <?php echo e($note->note); ?> <?php endif; ?></td>
                    <td></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <!-- Fin de la boucle -->
                <tr>
                    <td width="90" height="20">TOTAL SUR</td>
                    <td width="25"><?php echo e($total_notation); ?></td>
                    <td width="10"><?php if($donnee['bulletin']->periode == 'Octobre'): ?> <?php echo e($total_point); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Novembre'): ?> <?php echo e($total_point); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Décembre'): ?> <?php echo e($total_point); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Janvier'): ?> <?php echo e($total_point); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Février'): ?> <?php echo e($total_point); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Mars'): ?> <?php echo e($total_point); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Avril'): ?> <?php echo e($total_point); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Mai'): ?> <?php echo e($total_point); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Juin'): ?> <?php echo e($total_point); ?> <?php endif; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td width="90" height="20">MOYENNE SUR</td>
                    <td width="25">10</td>
                    <td width="10"><?php if($donnee['bulletin']->periode == 'Octobre'): ?> <?php echo e($donnee['bulletin']->moyenne_details_notes); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Novembre'): ?> <?php echo e($donnee['bulletin']->moyenne_details_notes); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Décembre'): ?> <?php echo e($donnee['bulletin']->moyenne_details_notes); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Janvier'): ?> <?php echo e($donnee['bulletin']->moyenne_details_notes); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Février'): ?> <?php echo e($donnee['bulletin']->moyenne_details_notes); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Mars'): ?> <?php echo e($donnee['bulletin']->moyenne_details_notes); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Avril'): ?> <?php echo e($donnee['bulletin']->moyenne_details_notes); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Mai'): ?> <?php echo e($donnee['bulletin']->moyenne_details_notes); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Juin'): ?> <?php echo e($donnee['bulletin']->moyenne_details_notes); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Juin'): ?> Pas definie <?php endif; ?></td>
                </tr>
                <tr>
                    <td width="90" height="20">RANG DE MERITE</td>
                    <td width="25"></td>
                    <td width="10"><?php if($donnee['bulletin']->periode == 'Octobre'): ?> <?php echo e($donnee['bulletin']->rang); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Novembre'): ?> <?php echo e($donnee['bulletin']->rang); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Décembre'): ?> <?php echo e($donnee['bulletin']->rang); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Janvier'): ?> <?php echo e($donnee['bulletin']->rang); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Février'): ?> <?php echo e($donnee['bulletin']->rang); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Mars'): ?> <?php echo e($donnee['bulletin']->rang); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Avril'): ?> <?php echo e($donnee['bulletin']->rang); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Mai'): ?> <?php echo e($donnee['bulletin']->rang); ?> <?php endif; ?></td>
                    <td><?php if($donnee['bulletin']->periode == 'Juin'): ?> <?php echo e($donnee['bulletin']->rang); ?> <?php endif; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td height="63" width="90">RESULTAT DE FIN D'ANNEE</td>
                    <td colspan="11" width="25"><p><?php if($donnee['bulletin']->periode == 'Juin'): ?> Admis au CP à la rentrée d'Octobre 2024 <?php endif; ?></p></td>
                </tr>
            </tbody>
        </table>
        <table class="table2">
            <thead>
                <tr>
                    <th width="50" height="35">MOIS</th>
                    <th width="120">Observation. Inst </th>
                    <th width="80">VISA Instituteur</th>
                    <th width="80">VISA des Parents</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="50" height="35">Octobre</td>
                    <td width="120"></td>
                    <td width="80"></td>
                    <td width="80"></td>
                </tr>
                <tr>
                    <td width="50" height="35">Novembre</td>
                    <td width="120"></td>
                    <td width="80"></td>
                    <td width="80"></td>
                </tr>
                <tr>
                    <td width="50" height="35">Décembre</td>
                    <td width="120"></td>
                    <td width="80"></td>
                    <td width="80"></td>
                </tr>
                <tr>
                    <td width="50" height="35">Janvier</td>
                    <td width="120"></td>
                    <td width="80"></td>
                    <td width="80"></td>
                </tr>
                <tr>
                    <td width="50" height="35">Février</td>
                    <td width="120"></td>
                    <td width="80"></td>
                    <td width="80"></td>
                </tr>
                <tr>
                    <td width="50" height="35">Mars</td>
                    <td width="120"></td>
                    <td width="80"></td>
                    <td width="80"></td>
                </tr>
                <tr>
                    <td width="50" height="35">Avril</td>
                    <td width="120"></td>
                    <td width="80"></td>
                    <td width="80"></td>
                </tr>
                <tr>
                    <td width="50" height="35">Mai</td>
                    <td width="120"></td>
                    <td width="80"></td>
                    <td width="80"></td>
                </tr>
                <tr>
                    <td width="50" height="35">Juin</td>
                    <td width="120"></td>
                    <td width="80"></td>
                    <td width="80"></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\Users\MAHAMADOU\OneDrive\Documents\projet_synetcom\system_1\school\school-system\resources\views\primaire\bulletin_par_classe.blade.php ENDPATH**/ ?>