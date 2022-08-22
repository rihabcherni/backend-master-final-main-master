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
        <h2 style="text-align: center;">Liste des établissements partenaires à Reschool Ecology: </h2>
        <table>
            <tr>
                <th>Détails établissement:</th>
                <th>Localisation établissement:</th>
                <th>Quantités déchets: </th>
                <th >Détails blocs établissement:</th>
                <th>Liste responsables:</th>
            </tr>
            @foreach ($data as $l)
                <tr>
                    <td>
                        <table>
                            <tr>
                                <th>N°:</th>
                                <td>{{ $l['id'] }} </td>
                            </tr>
                            <tr>
                                <th>Nom:</th>
                                <td>{{ $l['nom_etablissement'] }} </td>
                            </tr>
                            <tr>
                                <th>Niveau:</th>
                                <td>{{ $l['niveau_etablissement'] }} </td>
                            </tr>
                            <tr>
                                <th>Type:</th>
                                <td>{{ $l['type_etablissement'] }} </td>
                            </tr>
                            <tr>
                                <th>Nombre personnes:</th>
                                <td>{{ $l['nbr_personnes'] }} </td>
                            </tr>
                            <tr>
                                <th>Matricule camion:</th>
                                <td>{{ $l['camion']->matricule }} </td>
                            </tr>
                            <tr>
                                <th>Date de devenir partenaire:</th>
                                <td>{{ $l['created_at'] }} </td>
                            </tr>
                        </table>
                    </td>

                    <td>
                        <table>
                            <tr>
                                <th>Region:</th>
                                <td>{{ $l['region'] }} </td>
                            </tr>
                            <tr>
                                <th>Adresse:</th>
                                <td>{{ $l['adresse'] }}  </td>
                            </tr>
                            <tr>
                                <th>Longitude:</th>
                                <td>{{ $l['longitude'] }}</td>
                            </tr>
                            <tr>
                                <th>Latitude:</th>
                                <td>{{ $l['latitude'] }}</td>
                            </tr>
                        </table>
                    </td>

                    <td>
                        <table>
                            <tr>
                                <th></th>
                                <th>Plastique:</th>
                                <th>Papier:</th>
                                <th>Composte:</th>
                                <th>Canette:</th>
                            </tr>
                            <tr>
                                <th>Actuelle: </th>
                                <td>{{ $l['quantite_dechets_plastique'] }}</td>
                                <td>{{ $l['quantite_dechets_papier'] }}</td>
                                <td>{{ $l['quantite_dechets_composte'] }}</td>
                                <td>{{ $l['quantite_dechets_canette'] }}</td>
                            </tr>

                            <tr>
                                <th>Mensuelle:</th>
                                <td>{{ $l['quantite_plastique_mensuel'] }}</td>
                                <td>{{ $l['quantite_papier_mensuel'] }}</td>
                                <td>{{ $l['quantite_composte_mensuel'] }}</td>
                                <td>{{ $l['quantite_canette_mensuel'] }}</td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table>
                            <tr>
                                <th>Nom Bloc:</th>
                                @for ($i=0; $i<count( $l['details_blocs']);$i++)
                                    <td>{{$l['details_blocs'][$i]->nom_bloc_etablissement}}</td>
                                @endfor
                             </tr>
                            <tr>
                                <th>Liste des etages:</th>
                                @for ($i=0; $i<count($l['details_blocs']);$i++)
                                    <td>
                                        @foreach ($l['details_blocs'][$i]->etage_etablissements as $etage)
                                            {{ $etage->nom_etage_etablissement }}<br/>
                                        @endforeach
                                    </td>
                                @endfor
                            </tr>
                        </table>
                    </td>
                    <td>
                        @if (count($l['responsable_etablissement']) > 0)
                            <table>
                                @foreach ($l['responsable_etablissement'] as $resp)
                                    <tr>
                                        <td>
                                            <?php
                                            $url = 'storage/images/responsable_etablissement/'.$resp->photo;
                                            $path= public_path($url);
                                            if(! file_exists($path) || $resp->photo === null){
                                                $path= public_path('storage/images/responsable_etablissement/default.jpeg');
                                            }
                                            ?>
                                            <img width="30px" height="30px" src="{{$path}}" alt="responsable etablissement"/>
                                        </td>
                                        <td>
                                            <b>Nom et prénom: </b> {{ $resp->nom." ".$resp->prenom }}<br/>
                                            <b>E-mail:</b><span style='color:blue; font-weight:bold;text-decoration:underline;'>{{ $resp->email }}</span><br/>
                                            <b>Télephone: </b> {{ $resp->numero_telephone }}<br/>
                                            <b>Adresse: </b> {{ $resp->adresse }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

    </body>
</html>
