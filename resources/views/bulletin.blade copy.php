@foreach ($items as $item)
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin</title>
</head>
<body>
    <!-- Entete de page -->
    <!-- <div style="background-image:url(test2.jpg)"> -->
        <div id="filigrane">
        <table style="font-size: 13px;margin-left: 5px; border:0;">
            <tr >
                <td style="text-align: left; border-right: 0; border-bottom: 0; border-left: 0; border-top:0" class="50p">
                    <b><i style="font-size: 13px; margin: 5px;">REPUBLIQUE DU NIGER</i></b><br>
                    <b><i style="font-size: 13px; margin: 5px;">MINISTERE DE L'EDUCATION NATIONALE</i></b><br>
                    <b><i style="font-size: 13px; margin: 5px;">DREN NIAMEY</i></b><br>
                    <b><i style="font-size: 13px; margin: 5px;">DDEN NIAMEY IV</i></b><br>
                    <b><i style="font-size: 13px; margin: 5px;">IESG NY IV</i></b><br>
                    <b><i style="font-size: 13px; margin: 5px;">CES NIAMEY 2000/I</i></b><br>
                </td>
                <td style="text-align: right; border-bottom:0; border-right: 0; border-top:0" class="50p">
                    <b><i style="font-size: 13px; margin: 5px;">ANNEE SCOLAIRE : 2023-2024</i>&nbsp;&nbsp;</b><br>
                    <b><i style="font-size: 13px; margin: 5px;">SEMESTRE : I</i>&nbsp;&nbsp;</b><br>
                    <b><i style="font-size: 13px; margin: 5px;">SECTION : Lycée</i>&nbsp;&nbsp;</b><br>
                    <b><i style="font-size: 13px; margin: 5px;">NIVEAU : TD</i>&nbsp;&nbsp;</b><br>
                    <b><i style="font-size: 13px; margin: 5px;">Rédouble : <span style="color:green">Jamais Rédoublé</span><span style="color:red">Seconde</span></i>&nbsp;&nbsp;</b><br>
                    
                </td>
            </tr>
        </table>
        <!-- fin entete de page  -->

        <!-- titre du bulletin -->
        <div style="background-color: grey;margin-left: 200px; width: 210px; height: 30px; margin-top: 25px;">
            <b style="font-size: 20px;">BULLETIN DE NOTES</b> 
        </div>
        <div style="margin-left: 230px; width: 210px; height: 30px; margin-top: 10px;">
            <b style="font-size: 20px;">Classe de : TD 1</b> 
        </div>
        <!-- fin titre du bulletin -->

        <!-- Informations sur le professeur et rang -->
        <div style="margin-top: 10px;">
            <b style="font-size: 13px;">Prof responsable de la classe : {% if profResponsable is defined %} {{profResponsable.nomUtilisateur|upper}} {{profResponsable.prenomUtilisateur|upper}} {% else%} <span style="color:green">NON DEFINI</span>{% endif %}</b> 
        </div>
        <div style="margin-top: 10px;">
            <b style="font-size: 13px;">Nom et Prénom de l'élève : {{eleve.idEleve.nomEleve|upper}} {{eleve.idEleve.prenomEleve|upper}}</b> 
        </div>
        <div style="margin-top: 10px;">
            <b style="font-size: 13px;">Moyenne obtenue : {{eleve.moyenne|number_format(2,',')}} / 20 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rang : {% if tabRang[eleve.idEleve.idEleve] == 1 %}{{tabRang[eleve.idEleve.idEleve]}}{% if eleve.idEleve.sexe == 'M'%}er{% else %}ere{% endif %}{% else %}{{tabRang[eleve.idEleve.idEleve]}}e{% endif %} / {% if nbreEleve == 1 %}{{nbreEleve}} élève {% else %}{{nbreEleve}} élèves {% endif %}</b>
        </div>
        {#{% if eleve.idEleve.sexe == 'M'%}er{% else %}ere{% endif %}{% else %}{{rangNote}}e{% endif %}#}
        {% set NP = eleve.moyenne %}
        <!-- Fin informations sur le professeur et rang -->

        <!-- Debut du tableau -->
        <table style="margin-top: 10px; font-size: 13px;">
            <thead>
                <tr style="text-align:center;" valign="center">
                    <th style="text-align: left;"><b>Disciplines</b></th>
                    <th width="30">MC<br>/20</th>
                    <th width="30">NC<br>/20</th>
                    <th width="30">MG<br>/20</th>
                    <th width="40">Coef</th>
                    <th width="70">Moy ceof</th>
                    <th width="25">Rang</th>
                    <th width="100">Appréciation</th>
                    <th width="100">Signature</th>
                </tr>
            </thead>
            <tbody>
                {% for note in notes %}
                {% for n in note %}
                {% if eleve.idEleve.idEleve == n.idEleve.idEleve %}
                    <tr>
                        <td><b>{{n.idMatiere.libelleMatiere}}</b></td>
                        
                        <td style="text-align:center;" width="30">{{n.noteClasse|number_format(2,',')}}</td>
                        <td style="text-align:center;" width="30">{{n.noteCompo|number_format(2,',')}}</td>
                        {% set MC = (((n.noteClasse + n.noteCompo)/2)*n.coefficient) %}
                        {% set MG = ((n.noteClasse + n.noteCompo)/2) %}
                        <td style="text-align:center;" width="30">{{MG|number_format(2,',')}}</td>
                        <td style="text-align:center;" width="40">{{n.coefficient}}</td>
                        <td style="text-align:center;" width="40">{{MC|number_format(2,',')}}</td>
                        <td style="text-align:center;" width="70"></td>
                        <td style="text-align:center;" width="100">{% if MG <= 2 %}NULL{% elseif (MG > 2 ) and MG <= 5 %}MAL{% elseif (MG > 5 ) and MG <= 9 %}INSUFFISANT{% elseif (MG > 9 ) and MG <= 15 %}BIEN{% elseif (MG > 15 ) and MG <= 19 %}TRES BIEN{% elseif (MG > 19 ) and MG == 20 %}PARFAIT{% endif %}</td>
                        <td style="text-align:center;" width="100"></td>
                    </tr>
                
                {% endif %}
                {% endfor %}
                {% endfor %}
                <tr>
                    <td><b>Total</b></td>
                    <td style="text-align:center" colspan="8">120</td>
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
                    <td style="text-align:center" colspan="8">13</td>
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
                    <input type="checkbox"><label>Bonne</label><br>
                    <input type="checkbox"><label>Avertissement</label><br>
                    <input type="checkbox"><label>Blâme</label><br>
                    <label></label><br>
                    <label></label><br>
                </td>
                <td width="153"  height="20" colspan=3>
                    <input type="checkbox" {% if (eleve.moyenne > 10 ) and eleve.moyenne <= 12 %} checked="checked" {% endif %}><label>Bien</label><br>
                    <input type="checkbox" {% if (eleve.moyenne > 9 ) and eleve.moyenne <= 10 %} checked="checked" {% endif %}><label>Passable</label><br>
                    <input type="checkbox" {% if (eleve.moyenne > 5 ) and eleve.moyenne <= 8 %} checked="checked" {% endif %}><label>Mal</label><br>
                    <input type="checkbox" {% if (eleve.moyenne > 3 ) and eleve.moyenne <= 5 %} checked="checked" {% endif %}><label>Avertissement</label><br>
                    <input type="checkbox" {% if (eleve.moyenne > 1 ) and eleve.moyenne <= 3 %} checked="checked" {% endif %}><label>Blâme</label><br>
                </td>
                <td width="153"  height="20" colspan=3>
                    <input type="checkbox"><label>Inscrit(e)</label><br>
                    <input type="checkbox"><label>Félicitation</label><br>
                    <input type="checkbox"><label>Encouragement</label><br>
                    <input type="checkbox"><label>Non inscrit(e)</label><br>
                    <label></label><br>
                </td>
                <td style="text-align:center" valign="center" width="153"  height="20" colspan=3><span style="color:green">R.A.S</span><span style="color:red;">2</span></td>
            </tr>
        </table>
        <!-- <div style="margin-top: 5px;">
            <b style="font-size: 13px;">Appréciation du proviseur&nbsp;</b> 
        </div> -->
        <table style="font-size: 13px;margin-left: 5px; border:0;">
            <tr >
                <td style="text-align: left; border-right: 0; border-bottom: 0; border-left: 0; border-top:0" class="50p">
                    <b style="font-size: 13px; margin: 5px;">Appréciation du proviseur</b><br>
                </td>
                <td style="text-align: center; border-bottom:0; border-right: 0; border-top:0" class="50p">
                    <b style="font-size: 13px; margin: 5px;">Visa des parents</b><br>
                </td>
            </tr>
        </table>
        

    <div style="margin-top: 15px;">

    </div>
</div>
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
        #filigrane{
            background-image: url(logo2.jpg);
            background-repeat: no-repeat;
            background-position: center; 
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
</body>
</html>
@endforeach