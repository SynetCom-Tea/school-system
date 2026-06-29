@foreach($donnees as $donnee)
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Bulletin CSP AVENIR 3</title>
    <style>
        @page {
            margin: 15px;
        }

        body {
            /* font-family: DejaVu Sans, sans-serif; */
            font-family: "Times New Roman", Times, serif;
            font-size: 13px;
            margin: 0;
            padding: 0;
            position: relative;
            min-height: 100vh;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 1px;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .no-border td,
        .no-border th {
            border: none;
        }

        .titre {
            background: #9bbb58;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            padding: 5px;
            margin: 5px 0;
            border-radius: 5px;
        }

        .section-title {
            background: #eee;
            font-weight: bold;
            padding: 3px;
        }

        .signature-box {
            height: 100px;
            vertical-align: top;
        }

        /* MODIFICATION PRINCIPALE ICI */
        .main-content {
            padding-bottom: 40px;
            /* Espace pour le footer */
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
            padding: 2px 0;
            border-top: 1px solid #ccc;
            background: white;
            width: 100%;
            font-weight: bold;
        }

        .footer-note {
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        .colomn_moyenne {
            font-weight: bold;
        }

        .titre-th {

            width: 60px;
        }

        .checkbox {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            margin-left: 5px;
            margin-right: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="main-content">
        <!-- EN-TETE -->
        <table class="no-border">
            <tr>
                <td width="20%" class="center">
                    @if($etablissement->logo)
                    <img style="border-radius: 100%;" src="{{ public_path('logos/'.$etablissement->logo) }}" width="140" height="140"><br>
                    @endif
                </td>
                <td width="60%" class="center">
                    <p style="font-size: 14px;">
                        <b>République du Niger</b><br>
                        Ministère de l'Éducation Nationale de l'Alphabétisation et de la Promotion des Langues. Région de Niamey / IESG Niamey 4<br>
                        <b style="font-size: 16px;">« {{ $etablissement->name}}/ AEROPORT »</b><br>
                    </p>
                    <!-- <b style="font-size: 13px;">Complexe Scolaire Privé « {{ $etablissement->name}} »</b><br> -->
                    <p style="margin-top: 15px">BP/Tél: 96295361</p>
                </td>
                <td width="20%"></td>
            </tr>
        </table>

        <div class="titre">BULLETIN DE NOTES DU {{ strtoupper($donnee['bulletin']->periode) }}</div>

        <!-- INFOS ELEVE -->
        <table>
            <tr style="font-size: 14px;">
                <td colspan="2"><b>Nom et Prénoms: {{$donnee['bulletin']->nom_prenom_apprenant}}</b> <br>
                    <b>Matricule</b> : {{$donnee['bulletin']->matricule_apprenant}}
                </td>
                <td><b>Année</b> : {{$donnee['bulletin']->annee_scolaire}} <br>
                    <b>Classe</b> : {{$donnee['bulletin']->nom_classe}} <br>
                    <b>Effectif</b> : {{$donnee['bulletin']->classe_effectif}} <br>
                    <b>Date</b> : {{$donnee['bulletin']->created_at->format('d-m-Y')}}
                </td>
            </tr>
        </table>

        <!-- TABLEAU NOTES -->
        <table>
            <thead>
                <tr class="center bold">
                    <th style="width: 145px;">Discipline</th>
                    <th>Coef</th>
                    <th class="titre-th">Moy. de Classe</th>
                    <th class="titre-th">Compo</th>
                    <th class="titre-th">Moy. /20</th>
                    <th class="titre-th">Moy. Coef.</th>
                    <th>Rang</th>
                    <th>Appréciations et Visas des Professeurs</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalCoef = 0;
                $totalMoyCoef = 0;
                @endphp
                @foreach($donnee['detail'] as $line)
                @php
                $totalCoef += $line->coefficient;
                $totalMoyCoef += $line->moyenne_coefficiente;
                @endphp
                <tr>
                    <td class="left">{{$line->nom_matiere}}</td>
                    <td class="center">{{$line->coefficient}}</td>
                    <td class="right">{{$line->note_de_classe}}</td>
                    <td class="right">{{$line->note_de_composition}}</td>
                    <td class="right">{{$line->moyenne}}</td>
                    <td class="right colomn_moyenne">{{$line->moyenne_coefficiente}}</td>
                    <td class="center">{{$line->rang_matiere}}</td>
                    <td class="left">
                        @if($line->moyenne <= 2)
                            NULL
                            @elseif(($line->moyenne > 2 ) and ($line->moyenne <= 5))
                                MAL
                                @elseif(($line->moyenne > 5 ) and ($line->moyenne < 10))
                                    INSUFFISANT
                                    @elseif (($line->moyenne >= 10 ) and ($line->moyenne < 12))
                                        PASSABLE
                                        @elseif (($line->moyenne >= 12 ) and ($line->moyenne < 14))
                                            ASSEZ BIEN
                                            @elseif (($line->moyenne >= 14 ) and ($line->moyenne < 16))
                                                BIEN
                                                @elseif (($line->moyenne >= 16 ) and ($line->moyenne <= 19 ))
                                                    TRES BIEN
                                                    @elseif (($line->moyenne > 19 ) and ($line->moyenne <= 20))
                                                        EXCELLENT
                                                        @else
                                                        Pas defini
                                                        @endif
                                                        </td>
                </tr>
                @endforeach
                <tr class="bold">
                    <td>TOTAL</td>
                    <td class="center">{{$totalCoef}}</td>
                    <td colspan="3"></td>
                    <td class="right">{{$totalMoyCoef}}</td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>

        <br>

        <!-- MOYENNE & RANG DE L'ELEVE -->
        <table>
            <tr class="section-title">
                <td style="width: 33%;" class="center">MOYENNE & RANG DE L'ELEVE</td>
                <td style="width: 34%;" class="center">RESULTATS DE LA CLASSE</td>
                <td style="width: 33%;" class="center">Mentions du Conseil des Prof.</td>
            </tr>
            <tr>
                <td style="height: 60px; width: 33%;">
                    <b>MOYENNE</b><br>
                    <span style="margin-left: 10px;">En chiffre : <b>{{$donnee['bulletin']->moyenne_details_notes}}</b><br></span>
                    <span style="margin-left: 10px;">En lettre: <b>{{ moyenneEnLettre($donnee['bulletin']->moyenne_details_notes) }}</b></span>
                    <br><br>
                    <b>RANG : {{$donnee['bulletin']->rang}}</b><br><br>
                </td>
                <td style="height: 60px; width: 34%;">
                    Plus forte moyenne : <b>{{$donnee['bulletin']->classe_forte_moyenne}}<br></b>
                    Plus faible moyenne : <b>{{$donnee['bulletin']->classe_faible_moyenne}}<br></b>
                    Moyenne classe : <b>{{$donnee['bulletin']->classe_moyenne}}<br><br></b>
                </td>
                <td style="height: 60px; width: 33%; vertical-align: top;">
                    <span class="checkbox">☐</span>Tableau d'honneur<br> <span class="checkbox">☐</span>Encouragement<br> <span class="checkbox">☐</span>Félicitation<br> <span class="checkbox">☐</span>Avertissement<br> <span class="checkbox">☐</span>Blâme<br><br>
                </td>
            </tr>
            <tr>
                <td style="width: 33%;">
                    Moyenne matières littéraires : <b>{{$donnee['bulletin']->moyenne_litteraire}}</b>
                </td>
                <td style="width: 34%;">

                    Moyenne matières scientifiques : <b>{{$donnee['bulletin']->moyenne_scientifique}}</b>
                </td>
                <td style="width: 33%;  vertical-align: top;">
                    Moyenne autres matières : <b>{{$donnee['bulletin']->moyenne_autres_matieres}}</b>
                </td>
            </tr>
        </table>

        <br>

        <!-- RÉSULTATS ANNUELS -->
        @php
        $bulletin = $donnee['bulletin'];
        $bulletinSemestre1 = $donnee['bulletin_semestre1'] ?? null;
        $moyenneSemestre1 = $bulletin->moyenne_semestre_1 ?? $bulletinSemestre1?->moyenne_details_notes ?? '';
        $rangSemestre1 = $bulletin->rang_semestre_1 ?? $bulletinSemestre1?->rang ?? '';
        $moyenneSemestre2 = $bulletin->moyenne_semestre_2 ?? $bulletin->moyenne_details_notes ?? '';
        $rangSemestre2 = $bulletin->rang_semestre_2 ?? $bulletin->rang ?? '';

        
        @endphp

        @if($donnee['bulletin']->moyenne_annuelle !== null)

        <h1 class="titre">RÉSULTATS ANNUELS</h1>
        <table>
            <tr class="section-title">
                <th style="padding: 5px;" class="center" colspan="2">Semestre I</th>
                <th style="padding: 5px;" class="center" colspan="2">Semestre II</th>
                <th style="padding: 5px;" class="center" colspan="2">Annuelle</th>
                <th>Plus faible moyenne de la classe</th>
                <th>Plus forte moyenne de la classe</th>
            </tr>
            <tr>
                <th>Moy</th>
                <th>Rang</th>
                <th>Moy</th>
                <th>Rang</th>
                <th>Moy</th>
                <th>Rang</th>
                <th rowspan="2">{{ $bulletin->plus_faible_moyenne_annuelle }}</th>
                <th rowspan="2">{{ $bulletin->plus_forte_moyenne_annuelle }}</th>
                
            </tr>
            <tr class="center">
                <td>{{ $moyenneSemestre1 }}</td>
                <td>{{ $rangSemestre1 }}</td>
                <td>{{ $moyenneSemestre2 }}</td>
                <td>{{ $rangSemestre2 }}</td>
                <td><b>{{ $bulletin->moyenne_annuelle }}</b></td>
                <td><b>{{ $bulletin->rang_annuel }}</b></td>
                
            </tr>

            <tr>
                <td colspan="8" class="center">
                    <b>{{ strtoupper(moyenneEnLettre($bulletin->moyenne_annuelle)) }}</b>
                </td>
            </tr>
        </table>

        @endif
        <br>
        <!-- ABSENCES ET RETARDS -->
        <table>
            <tr class="section-title">
                <td colspan="1" class="center">ABSENCES</td>
                <td colspan="1" class="center">RETARDS</td>
                <td colspan="6" class="center">Appréciations du chef d'Établissement</td>
            </tr>
            <tr>
                <td width="20%"><span class="checkbox">☐</span>Motivées: <br><br>
                    <span class="checkbox">☐</span>Non Motivées
                </td>
                <td width="20%"><span class="checkbox">☐</span>Motivées <br><br>
                    <span class="checkbox">☐</span>Non Motivées
                </td>
                <td colspan="6" class="center signature-box">
                    <div style="margin-top: 90px; font-style: italic">
                        <p><b>{{ $bulletin->chef_etablissement }}</b></p>
                    </div>
                </td>
            </tr>
        </table>

        <br>



        <!-- DERNIERE LIGNE AVEC PHRASE -->
        <table class="no-border">
            <tr>
                <td class="center" colspan="3">
                    <i>Votre Avenir, Notre souci</i>
                </td>
            </tr>
        </table>
    </div>

    <!-- FOOTER FIXE -->
    <footer class="footer">
        <p class="footer-note">
            NB : Conserver précieusement ce bulletin. Aucun double ne sera établi.
        </p>
        <p class="footer-note">
            Complexe Scolaire Privé « AVENIR 3 » - Aéroport-Niamey/Niger - Tél : 96 29 53 61</p>
    </footer>
</body>

</html>
@endforeach