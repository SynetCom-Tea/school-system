
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
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
    
        .10p {
            width: 10%;
        }
        .15p {
            width: 15%;
        }
        .25p {
            width: 25%;
        }
        .50p {
            width: 50%;
        }
        .60p {
            width: 60%;
        }
        .75p {
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
            <b><i style="font-size: 13px; margin: 5px;">NIVEAU : {{$bulletin->classe_annee->classe->niveau->libelle}} </i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">FILIERE : {{$bulletin->nom_classe }} </i>&nbsp;&nbsp;</b><br>

            @endif
            
        </div>
        <div style="position:absolute;margin-top:10px;margin-left:300px">
        <img style="max-width:50%; height:auto" src="logos/iat-logo.png" alt="Logo de l'entreprise">
        </div>
        <div style="position:absolute;margin-top:10px;margin-left:480px">
        @if($section == '1' || $section == '2')
            <b><i style="font-size: 13px; margin: 5px;">ANNEE SCOLAIRE : {{$bulletin->classe_annee->annee->libelle}}</i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">SEMESTRE : {{$bulletin->periode }}</i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">SECTION :  @if($section == '1') Primaire @elseif($section == '2') Sécondaire @elseif($section == '3') Supérieur @endif</i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">NIVEAU : {{$bulletin->classe_annee->classe->niveau->libelle}} </i>&nbsp;&nbsp;</b><br>
            <b><i style="font-size: 13px; margin: 5px;">FILIERE : {{$bulletin->nom_classe }} </i>&nbsp;&nbsp;</b><br>
        @endif
        @if($section == '3' || $section == '4')
        
            <b><i style="font-size: 13px; margin: 5px;">SEMESTRE : {{$bulletin->periode }}</i>&nbsp;&nbsp;</b><br>
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
        <!-- <b style="font-size: 13px;">Prof responsable de la classe : <span style="color:green">NON DEFINI</span></b> <br> -->
        <b style="font-size: 13px;">Nom et Prénom de l'étudiant :</b> {{$bulletin->nom_prenom_apprenant }} <br>
        <b style="font-size: 13px;">Moyenne obtenue : {{$bulletin->moyenne_details_notes}} / 20</b>
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
        @foreach($bulletin->groupUe as $nom => $ue)
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
