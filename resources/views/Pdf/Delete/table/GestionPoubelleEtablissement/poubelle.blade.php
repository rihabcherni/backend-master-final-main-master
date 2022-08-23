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
            .img-container{
                border-radius: 20px;
                border:2px rgb(198, 106, 210) dashed;
                width: 180px;
                height: 180px;
                margin-left: 20px;
            }
            .page{
                padding:20px;
            }
            .table1{
                margin:0  0 0 240px;
                margin-top: -180px;
            }
            .table2{
                margin:0  0 0 240px;
                margin-top: 15px;
            }
            .table3{
                margin-top: -150px;
            }
            .table4{
                margin:30px 0 0 22% ;
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
        <h2 style="text-align: center;">Liste des poubelles supprimés: </h2>
        <br/>
        <table>
            <tr>
                <th colspan="3">Reschool</th>
                <th colspan="3">Etablissement</th>
                <th colspan="3">Détails poubelle</th>
                <th colspan="3">Détails emplacement poubelle</th>
                <th colspan="3">Date</th>
            </tr>
            <tr>
                <th>N°</th>
                <th>Nom</th>
                <th>N° bloc poubelle</th>

                <th>N°</th>
                <th>Nom</th>
                <th>N°  bloc poubelle</th>

                <th>Type</th>
                <th>Etat</th>
                <th>Quantité</th>

                <th>Etablissement</th>
                <th>Bloc etablissement</th>
                <th>Etage</th>
                <th>Crée le</th>
                <th>Modifié le</th>
                <th style='background-color:red; color:white;'>Supprimé le</th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td> {{ $l['id'] }}</td>
                <td> {{ $l['nom'] }}</td>
                <td> {{ $l['bloc_poubelle_id'] }}</td>

                <td> {{ $l['poubelle_id_resp'] }}</td>
                <td> {{ $l['nom_poubelle_responsable'] }}</td>
                <td> {{ $l['bloc_poubelle_id_resp'] }}</td>

                <td> {{ $l['type'] }}</td>
                <td> {{ $l['Etat'] }}%</td>
                <td> {{ $l['quantite'] }}KG</td>

                <td> {{ $l['etablissement'] }}</td>
                <td> {{ $l['bloc_etablissement'] }}</td>
                <td> {{ $l['etage'] }}</td>
                <td> {{ $l['created_at'] }}</td>
                <td> {{ $l['updated_at'] }}</td>
                <td style='color:red; font-weight:bold;'> {{ $l['deleted_at'] }}</td>
            </tr>
            @endforeach
        </table>

    </body>
</html>
