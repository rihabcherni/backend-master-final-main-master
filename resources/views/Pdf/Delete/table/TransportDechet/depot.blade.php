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
    <body class="page">
        <img class="img-logo" src="{{ public_path('images/logo.png') }}" alt="logo" width="50px" height="50px"/>
        <p class='date'>{{ date('d-m-Y H:i:s') }}</p>
        <hr/>
        <h2 style="text-align: center;">Liste des dépôts effectués par les camions de Reschool Ecology: </h2>
        <table>
            <tr>
                <th>Id:</th>
                <th>Détails depot:</th>
                <th>Quantité deposé:</th>
                <th>Liste de ouvriers:</th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td> {{ $l['id'] }}</td>

                <td>
                    <table>
                        <tr>
                            <td>
                                <b>Matricule camion : </b> {{ $l['camion']->matricule }}<br/>
                                <b>Region : </b> {{ $l['zone_travail']->region }}<br/>

                                <b>date depot : </b> {{ $l['date_depot'] }}<br/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Id:</b> {{ $l['zone_depot']->id }}<br/>
                                <b>Adresse:</b> {{ $l['zone_depot']->adresse }}<br/>
                                <b>Longitude:</b> {{ $l['zone_depot']->longitude }}<br/>
                                <b>Latitude:</b> {{ $l['zone_depot']->latitude }}<br/>
                            </td>
                         </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td style="background-color: blue;color:white; font-size:18px; font-weight:bold;">Plastique:</td>
                            <td style="color: blue; font-size:18px; font-weight:bold;"> {{ $l['quantite_depose_plastique'] }}KG</td>
                        </tr>
                        <tr>
                            <td style="background-color: orange;color:white; font-size:18px; font-weight:bold;">Papier:</td>
                            <td style="color: orange; font-size:18px; font-weight:bold;"> {{ $l['quantite_depose_papier'] }}KG</td>
                        </tr>
                        <tr>
                            <td style="background-color: green;color:white; font-size:18px; font-weight:bold;">Composte:</td>
                            <td style="color: green; font-size:18px; font-weight:bold;"> {{ $l['quantite_depose_composte'] }}KG</td>
                        </tr>
                        <tr>
                            <td style="background-color: red;color:white; font-size:18px; font-weight:bold;">Canette:</td>
                            <td style="color: red; font-size:18px; font-weight:bold;"> {{ $l['quantite_depose_canette'] }}KG</td>
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
            </tr>
            @endforeach
        </table>

    </body>
</html>
