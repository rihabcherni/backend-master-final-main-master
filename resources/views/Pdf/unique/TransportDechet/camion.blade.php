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
            .table{
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
        <h2 style="text-align: center;">Détails camion:  {{ $matricule }}</h2>
        <div>
            <table class='table'>
                <tr>
                    <th>Identifiant:</th>
                    <td colspan="2">{{$id}}</td>
                </tr>
                <tr>
                    <th>Region de travail:</th>
                    <td colspan="2">{{$zone_travail->region}}</td>
                </tr>
                <tr>
                    <th rowspan="9">Détails camion:</th>
                    <td><b>Heure sortie :  </b>{{$heure_sortie}}</td>
                    <td><b>Heure entree :  </b>{{$heure_entree}}</td>
                </tr>
                <tr>
                    <td><b>Latitude :   </b>{{$latitude}}</td>
                    <td><b>Longitude :  </b>{{$longitude}}</td>
                </tr>

                <tr>
                    <td> <b>volume carburant consomme:</b> {{$volume_carburant_consomme}}</td>
                    <td><b>Kilometrage:</b> {{$Kilometrage}}</td>
                </tr>
                <tr>
                    <th>Quantité maximale camion:</th>
                    <td>{{$volume_maximale_camion}}</td>
                </tr>
                <tr>
                    <th rowspan="4">Quantité depot actuelle:</th>
                    <td style='color:blue;'><b>Plastique:</b> {{$volume_actuelle_plastique}}</td>
                </tr>
                <tr>
                    <td style='color:orange;'> <b>Papier:</b> {{$volume_actuelle_papier}}</td>
                </tr>
                <tr>
                    <td style='color:green;'><b>Composte:</b> {{$volume_actuelle_composte}}</td>
                </tr>
                <tr>
                    <td style='color:red;'><b>Canette:</b> {{$volume_actuelle_canette}}</td>
                </tr>

                <tr>
                    <td><b>Date de création:</b> {{$created_at}}</td>
                    <td><b>Date de dernier modification: </b>{{$updated_at}}</td>
                </tr>
            </table>
            <br/>
            <table class='table'>
                <tr>
                    <th rowspan="7">Zone de depot:</th>
                    <th>ID:</th>
                    <td colspan="4">{{$zone_depot->id}}</td>
                </tr>
                <tr>
                    <th>Adresse:</th>
                    <td colspan="4">{{$zone_depot->adresse}}</td>
                </tr>
                <tr>
                    <th>Longitude:</th>
                    <td colspan="4">{{$zone_depot->longitude}}</td>
                </tr>
                <tr>
                    <th>Latitude:</th>
                    <td colspan="4">{{$zone_depot->latitude}}</td>
                </tr>
                <tr>
                    <th>Quantité depot maximale:</th>
                    <td colspan="4">{{$zone_depot->quantite_depot_maximale}}</td>
                </tr>
                <tr>
                    <th rowspan="2">Quantité depot actuelle:</th>
                    <th style='color:blue;'>Plastique:</th>
                    <th style='color:orange;'>Papier:</th>
                    <th style='color:green;'>Composte:</th>
                    <th style='color:red;'>Canette:</th>
                </tr>
                <tr>
                    <td  style='color:blue;'>{{$zone_depot->quantite_depot_actuelle_plastique}}</td>
                    <td  style='color:orange;'>{{$zone_depot->quantite_depot_actuelle_papier}}</td>
                    <td  style='color:green;'>{{$zone_depot->quantite_depot_actuelle_composte}}</td>
                    <td  style='color:red;'>{{$zone_depot->quantite_depot_actuelle_canette}}</td>
                </tr>
            </table>
            <br/>
            @if (count($ouvrier)!==0)
                <table class='table'>
                    <tr>
                        <th rowspan={{count($ouvrier )+1}}>Liste des ouvriers:</th>
                        <th></th>
                        <th>Poste</th>
                        <th>Nom et prénom:</th>
                        <th>CIN:</th>
                        <th>E-mail</th>
                        <th>Numéro télephone</th>
                            @foreach ($ouvrier as $o)
                            <tr>
                                <td>
                                    <?php $url = 'storage/images/ouvrier/'.$o->photo;
                                    $path= public_path($url);
                                    if(! file_exists($path) || $o->photo=== null){
                                        $path= public_path('storage/images/ouvrier/default.jpeg');
                                    }
                                    ?>
                                    <img width="50px" height="50px" src="{{$path }}" alt="ouvrier"/>
                                </td>
                                <td> {{ $o->poste}}</td>
                                <td> {{ $o->nom}} {{ $o->prenom}}</td>
                                <td> {{ $o->CIN}}</td>
                                <td style='color:blue; font-weight:bold;text-decoration:underline;'> {{ $o->email}}</td>
                                <td> {{ $o->numero_telephone}}</td>
                            </tr>
                            @endforeach
                    </tr>

                </table>
            @endif

        </div>

    </body>
</html>
