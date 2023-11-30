<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin par élève</title>
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
    <div class="middle"><b>ANNEE SCOLAIRE: {{$bulletin->classe_annee->annee->libelle}}</b></div>
    <!-- Le nom de l'eleve de l'enseignant(e) et de la classe -->
    <div style="margin-top: 30px">
        <b>
            NOM DE L'ELEVE :
        </b> {{$bulletin->nom_prenom_apprenant}} 
        <b style="margin-left: 100px">
            COURS : 
        </b> {{$bulletin->classe_annee->classe->code}}
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
                    <td width="90" height="20">{{$note->nom_matiere}}</td>
                    <td width="25">{{$note->notation_matiere}}</td>
                    <td width="10">@if($bulletin->periode == 'Octobre') {{$note->note}} @endif</td>
                    <td>@if($bulletin->periode == 'Novembre') {{$note->note}} @endif</td>
                    <td>@if($bulletin->periode == 'Décembre') {{$note->note}} @endif</td>
                    <td>@if($bulletin->periode == 'Janvier') {{$note->note}} @endif</td>
                    <td>@if($bulletin->periode == 'Février') {{$note->note}} @endif</td>
                    <td>@if($bulletin->periode == 'Mars') {{$note->note}} @endif</td>
                    <td>@if($bulletin->periode == 'Avril') {{$note->note}} @endif</td>
                    <td>@if($bulletin->periode == 'Mai') {{$note->note}} @endif</td>
                    <td>@if($bulletin->periode == 'Juin') {{$note->note}} @endif</td>
                    <td></td>
                </tr>
                @endforeach
                <!-- Fin de la boucle -->
                <tr>
                    <td width="90" height="20">TOTAL SUR</td>
                    <td width="25">{{$total_notation}}</td>
                    <td width="10">@if($bulletin->periode == 'Octobre') {{$total_point}} @endif</td>
                    <td>@if($bulletin->periode == 'Novembre') {{$total_point}} @endif</td>
                    <td>@if($bulletin->periode == 'Décembre') {{$total_point}} @endif</td>
                    <td>@if($bulletin->periode == 'Janvier') {{$total_point}} @endif</td>
                    <td>@if($bulletin->periode == 'Février') {{$total_point}} @endif</td>
                    <td>@if($bulletin->periode == 'Mars') {{$total_point}} @endif</td>
                    <td>@if($bulletin->periode == 'Avril') {{$total_point}} @endif</td>
                    <td>@if($bulletin->periode == 'Mai') {{$total_point}} @endif</td>
                    <td>@if($bulletin->periode == 'Juin') {{$total_point}} @endif</td>
                    <td></td>
                </tr>
                <tr>
                    <td width="90" height="20">MOYENNE SUR</td>
                    <td width="25">10</td>
                    <td width="10">@if($bulletin->periode == 'Octobre') {{$bulletin->moyenne_details_notes}} @endif</td>
                    <td>@if($bulletin->periode == 'Novembre') {{$bulletin->moyenne_details_notes}} @endif</td>
                    <td>@if($bulletin->periode == 'Décembre') {{$bulletin->moyenne_details_notes}} @endif</td>
                    <td>@if($bulletin->periode == 'Janvier') {{$bulletin->moyenne_details_notes}} @endif</td>
                    <td>@if($bulletin->periode == 'Février') {{$bulletin->moyenne_details_notes}} @endif</td>
                    <td>@if($bulletin->periode == 'Mars') {{$bulletin->moyenne_details_notes}} @endif</td>
                    <td>@if($bulletin->periode == 'Avril') {{$bulletin->moyenne_details_notes}} @endif</td>
                    <td>@if($bulletin->periode == 'Mai') {{$bulletin->moyenne_details_notes}} @endif</td>
                    <td>@if($bulletin->periode == 'Juin') {{$bulletin->moyenne_details_notes}} @endif</td>
                    <td>@if($bulletin->periode == 'Juin') Pas definie @endif</td>
                </tr>
                <tr>
                    <td width="90" height="20">RANG DE MERITE</td>
                    <td width="25"></td>
                    <td width="10">@if($bulletin->periode == 'Octobre') {{$bulletin->rang}} @endif</td>
                    <td>@if($bulletin->periode == 'Novembre') {{$bulletin->rang}} @endif</td>
                    <td>@if($bulletin->periode == 'Décembre') {{$bulletin->rang}} @endif</td>
                    <td>@if($bulletin->periode == 'Janvier') {{$bulletin->rang}} @endif</td>
                    <td>@if($bulletin->periode == 'Février') {{$bulletin->rang}} @endif</td>
                    <td>@if($bulletin->periode == 'Mars') {{$bulletin->rang}} @endif</td>
                    <td>@if($bulletin->periode == 'Avril') {{$bulletin->rang}} @endif</td>
                    <td>@if($bulletin->periode == 'Mai') {{$bulletin->rang}} @endif</td>
                    <td>@if($bulletin->periode == 'Juin') {{$bulletin->rang}} @endif</td>
                    <td></td>
                </tr>
                <tr>
                    <td height="63" width="90">RESULTAT DE FIN D'ANNEE</td>
                    <td colspan="11" width="25"><p>@if($bulletin->periode == 'Juin') @if($bulletin->moyenne_details_notes >= 5) Admis(e) @else Non admis(e)  @endif  en classe Supérieure à la rentrée d'Octobre prochaine @endif</p></td>
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