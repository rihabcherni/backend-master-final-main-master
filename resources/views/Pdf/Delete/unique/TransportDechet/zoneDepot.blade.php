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
    <body class="page"  >
        <img class="img-logo" src="{{ public_path('images/logo.png') }}" alt="logo" width="50px" height="50px"/>
        <p class='date'>{{ date('d-m-Y H:i:s') }}</p>
        <hr/>
        <h2 style="text-align: center;">Détails zone de depots numéro: {{ $id }}</h2>
        <div>
            <table class="table">
                <tr>
                    <th>Identifiant:</th>
                    <td>{{$id}}</td>
                </tr>
                <tr>
                    <th>Region:</th>
                    <td>{{$zone_travail->region}}</td>
                </tr>
                <tr>
                    <th>adresse:</th>
                    <td>{{$adresse}}</td>
                </tr>
                <tr>
                    <th>Longitude:</th>
                    <td>{{$longitude}}</td>
                </tr>
                <tr>
                    <th>Longitude:</th>
                    <td>{{$longitude}}</td>
                </tr>
                <tr>
                    <th>Quantité de depot maximale:</th>
                    <td>{{$quantite_depot_maximale}}</td>
                </tr>

                <tr>
                    <th rowspan="4">Quantité depot actuelle:</th>
                    <td style="color:blue;"><b>Plastique:</b> {{$quantite_depot_actuelle_plastique}} KG</td>
                </tr>
                <tr>
                    <td style="color:orange;"> <b>Papier:</b> {{$quantite_depot_actuelle_papier}} KG</td>
                </tr>
                <tr>
                    <td style="color:green;"><b>Composte:</b> {{$quantite_depot_actuelle_composte}} KG</td>
                </tr>
                <tr>
                    <td style="color:red;"><b>Canette:</b> {{$quantite_depot_actuelle_canette}} KG</td>
                </tr>

                <tr>
                    <th>Date de création:</th>
                    <td>{{$created_at}}</td>
                </tr>
                <tr>
                    <th>Date de dernier modification: </th>
                    <td>{{$updated_at}}</td>
                </tr>
                <tr>
                    <th style='background-color:red; color:white;'>Date de suppression</th>
                    <td style='color:red;'>{{$deleted_at}}</td>
                </tr>

            </table>
        </div>

    </body>
</html>
