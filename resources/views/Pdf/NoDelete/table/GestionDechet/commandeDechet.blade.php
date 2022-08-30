<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style>
            .date{
                margin:-20px 0 0 90%  ;
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
        <h2 style="text-align: center;">Liste des commandes dechets Reschool Ecology: </h2>        <br/>
        <table>
            <tr>

                <th colspan="13">Détails commande</th>

                <th rowspan="3">Entreprise:</th>
                <th rowspan="3">Matricule fiscale:</th>

                <th colspan="4">Détails client</th>

                <th rowspan="3">Date de création:</th>
                <th rowspan="3">Date de modification: </th>
            </tr>
            <tr>
                <th rowspan="2">Id:</th>
                <th colspan="2" style="background-color:blue; color:white">Plastique:</th>
                <th colspan="2" style="background-color:orange; color:white">Papier:</th>
                <th colspan="2" style="background-color:green; color:white">Composte:</th>
                <th colspan="2" style="background-color:red; color:white">Canette:</th>
                <th rowspan="2">Montant total:</th>
                <th rowspan="2">Date commande:</th>
                <th rowspan="2">Date livraison:</th>
                <th rowspan="2">Type paiment:</th>

                <th rowspan="2">ID</th>
                <th rowspan="2">Nom et prénom</th>
                <th rowspan="2">Numéro télephone</th>
                <th rowspan="2">E-mail</th>
            </tr>

            <tr>
                <th style="background-color:blue; color:white">Quantité</th>
                <th style="background-color:blue; color:white">Montant</th>
                <th style="background-color:orange; color:white">Quantité</th>
                <th style="background-color:orange; color:white">Montant</th>
                <th style="background-color:green; color:white">Quantité</th>
                <th style="background-color:green; color:white">Montant</th>
                <th style="background-color:red; color:white">Quantité</th>
                <th style="background-color:red; color:white">Montant</th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td> {{ $l['id'] }}</td>
                <td style="color:blue;"> {{ $l['quantite_plastique'] }} KG</td>
                <td style="color:blue;"> {{ $l['prix_plastique'] }} DT</td>
                <td style="color:orange;"> {{ $l['quantite_papier'] }} KG</td>
                <td style="color:orange;"> {{ $l['prix_papier'] }} DT</td>
                <td style="color:green;"> {{ $l['quantite_composte'] }} KG</td>
                <td style="color:green;"> {{ $l['prix_composte'] }} DT</td>
                <td style="color:red;"> {{ $l['quantite_canette'] }} KG</td>
                <td style="color:red;"> {{ $l['prix_canette'] }} DT</td>
                <td> {{ $l['montant_total'] }} DT</td>
                <td>{{ $l['date_commande'] }}</td>
                <td>{{ $l['date_livraison'] }}</td>
                <td>{{ $l['type_paiment'] }}</td>


                <td>{{ $l['entreprise'] }}</td>
                <td>{{ $l['matricule_fiscale'] }}</td>
                <td>{{ $l['client_dechet']->id }}</td>
                <td>{{ $l['client_dechet']->nom .' '. $l['client_dechet']->prenom  }}</td>
                <td>{{ $l['client_dechet']->numero_telephone }}</td>
                <td style='color:blue; font-weight:bold;text-decoration:underline;'>{{ $l['client_dechet']->email }}</td>

                <td>{{ $l['created_at'] }}</td>
                <td>{{ $l['updated_at'] }}</td>
            @endforeach
        </table>


    </body>
</html>
