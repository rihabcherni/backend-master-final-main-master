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
        <h2 style="text-align: center;">Liste des zones de travails Reschool Ecology: </h2>        <br/>
        <table>
            <tr>
                <th>Id:</th>
                <th>region</th>
                <td style='color:blue; font-weight:bold'>Quantité total collecté plastique</th>
                <td style='color:green; font-weight:bold'>Quantité total collecté composte</th>
                <td style='color:orange; font-weight:bold'>Quantité total collecté papier</th>
                <td style='color:red; font-weight:bold'>Quantité total collecté canette</th>
                <th>Date de création:</th>
                <th>Date de dernier modification: </th>
                <th style='background-color:red; color:white;'>Date de suppression</th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td> {{ $l['id'] }}</td>
                <td>{{ $l['region'] }}</td>
                <td style='color:blue; font-weight:bold'>{{ $l['quantite_total_collecte_plastique'] }}</td>
                <td style='color:green; font-weight:bold'>{{ $l['quantite_total_collecte_composte'] }}</td>
                <td style='color:orange; font-weight:bold'>{{ $l['quantite_total_collecte_papier'] }}</td>
                <td style='color:red; font-weight:bold'>{{ $l['quantite_total_collecte_canette'] }}</td>

                <td>{{ $l['created_at'] }}</td>
                <td>{{ $l['updated_at'] }}</td>
                <td style='color:red; font-weight:bold;'> {{ $l['deleted_at'] }}</td>
            </tr>
            @endforeach
        </table>

    </body>
</html>
