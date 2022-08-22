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
        <h2 style="text-align: center;">Détails vider poubelle ---- à la date ----: </h2>
        <br/>
        <div>
            <table>
                <tr>
                    <th>Identifiant:</th>
                    <td>{{$id}}</td>
                </tr>
                <tr>
                    <th>ID poubelle:</th>
                    <td>{{$poubelle_id}}</td>
                </tr>
                <tr>
                    <th>Nom poubelle:</th>
                    <td>{{$poubelle_nom}}</td>
                </tr>
                <tr>
                    <th>Type poubelle:</th>
                    <td>{{$type_poubelle}}</td>
                </tr>
                <tr>
                    <th>Taux remplissage lors de vider poubelle:</th>
                    <td>{{$etat_lors_vidage}}</td>
                </tr>

                <tr>
                    <th>Bloc_poubelle:</th>
                    <td>{{$bloc_poubelle_id}}</td>
                </tr>
                <tr>
                    <th>Etage:</th>
                    <td>{{$etage}}</td>
                </tr>
                <tr>
                    <th>Bloc etablissement:</th>
                    <td>{{$bloc_etablissement}}</td>
                </tr>
                <tr>
                    <th>Etablissement:</th>
                    <td>{{$etablissement}}</td>
                </tr>

                <tr>
                    <th>ID camion:</th>
                    <td>{{$camion_id}}</td>
                </tr>
                <tr>
                    <th>Matricule camion:</th>
                    <td>{{$camion_matricule}}</td>
                </tr>
                <tr>
                    <th>Date depot:</th>
                    <td>{{$date_depot}}</td>
                </tr>
                <tr>
                    <th>Quantité depose:</th>
                    <td>{{$quantite_depose}}</td>
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
