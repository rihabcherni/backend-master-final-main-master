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
        <h2 style="text-align: center;">Liste des etages des établissements: </h2>
        <table>
            <tr>
                <th>Id:</th>
                <th style="background-color: red; color:white;">Etage:</th>
                <th>Bloc établissement:</th>
                <th>Etablissement:</th>
                <th>Liste blocs poubelles:</th>
                <th>Date de création:</th>
                <th>Date de dernier modification: </th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td> {{ $l['id'] }}</td>
                <td style="color:red;">{{ $l['nom_etage_etablissement'] }}</td>
                <td>{{ $l['bloc_etablissement'] }}</td>
                <td>{{ $l['etablissement'] }}</td>
               <td>
                    @foreach ($l['bloc_poubelles'] as $bloc)
                       Bloc n°: {{ $bloc->id }}<br/>
                    @endforeach
                </td>
                <td>{{ $l['created_at'] }}</td>
                <td>{{ $l['updated_at'] }}</td>
            </tr>
            @endforeach
        </table>

    </body>
</html>
