<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style>
            .date{
                margin:-20px 0 0 75%  ;
            }
            .page{
                padding:20px;
            }
            table{
                border:1px solid;
            }
             td , th{
                border:1px solid;
                font-size:14px;
                padding:10px;
                text-align: left;
            }
        </style>
    </head>
    <body class="page">
        <img class="img-logo" src="{{ public_path('images/logo.png') }}" alt="logo" width="50px" height="50px"/>
        <p class='date'>{{ date('d-m-Y H:i:s') }}</p>
        <hr/>
        <br/>
        <h2 style="text-align: center;">Liste des zones de depots Reschool Ecology: </h2>        <br/>
        <table>
            <tr>
                <th rowspan="2">Id:</th>
                <th rowspan="2">Region travail:</th>
                <th rowspan="2">Adresse:</th>
                <th rowspan="2">Longitude:</th>
                <th rowspan="2">Latitude:</th>
                <th rowspan="2">Quantite depot maximale:</th>
                <th colspan="4">Quantite depot actuelle:</th>
                <th rowspan="2">Date de création:</th>
                <th rowspan="2">Date de dernier modification: </th>
                <th rowspan="2" style='background-color:red; color:white;'>Date de suppression</th>

            </tr>
            <tr>
                <th style="background-color: blue; color: white">Plastique:</th>
                <th style="background-color: orange; color: white">Papier:</th>
                <th style="background-color: green; color: white">Composte:</th>
                <th style="background-color: red; color: white">Canette:</th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td> {{ $l['id'] }}</td>
                <td> {{ $l['zone_travail']->region }}</td>
                <td> {{ $l['adresse'] }}</td>
                <td> {{ $l['longitude'] }}</td>
                <td> {{ $l['latitude'] }}</td>
                <td> {{ $l['quantite_depot_maximale'] }} KG</td>
                <td style="color: blue"> {{ $l['quantite_depot_actuelle_plastique'] }} KG</td>
                <td style="color: orange"> {{ $l['quantite_depot_actuelle_papier'] }} KG</td>
                <td style="color: green"> {{ $l['quantite_depot_actuelle_composte'] }} KG</td>
                <td style="color: red"> {{ $l['quantite_depot_actuelle_canette'] }} KG</td>
                <td>{{ $l['created_at'] }}</td>
                <td>{{ $l['updated_at'] }}</td>
                <td style='color:red; font-weight:bold;'> {{ $l['deleted_at'] }}</td>
            </tr>
            @endforeach
        </table>

    </body>
</html>
