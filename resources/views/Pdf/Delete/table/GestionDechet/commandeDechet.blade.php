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
        <h2 style="text-align: center;">Liste des commandes dechets Reschool Ecology supprimés: </h2>        <br/>
        <table>
            <tr>

                <th colspan="7">Détails commande</th>

                <th rowspan="2">Entreprise:</th>
                <th rowspan="2">Matricule fiscale:</th>

                <th colspan="4">Détails client</th>

                <th rowspan="2">Date de création:</th>
                <th rowspan="2">Date de modification: </th>
                <th rowspan="2" style='background-color:red; color:white;'>Date de suppression</th>

            </tr>
            <tr>
                <th>Id:</th>
                <th>Type dechet</th>
                <th>Quantite</th>
                <th>Montant total:</th>
                <th>Date commande:</th>
                <th>Date livraison:</th>
                <th>Type paiment:</th>

                <th>ID</th>
                <th>Nom et prénom</th>
                <th>Numéro télephone</th>
                <th>E-mail</th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td> {{ $l['id'] }}</td>
                <td> {{ $l['type'] }}</td>
                <td> {{ $l['quantite'] }}</td>
                <td> {{ $l['montant_total'] }}</td>
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
                <td style='color:red; font-weight:bold;'> {{ $l['deleted_at'] }}</td>
            </tr>
            @endforeach
        </table>

    </body>
</html>
