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
        <h2 style="text-align: center;">Détails commande dechets numero:{{ $id }}</h2>
        <br/>
        <div>
            <table>
                <tr>
                    <th>Numéro commande:</th>
                   <td colspan="4">{{$id}}</td>
                </tr>

                <tr>
                    <th>Type dechet</th>
                    <th  style="color:blue">Plastique</th>
                    <th  style="color:orange">Papier</th>
                    <th  style="color:green">Composte</th>
                    <th  style="color:red">Canette</th>
                </tr>

                <tr>
                    <th>Quantité</th>
                    <th style="color:blue">{{ $quantite_plastique }} KG</th>
                    <th style="color:orange">{{ $quantite_papier }} KG</th>
                    <th style="color:green">{{ $quantite_composte}} KG</th>
                    <th style="color:red">{{ $quantite_canette }} KG</th>
                </tr>
                <tr>
                    <th>Prix</th>
                    <th style="color:blue">{{ $prix_plastique }} DT</th>
                    <th style="color:orange">{{ $prix_papier }} DT</th>
                    <th style="color:green">{{ $prix_composte}} DT</th>
                    <th style="color:red">{{ $prix_canette }} DT</th>
                </tr>

                <tr>
                    <th>Montant total:</th>
                    <th colspan="4" style="text-align:center;">{{$montant_total}} DT</th>
                </tr>
                <tr>
                    <th>date commande :</th>
                    <td colspan="4">{{$date_commande}}</td>
                </tr>
                <tr>
                    <th>date livraison :</th>
                    <td colspan="4">{{$date_livraison}}</td>
                </tr>
                <tr>
                    <th>Type paiment :</th>
                    <td colspan="4">{{$type_paiment}}</td>
                </tr>
                <tr>
                    <th rowspan='2'>entreprise :</th>
                    <td colspan="4"><b>Nom :</b>{{$entreprise}}</td>
                </tr>

                <tr>
                    <td colspan="4"><b>Matricule fiscale</b>{{$matricule_fiscale}}</td>
                </tr>

                <tr>
                    <th>Client dechet:</th>
                   <td colspan="4">
                    <b>ID: </b>{{$client_dechet_id}} <br/>

                    <b>Nom et prénom :</b>{{$client_dechet->nom.' '.$client_dechet->prenom }}<br/>

                    <b> Numéro télephone :</b>{{$client_dechet->numero_telephone}}<br/>

                    <b> Numéro fixe :</b>{{$client_dechet->numero_fixe}}<br/>

                    <b> Adresse :</b>{{$client_dechet->adresse}}<br/>

                    <b>E-mail :</b>{{$client_dechet->email}}<br/>

                </td>
                </tr>

                <tr>
                    <th>Date de création:</th>
                   <td colspan="4">{{$created_at}}</td>
                </tr>
                <tr>
                    <th>Date de dernier modification: </th>
                   <td colspan="4">{{$updated_at}}</td>
                </tr>
                <tr>
                    <th style='background-color:red; color:white;'>Date de suppression</th>
                    <td  colspan="4" style='color:red;'>{{$deleted_at}}</td>
                </tr>
            </table>
        </div>

    </body>
</html>
