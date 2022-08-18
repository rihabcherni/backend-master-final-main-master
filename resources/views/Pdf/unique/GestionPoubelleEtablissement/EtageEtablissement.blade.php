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
        <h2 style="text-align: center;">Détails etage établissement: {{$nom_etage_etablissement}}</h2>
        <br/>
        <div>
            <table>
                <tr>
                    <th>Identifiant:</th>
                    <td>{{$id}}</td>
                </tr>
                <tr>
                    <th>Nom etage:</th>
                    <td>{{$nom_etage_etablissement}}</td>
                </tr>
                <tr>
                    <th>Nom bloc établissement:</th>
                    <td>{{$bloc_etablissement}}</td>
                </tr>
                <tr>
                    <th>Nom établissement:</th>
                    <td>{{$etablissement}}</td>
                </tr>
                <tr>
                    <th>Blocs poubelles:</th>
                    <td>
                        @foreach ($bloc_poubelles as $bloc)
                            Numéro: {{ $bloc->id }} <br/>
                        @endforeach
                    </td>
                </tr>

                <tr>
                    <th>Date de création:</th>
                    <td>{{$created_at}}</td>
                </tr>
                <tr>
                    <th>Date de dernier modification: </th>
                    <td>{{$updated_at}}</td>
                </tr>
            </table>
        </div>
    </body>
</html>
