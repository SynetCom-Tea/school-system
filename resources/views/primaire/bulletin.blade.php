<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
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
    <div class="middle"><b>ANNEE SCOLAIRE: 2023-2024</b></div>
    <!-- Le nom de l'eleve de l'enseignant(e) et de la classe -->
    <div style="margin-top: 30px">
        <b>
            NOM DE L'ELEVE :
        </b> Mahaman Nouri Ousmane Ismael 
        <b style="margin-left: 100px">
            COURS : 
        </b> CI
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
                @foreach($notes as $note)
                <tr>
                    <td width="90" height="20">{{$note['nom_matiere']}}</td>
                    <td width="25">{{$note['notation_matiere']}}</td>
                    <td width="10"></td>
                    <td></td>
                    <td>@if($bulletin['periode'] == 'Trimestre I') {{$note['note']}} @endif</td>
                    <td></td>
                    <td></td>
                    <td>@if($bulletin['periode'] == 'Trimestre II') {{$note['note']}} @endif</td>
                    <td></td>
                    <td></td>
                    <td>@if($bulletin['periode'] == 'Trimestre III') {{$note['note']}} @endif</td>
                    <td></td>
                </tr>
                @endforeach
                <!-- Fin de la boucle -->
                <tr>
                    <td width="90" height="20">TOTAL SUR</td>
                    <td width="25">{{$total_notation}}</td>
                    <td width="10"></td>
                    <td></td>
                    <td>@if($bulletin['periode'] == 'Trimestre I') {{$total_point}} @endif</td>
                    <td></td>
                    <td></td>
                    <td>@if($bulletin['periode'] == 'Trimestre II') {{$total_point}} @endif</td>
                    <td></td>
                    <td></td>
                    <td>@if($bulletin['periode'] == 'Trimestre III') {{$total_point}} @endif</td>
                    <td></td>
                </tr>
                <tr>
                    <td width="90" height="20">MOYENNE SUR</td>
                    <td width="25">10</td>
                    <td width="10"></td>
                    <td></td>
                    <td>@if($bulletin['periode'] == 'Trimestre I') {{$bulletin['moyenne']}} @endif</td>
                    <td></td>
                    <td></td>
                    <td>@if($bulletin['periode'] == 'Trimestre II') {{$bulletin['moyenne']}} @endif</td>
                    <td></td>
                    <td></td>
                    <td>@if($bulletin['periode'] == 'Trimestre III') {{$bulletin['moyenne']}} @endif</td>
                    <td>@if($bulletin['periode'] == 'Trimestre III') Pas definie @endif</td>
                </tr>
                <tr>
                    <td width="90" height="20">RANG DE MERITE</td>
                    <td width="25"></td>
                    <td width="10"></td>
                    <td></td>
                    <td>@if($bulletin['periode'] == 'Trimestre I') {{$bulletin['rang']}} @endif</td>
                    <td></td>
                    <td></td>
                    <td>@if($bulletin['periode'] == 'Trimestre II') {{$bulletin['rang']}} @endif</td>
                    <td></td>
                    <td></td>
                    <td>@if($bulletin['periode'] == 'Trimestre III') {{$bulletin['rang']}} @endif</td>
                    <td></td>
                </tr>
                <tr>
                    <td height="63" width="90">RESULTAT DE FIN D'ANNEE</td>
                    <td colspan="11" width="25"><p>Admis au CP à la rentrée d'Octobre 2024</p></td>
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