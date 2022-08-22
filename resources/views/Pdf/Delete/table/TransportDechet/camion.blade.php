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
        <h2 style="text-align: center;">Liste des camions de Reschool Ecology: </h2>        <br/>
        <table>
            <tr>
                <th>Id:</th>
                <th>Détails camion:</th>
                <th>Volume camion:</th>
                <th>Liste des ouvriers:</th>
                <th>Date de création: </th>
                <th>Date de dernier modification: </th>
                <th style='background-color:red; color:white;'>Date de suppression</th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td>{{ $l['id'] }}</td>
                <td>
                   <b>Region :</b> {{ $l['zone_travail']->region }}<br/>
                   <b>Zone de depot adresse :</b> {{$l['zone_depot']->adresse }}<br/>
                   <b>Camion matricule :</b> {{$l['matricule'] }}<br/>
                   <b>Heure sortie :</b> {{$l['heure_sortie'] }}<br/>
                   <b>Heure entree :</b> {{$l['heure_entree'] }}<br/>
                   <b>Longitude :</b> {{$l['longitude'] }}<br/>
                   <b>Latitude :</b> {{$l['latitude'] }}<br/>
                   <b>Volume carburant consomme :</b>{{ $l['volume_carburant_consomme'] }}<br/>
                   <b>Kilometrage :</b>{{ $l['Kilometrage'] }}<br/>
                </td>

                <td>
                    <table style="margin: 0 auto;">
                        <tr>
                            <th>Volume maximale camion:</th>
                            <td>{{ $l['volume_maximale_camion'] }}KG</td>
                        </tr>
                    </table>
                    <br/>
                    <table style="margin: 0 auto;">
                        <tr>
                            <th colspan="2">Volume actuelle camion:</th>
                        </tr>
                        <tr>
                            <td style='background-color:blue;color:white'>Plastique</td>
                            <td style='color:blue;'>{{ $l['volume_actuelle_plastique'] }}KG</td>
                        </tr>
                        <tr>
                            <td style='background-color:orange;color:white'>Papier</td>
                            <td style='color:orange;'>{{ $l['volume_actuelle_papier'] }}KG</td>
                        </tr>
                        <tr>
                            <td style='background-color:green;color:white'>Composte</td>
                            <td style='color:green;'>{{ $l['volume_actuelle_composte'] }}KG</td>
                        </tr>
                        <tr>
                            <td style='background-color:red;color:white'>Canette</td>
                            <td style='color:red;'>{{ $l['volume_actuelle_canette'] }}KG</td>
                        </tr>
                    </table>
                </td>
                <td>
                    @foreach ( $l['ouvrier'] as $ouvrier)
                        <table style='width:310px;'>
                            <tr>
                                <td>
                                    <?php
                                    $url = 'storage/images/ouvrier/'.$ouvrier->photo;
                                    $path= public_path($url);
                                    if(! file_exists($path) || $ouvrier->photo === null){
                                        $path= public_path('storage/images/ouvrier/default.jpeg');
                                    }
                                    ?>
                                    <img width="50px" height="50px" src="{{$path}}" alt="ouvrier"/><br/><br/>
                                    <b>N°:</b> {{ $ouvrier->id }}<br/>
                                </td>
                                <td>
                                    <b>Poste:</b> {{ $ouvrier->poste }}<br/>
                                    <b>Nom et prénom:</b> {{ $ouvrier->nom }}." ".{{ $ouvrier->prenom }}<br/>
                                    <b>CIN:</b> {{ $ouvrier->CIN }}<br/>
                                    <b>Numéro télephone:</b> {{ $ouvrier->numero_telephone }}<br/>
                                    <b>E-mail:</b> {{ $ouvrier->email }}<br/>
                                </td>
                            </tr>
                        </table>
                    @endforeach
                </td>
                <td>{{ $l['created_at'] }}</td>
                <td>{{ $l['updated_at'] }}</td>
                <td style='color:red; font-weight:bold;'> {{ $l['deleted_at'] }}</td>
            </tr>
            @endforeach
        </table>

    </body>
</html>
