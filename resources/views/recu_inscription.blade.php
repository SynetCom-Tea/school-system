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
            @if($etablissement->logo === null)
            <img style="max-width:30%; height: 11%;" src="logos/defaultLogo.png" alt="Logo de l'entreprise">
            @else
            <img style="max-width:30%; height:11%" src="logos/{{$etablissement->logo}}" alt="Logo de l'entreprise">
            @endif
        </div>
        <p style="margin-bottom: 20px; text-align:center; margin-top:-120px;">
       
            <b style="margin-top: -10px;"><strong>{{$etablissement->name}}</strong></b><br>
            <b style="margin-top: 5px;">Rue de {{$etablissement->adresse}}</b><br>
            <b style="margin-top: 5px;">Tel: {{$etablissement->telephone}}</b><br>
            <b style="margin-top: 5px;">{{$etablissement->ville}}-Niger</b>
      
        </p>
        <br>
        <br>
        <br>
        <div class="dotted-line"></div>
        <h1>Reçu d'inscription</h1>
        <h1 style="font-size: 16px;">Date de l'inscription: {{$inscription->date_inscription}}</h1>
        <p><span style="float: left;">Nom & Prénom: <strong>{{$inscription->apprenant->nom}} {{$inscription->apprenant->prenom}}</strong></span> &nbsp; <span style="float:right;">Référence de l'inscription: <strong>{{$inscription->apprenant->matricule}}</strong></span> </p>
       
       
        <div class="info">
            <p>Année Scolaire: {{$inscription->annee->libelle}}</p>
            @if($section == '1' || $section == '2')
            <p>Niveau: {{$inscription->niveau->code}} </p>
            @else
            <p>Section: {{$inscription->niveau->code}} {{$inscription->cycleFiliere->code}} </p>
            @endif
        </div>
         <p style="text-align: center; margin-top: 20px;">Merci pour votre inscription!</p>      
    </div>
</body>
</html>