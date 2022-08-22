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
        <br/>
        <h2 style="text-align: center;">Détails zone travail:{{ $region }}<h2>
        <br/>
        <div>
             <table>
                <tr>
                    <th>Identifiant:</th>
                    <td colspan="2">{{$id}}</td>
                </tr>
                <tr>
                    <th>Region:</th>
                    <td colspan="2">{{$region}}</td>
                </tr>
                <tr>
                    <th rowspan="4">Quantité totale collecté:</th>
                    <th style="color:blue;">Plastique:</th>
                    <td style="color:blue;">{{$quantite_total_collecte_plastique}} KG</td>
                </tr>
                <tr>
                    <th style="color:green;">Composte:</th>
                    <td style="color:green;">{{$quantite_total_collecte_composte}} KG</td>
                </tr>
                <tr>
                    <th style="color:orange;">Papier:</th>
                    <td style="color:orange;">{{$quantite_total_collecte_papier}} KG</td>
                </tr>
                <tr>
                    <th style="color:red;">Canette:</th>
                    <td style="color:red;">{{$quantite_total_collecte_canette}} KG</td>
                </tr>

                <tr>
                    <th>Date de création:</th>
                    <td colspan="2">{{$created_at}}</td>
                </tr>
                <tr>
                    <th>Date de dernier modification: </th>
                    <td colspan="2">{{$updated_at}}</td>
                </tr>
            </table>
        </div>

    </body>
</html>
