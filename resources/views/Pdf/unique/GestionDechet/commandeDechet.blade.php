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
                width:480px;
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
        <h2 style="text-align: center;">Détails commande dechets numero:{{ $id }}</h2>
        <br/>
        <div>
            <table>
                <tr>
                    <th>Numéro commande:</th>
                    <td>{{$id}}</td>
                </tr>
                <tr>
                    <th>Type dechets:</th>
                    <td>{{$type}}</td>
                </tr>
                <tr>
                    <th>Quantité :</th>
                    <td>{{$quantite}}</td>
                </tr>
                <tr>
                    <th>Montant total:</th>
                    <td>{{$montant_total}}</td>
                </tr>
                <tr>
                    <th>date commande :</th>
                    <td>{{$date_commande}}</td>
                </tr>
                <tr>
                    <th>date livraison :</th>
                    <td>{{$date_livraison}}</td>
                </tr>
                <tr>
                    <th>Type paiment :</th>
                    <td>{{$type_paiment}}</td>
                </tr>
                <tr>
                    <th rowspan='2'>entreprise :</th>
                    <td><b>Nom :</b>{{$entreprise}}</td>
                </tr>

                <tr>
                    <td><b>Matricule fiscale</b>{{$matricule_fiscale}}</td>
                </tr>

                <tr>
                    <th  rowspan='6'>Client dechet:</th>
                    <td><b>ID: </b>{{$client_dechet_id}}</td>
                </tr>
                <tr>
                    <td><b>Nom et prénom :</b>{{$client_dechet->nom.' '.$client_dechet->prenom }}</t</td>
                </tr>
                <tr>
                    <td><b> Numéro télephone :</b>{{$client_dechet->numero_telephone}}</td>
                </tr>
                <tr>
                    <td><b> Numéro fixe :</b>{{$client_dechet->numero_fixe}}</td>
                </tr>
                <tr>
                    <td><b> Adresse :</b>{{$client_dechet->adresse}}</td>
                </tr>
                <tr>
                    <td><b>E-mail :</b>{{$client_dechet->email}}</td>
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
