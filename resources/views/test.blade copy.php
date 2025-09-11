
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin par étudiant</title>
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
<table>
  <caption>Articles vendus Août 2016</caption>
  <tbody>
    <tr>
      <td></td>
      <td></td>
      <th colspan="3" scope="colgroup">Vêtements</th>
      <th colspan="2" scope="colgroup">Accessoires</th>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <th scope="col">Pantalons</th>
      <th scope="col">Jupes</th>
      <th scope="col">Robes</th>
      <th scope="col">Bracelets</th>
      <th scope="col">Bagues</th>
    </tr>
    <tr>
      <th rowspan="3" scope="rowgroup">Belgique</th>
      <th scope="row">Anvers</th>
      <td>56</td>
      <td>22</td>
      <td>43</td>
      <td>72</td>
      <td>23</td>
    </tr>
    <tr>
      <th scope="row">Gand</th>
      <td>46</td>
      <td>18</td>
      <td>50</td>
      <td>61</td>
      <td>15</td>
    </tr>
    <tr>
      <th scope="row">Bruxelles</th>
      <td>51</td>
      <td>27</td>
      <td>38</td>
      <td>69</td>
      <td>28</td>
    </tr>
    <tr>
      <th rowspan="2" scope="rowgroup">Pays-Bas</th>
      <th scope="row">Amsterdam</th>
      <td>89</td>
      <td>34</td>
      <td>69</td>
      <td>85</td>
      <td>38</td>
    </tr>
    <tr>
      <th scope="row">Utrecht</th>
      <td>80</td>
      <td>12</td>
      <td>43</td>
      <td>36</td>
      <td>19</td>
    </tr>
  </tbody>
</table>
</body>
</html>