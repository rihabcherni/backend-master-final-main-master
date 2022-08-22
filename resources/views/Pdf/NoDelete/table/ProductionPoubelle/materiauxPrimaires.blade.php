<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style>
            .date{
                margin:-20px 0 0 85%  ;
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
        <h2 style="text-align: center;">Liste des matériaux primaires utilisées par Reschool Ecology: </h2>
        <table>
            <tr>
                <th>Id:</th>
                <th>Nom materiel:</th>
                <th>Prix unitaire:</th>
                <th>Quantité:</th>
                <th>Prix total:</th>
                <th>Fournisseur:</th>
                <th>Date de création:</th>
                <th>Date de dernier modification: </th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td> {{ $l['id'] }}</td>
                <td> {{ $l['nom_materiel'] }}</td>
                <td> {{ $l['prix_unitaire'] }}DT</td>
                <td> {{ $l['quantite'] }}</td>
                <td> {{ $l['prix_total'] }}DT</td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <?php
                                $url = 'storage/images/fournisseur/'.$l['fournisseur']->photo;
                                $path= public_path($url);
                                if(! file_exists($path) || $l['fournisseur']->photo === null){
                                    $path= public_path('storage/images/fournisseur/default.jpeg');
                                }
                                ?>
                                <img width="60px" height="60px" src="{{$path}}" alt="fournisseur"/>
                            </td>
                            <td>
                                <b>Id:</b>{{$l['fournisseur_id']}}<br/>

                                <b>Nom et prénom:</b> {{$l['fournisseur_nom']}}<br/>

                                <b>Carte identité national:</b> {{$l['cin']}}<br/>

                                <b>Numéro télophone:</b> {{$l['fournisseur_numero_telephone']}}<br/>
                                <b>E-mail:</b><sapn style='color:blue; font-weight:bold;text-decoration:underline;'>{{$l['fournisseur']->email}}</sapn><br/>
                                <b>Adresse:</b>{{$l['fournisseur']->adresse}}<br/>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>{{ $l['created_at'] }}</td>
                <td>{{ $l['updated_at'] }}</td>
            </tr>
            @endforeach
        </table>

    </body>
</html>
