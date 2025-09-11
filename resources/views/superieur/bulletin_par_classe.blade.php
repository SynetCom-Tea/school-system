@foreach($donnees as $donnee)
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
            @if($section == '1' || $section == '2')
            <b><i style="font-size: 13px; margin: 5px;">REPUBLIQUE DU NIGER</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">MINISTERE DE L'EDUCATION NATIONALE</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">DREN NIAMEY</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">DDEN NIAMEY IV</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">IESG NY IV</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">{{ $etablissement->name}}</i></b><br>
            @endif
            @if($section == '3' || $section == '4')
            <b><i style="font-size: 13px; margin: 5px;">REPUBLIQUE DU NIGER</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">MINISTERE DE L'ENSEIGNEMENT SUPERIEUR</i></b><br>
            <b><i style="font-size: 13px; margin: 5px;">NIVEAU : {{$donnee['bulletin']->classe_annee->classe->niveau->libelle}} </i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">FILIERE : {{$donnee['bulletin']->nom_classe }} </i>&nbsp;&nbsp;</b><br>

            @endif
            
        </div>
        <div style="position:absolute;margin-top:10px;margin-left:300px">
            @if($etablissement->logo === null)
            <img style="max-width:50%; height:auto" src="team.png" alt="Logo de l'entreprise">
            @else
            <img style="max-width:50%; height:auto" src="logos/{{$etablissement->logo}}" alt="Logo de l'entreprise">
            @endif
        </div>
        <div style="position:absolute;margin-top:10px;margin-left:480px">
        @if($section == '1' || $section == '2')
            <b><i style="font-size: 13px; margin: 5px;">ANNEE SCOLAIRE : {{$donnee['bulletin']->classe_annee->annee->libelle}}</i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">SEMESTRE : {{$donnee['bulletin']->periode }}</i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">SECTION :  @if($section == '1') Primaire @elseif($section == '2') Sécondaire @elseif($section == '3') Supérieur @endif</i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">NIVEAU : {{$donnee['bulletin']->classe_annee->classe->niveau->libelle}} </i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">FILIERE : {{$donnee['bulletin']->nom_classe }} </i>&nbsp;&nbsp;</b><br>
        @endif
        @if($section == '3' || $section == '4')
        
            <b><i style="font-size: 13px; margin: 5px;">SEMESTRE : {{$donnee['bulletin']->periode }}</i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">SECTION :  @if($section == '1') Primaire @elseif($section == '2') Sécondaire @elseif($section == '3') Supérieur @endif</i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">{{ $etablissement->name}}</i></b><br>
        @endif
        </div>
    </div>
               

    <!-- titre du bulletin -->
    <div style="background-color: grey;margin-left: 250px; width: 210px; height: 30px; margin-top: 150px;">
        <b style="font-size: 20px;">BULLETIN DE NOTES</b> 
    </div>
    

    <div style="margin-top: 10px; position:absolute">
    <b style="font-size: 13px;">Matricule :</b> {{$donnee['bulletin']->matricule_apprenant }} <br>

        <!-- <b style="font-size: 13px;">Prof responsable de la classe : <span style="color:green">NON DEFINI</span></b> <br> -->
        <b style="font-size: 13px;">Moyenne obtenue : {{$donnee['bulletin']->moyenne_details_notes}} / 20</b>
    </div>
    <div style="margin-top: 10px; margin-left: 400px; position:absolute">
        <!-- <b style="font-size: 13px;">Prof responsable de la classe : <span style="color:green">NON DEFINI</span></b> <br> -->
        <b style="font-size: 13px;">Nom et Prénom de l'étudiant :</b> {{$donnee['bulletin']->nom_prenom_apprenant }} <br>

        <!-- <b style="font-size: 13px;">Rang : {{$donnee['bulletin']->rang}}e</b> -->
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
        @foreach($donnee['bulletin']->groupUe as $nom => $ue)
        <tr>
            <!-- <td>101</td> -->
            <td>{{$nom}}</td>
            <!-- <td>5</td> -->
            <td colspan="2">
                <table>
                @foreach($ue as $ligne)
                    <tr>
                        <td>{{$ligne->nom_matiere}}</td>
                        <td style="text-align:center;">{{$ligne->coefficient}}</td>
                        <td style="text-align:center;">{{$ligne->note_generale}}</td>
                    </tr>
                @endforeach
                </table>
            </td>
        </tr>
        @endforeach
        <!-- les données -->

        <!-- Ajoutez d'autres lignes de données au besoin -->
    </tbody>
</table>
</body>
</html>
@endforeach
