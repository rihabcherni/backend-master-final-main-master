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
                    <th>Fournisseur:</th>
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                    <?php
                                    $url = 'storage/images/fournisseur/'.$fournisseur->photo;
                                    $path= public_path($url);
                                    if(! file_exists($path) || $fournisseur->photo === null){
                                        $path= public_path('storage/images/fournisseur/default.jpeg');
                                    }
                                    ?>
                                    <img width="60px" height="60px" src="{{$path}}" alt="fournisseur"/>
                                </td>
                                <td>
                                    <b>Id:</b>{{$fournisseur_id}}<br/>

                                    <b>Nom et prénom:</b> {{$fournisseur_nom}}<br/>

                                    <b>Carte identité national:</b> {{$cin}}<br/>

                                    <b>Numéro télophone:</b> {{$fournisseur_numero_telephone}}<br/>
                                    <b>E-mail:</b><sapn style='color:blue; font-weight:bold;text-decoration:underline;'>{{$fournisseur->email}}</sapn><br/>
                                    <b>Adresse:</b>{{$fournisseur->adresse}}<br/>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <th>Date de création:</th>
                    <td colspan="2">{{$created_at}}</td>
                </tr>
                <tr>
                    <th>Date de dernier modification: </th>
                    <td colspan="2">{{$updated_at}}</td>
                </tr>
                <tr>
                    <th style='background-color:red; color:white;'>Date de suppression</th>
                    <td style='color:red;'>{{$deleted_at}}</td>
                </tr>
            </table>
        </div>

    </body>
</html>
