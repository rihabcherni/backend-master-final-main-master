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
        <h2 style="text-align: center;">Détails Matiére primaire: {{ $nom_materiel }}</h2>
        <br/>
        <div>
            <table>
                <tr>
                    <th>Identifiant:</th>
                    <td colspan="2">{{$id}}</td>
                </tr>
                <tr>
                    <th rowspan="4">Détails produits:</th>
                    <th>Nom produits:</th>
                    <td>{{$nom_materiel}}</td>
                </tr>

                <tr>
                    <th>Prix unitaire:</th>
                    <td>{{$prix_unitaire}} DT</td>
                </tr>
                <tr>
                    <th>quantite:</th>
                    <td>{{$quantite}}</td>
                </tr>
                <tr>
                    <th>Prix total:</th>
                    <td>{{$prix_total}} DT</td>
                </tr>

                <tr>
                    <th rowspan="4">Fournisseur:</th>
                    <th>Id:</th>
                    <td>{{$fournisseur_id}}</td>
                </tr>
                <tr>
                    <th>Nom et prénom:</th>
                    <td>{{$fournisseur_nom}}</td>
                </tr>
                <tr>
                    <th>Carte identité national:</th>
                    <td>{{$cin}}</td>
                </tr>
                <tr>
                    <th>Numéro télophone:</th>
                    <td>{{$fournisseur_numero_telephone}}</td>
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
