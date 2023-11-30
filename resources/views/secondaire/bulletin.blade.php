
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin par élève</title>
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
        <b><i style="font-size: 13px; margin: 5px;">REPUBLIQUE DU NIGER</i></b><br>
                    <b><i style="font-size: 13px; margin: 5px;">MINISTERE DE L'EDUCATION NATIONALE</i></b><br>
                    <b><i style="font-size: 13px; margin: 5px;">DREN NIAMEY</i></b><br>
                    <b><i style="font-size: 13px; margin: 5px;">DDEN NIAMEY IV</i></b><br>
                    <b><i style="font-size: 13px; margin: 5px;">IESG NY IV</i></b><br>
                    <b><i style="font-size: 13px; margin: 5px;">{{ $etablissement->name}}</i></b><br>
        </div>
        <div style="position:absolute;margin-top:10px;margin-left:300px">
        <img style="max-width:50%; height:auto" src="logos/iat-logo.png" alt="Logo de l'entreprise">
        </div>
        <div style="position:absolute;margin-top:10px;margin-left:500px">
        <b><i style="font-size: 13px; margin: 5px;">ANNEE SCOLAIRE : 2023-2024</i>&nbsp;&nbsp;</b><br>
                    <b><i style="font-size: 13px; margin: 5px;">SEMESTRE : {{$bulletin->periode }}</i>&nbsp;&nbsp;</b><br>
                    <b><i style="font-size: 13px; margin: 5px;">SECTION : @if($section == '1') Primaire @elseif($section == '2' and $bulletin->classe_annee->classe->niveau->id <= 10) Collège @else Lycée @endif</i>&nbsp;&nbsp;</b><br>
                    <b><i style="font-size: 13px; margin: 5px;">NIVEAU : {{$bulletin->classe_annee->classe->niveau->libelle}}</i>&nbsp;&nbsp;</b><br>
                    <b><i style="font-size: 13px; margin: 5px;">Rédouble : <span style="color:green">Jamais Rédoublé</span></i>&nbsp;&nbsp;</b><br>
        </div>
    </div>
                <!-- <div style="text-align: left; border-right: 0; border-bottom: 0; border-left: 0; border-top:0" class="50p">
                    <b><i style="font-size: 13px; margin: 5px;">REPUBLIQUE DU NIGER</i></b><br>
                    <b><i style="font-size: 13px; margin: 5px;">MINISTERE DE L'EDUCATION NATIONALE</i></b><br>
                    <b><i style="font-size: 13px; margin: 5px;">DREN NIAMEY</i></b><br>
                    <b><i style="font-size: 13px; margin: 5px;">DDEN NIAMEY IV</i></b><br>
                    <b><i style="font-size: 13px; margin: 5px;">IESG NY IV</i></b><br>
                    <b><i style="font-size: 13px; margin: 5px;">{{ $etablissement->name}}</i></b><br>
                </div>
            
                <div style="text-align: right; border-bottom:0; border-right: 0; border-top:0" class="50p">
                    <b><i style="font-size: 13px; margin: 5px;">ANNEE SCOLAIRE : 2023-2024</i>&nbsp;&nbsp;</b><br>
                    <b><i style="font-size: 13px; margin: 5px;">SEMESTRE : I</i>&nbsp;&nbsp;</b><br>
                    <b><i style="font-size: 13px; margin: 5px;">SECTION : @if($section == '1') Primaire @elseif($section == '2' and $bulletin->classe_annee->classe->niveau->id <= 10) Collège @else Lycée @endif</i>&nbsp;&nbsp;</b><br>
                    <b><i style="font-size: 13px; margin: 5px;">NIVEAU : {{$bulletin->classe_annee->classe->niveau->code}}</i>&nbsp;&nbsp;</b><br>
                    <b><i style="font-size: 13px; margin: 5px;">Rédouble : <span style="color:green">Jamais Rédoublé</span></i>&nbsp;&nbsp;</b><br>
                </div>
                <div style="margin-bottom: 20px; position:relative text-align:right; margin-top:10px;">
                    <img style="max-width:30%; height:auto" src="team.png" alt="Logo de l'entreprise">
                </div> -->
           
        <!-- fin entete de page  -->

        <!-- titre du bulletin -->
        <div style="background-color: grey;margin-left: 250px; width: 210px; height: 30px; margin-top: 150px;">
            <b style="font-size: 20px;">BULLETIN DE NOTES</b> 
        </div>
        <div style="margin-left: 260px; width: 210px; height: 30px; margin-top: 10px;">
            <b style="font-size: 20px;">Classe de : {{$bulletin->nom_classe}}</b> 
        </div>
        <!-- fin titre du bulletin -->

        <!-- Informations sur le professeur et rang -->
        <div style="margin-top: 10px; position:absolute">
            <b style="font-size: 13px;">Prof responsable de la classe : <span style="color:green">NON DEFINI</span></b> <br>
            <b style="font-size: 13px;">Nom et Prénom de l'élève : {{$bulletin->nom_prenom_apprenant}}</b> <br>
            <b style="font-size: 13px;">Moyenne obtenue : {{$bulletin->moyenne_details_notes}} / 20</b>
        </div>
       
        <div style="margin-top: 10px; position:absolute ;margin-left:460px;">
            <b style="font-size: 13px;">Rang : {{ $bulletin->rang}}</b>
        </div>
       
        <!-- Fin informations sur le professeur et rang -->

        <!-- Debut du tableau -->
        <table style="margin-top: 100px; font-size: 13px; width:100%">
            <thead>
                <tr style="text-align:center;" valign="center">
                    <th style="text-align: left;"><b>Disciplines</b></th>
                    <th width="30">MC<br>/20</th>
                    <th width="30">NC<br>/20</th>
                    <th width="30">MG<br>/20</th>
                    <th width="35">Coef</th>
                    <th width="40">Moy ceof</th>
                    <th width="35">Rang</th>
                    <th width="70">Appréciation</th>
                    <th width="100">Signature</th>
                </tr>
            </thead>
            <tbody>
                @php
                $total = 0;
                @endphp
                @foreach($detail as $line)
                    @php
                        $total = $total + $line->moyenne_coefficiente;
                        $conduite = '';
                        if($line->nom_matiere == 'Conduite'){
                            $conduite = $line->note_de_classe;
                        }
                    @endphp
                    <tr>
                        <td><b>{{$line->nom_matiere}}</b></td>
                        <td style="text-align:center;" width="30">{{$line->note_de_classe}}</td>
                        <td style="text-align:center;" width="30">{{$line->note_de_composition}}</td>
                        <td style="text-align:center;" width="30">{{$line->moyenne}}</td>
                        <td style="text-align:center;" width="35">{{$line->coefficient}}</td>
                        <td style="text-align:center;" width="40">{{$line->moyenne_coefficiente}}</td>
                        <td style="text-align:center;" width="35"></td>
                        <td style="text-align:center;" width="70">
                            @if($line->moyenne <= 2)
                            NULL
                            @elseif(($line->moyenne > 2 ) and ($line->moyenne <= 5))
                            MAL
                            @elseif(($line->moyenne > 5 ) and ($line->moyenne <= 9))
                            INSUFFISANT
                            @elseif (($line->moyenne > 9 ) and ($line->moyenne <= 15))
                            BIEN
                            @elseif (($line->moyenne > 15 ) and ($line->moyenne <= 19 ))
                            TRES BIEN
                            @elseif (($line->moyenne > 19 ) and ($line->moyenne == 20))
                            PARFAIT
                            @else
                            Pas defini
                            @endif
                        </td>
                        <td style="text-align:center;" width="100"></td>
                    </tr>
                @endforeach
                
                <tr>
                    <td><b>Total</b></td>
                    <td style="text-align:center" colspan="8">{{$total}}</td>
                </tr>
                <tr>
                    <td><b>Moyenne de classe</b></td>
                    <td style="text-align:center" colspan="8">12</td>
                </tr>
                
                <tr>
                    <td><b>Moyenne 2e semestre</b></td>
                    <td style="text-align:center" colspan="8"></td>
                </tr>
                
                <tr>
                    <td><b>Moyenne 1er semestre</b></td>
                    <td style="text-align:center" colspan="8">{{$bulletin->moyenne_details_notes}}</td>
                </tr>
               
                <tr>
                    <td><b>Moyenne annuelle</b></td>
                    <td style="text-align:center" colspan="8"></td>
                </tr>
                
            </tbody>
        </table>
        <!-- Fin du tableau -->
        
        <!-- <div  style="background-image:url(test.jpg);width: 200px; padding-top:-400px;background-repeat:no-repeat;background-position: center center;filter:alpha(opacity=50);opacity: 0.2;-moz-opacity:0.5">
        </div> -->
        
        <table style="font-size: 13px; margin-top: 10px;">
            <tr style="text-align:center;">
                <th width="153" colspan=3>Conduite</th>
                <th width="153" colspan=3>Travail</th>
                <th width="153" colspan=3>Tableau d'honneur</th>
                <th width="153" colspan=3>Assiduité / Retards</th>
            </tr>
           
            <tr>    
                <td width="153"  height="20" colspan=3>
                    @if($conduite <= 18)
                    <input checked="checked" type="checkbox"><label>Bonne</label><br>
                    <input type="checkbox"><label>Avertissement</label><br>
                    <input type="checkbox"><label>Blâme</label><br>
                    @elseif(($conduite > 12 ) and ($line->moyenne <= 15))
                    <input type="checkbox"><label>Bonne</label><br>
                    <input checked="checked" type="checkbox"><label>Avertissement</label><br>
                    <input type="checkbox"><label>Blâme</label><br>
                    @elseif(($line->moyenne < 11 ))
                    <input type="checkbox"><label>Bonne</label><br>
                    <input type="checkbox"><label>Avertissement</label><br>
                    <input checked="checked" type="checkbox"><label>Blâme</label><br>
                    @endif
                </td>
                <td width="153"  height="20" colspan=3>
                    <input type="checkbox" checked="checked"><label>Bien</label><br>
                </td>
                <td width="153"  height="20" colspan=3>
                    <input type="checkbox"><label>Inscrit(e)</label><br>
                    <input type="checkbox"><label>Félicitation</label><br>
                    <input type="checkbox"><label>Encouragement</label><br>
                    <input type="checkbox"><label>Non inscrit(e)</label><br>
                    <label></label><br>
                </td>
                <td style="text-align:center" valign="center" width="153"  height="20" colspan=3><span style="color:green">R.A.S </span> / <span style="color:red;">  2</span></td>
            </tr>
        </table>
        <!-- <div style="margin-top: 5px;">
            <b style="font-size: 13px;">Appréciation du proviseur&nbsp;</b> 
        </div> -->
        
        <div style="text-align: left; margin-top:20; position:absolute;">
            <b style="font-size: 13px; margin: 5px;">Appréciation du proviseur</b><br>
        </div>
        <div style="margin-left: 600px; position:absolute; margin-top:20">
            <b style="font-size: 13px; margin: 5px;">Visa des parents</b><br>
        </div>
   
    
</body>
</html>
