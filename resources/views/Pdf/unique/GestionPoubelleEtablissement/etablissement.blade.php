<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style>
            .date{
                margin:-20px 0 0 80%  ;
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
        <h2 style="text-align: center;">Détails établissement: {{ $nom_etablissement }}</h2>
        <div>
            <table>
                <tr>
                    <th>Détails établissement:</th>
                    <td colspan="5">
                        <table>
                            <tr>
                                <th>Identifiant:</th>
                                <th>Niveau:</th>
                                <th>Type:</th>
                                <th>Nombre personnes:</th>
                                <th>Matricule camion affecté:</th>
                                <th> Date de devenir partenaire de notre organisation
                            </tr>
                            <tr>
                                <td>{{$id}}</td>
                                <td>{{$niveau_etablissement}}</td>
                                <td>{{$type_etablissement}}</td>
                                <td>{{$nbr_personnes}}</td>
                                <td>{{$camion->matricule}}</td>
                                <td>{{$created_at}}</td>

                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Localisation établissement:</th>
                    <td colspan="5">
                        <table>
                            <tr>
                                <th>Region:</th>
                                <th>Adresse:</th>
                                <th>Url map:</th>
                                <th>Longitude:</th>
                                <th>Latitude:</th>
                            </tr>
                            <tr>
                                <td>{{$region}}</td>
                                <td>{{$adresse}}</td>
                                <td>{{$url_map}}</td>
                                <td>{{$longitude}}</td>
                                <td>{{$latitude}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <th rowspan="2">Quantités déchets:</th>
                    <th>Actuelle:</th>
                    <td style="color:blue;"><b>Plastique:</b>{{$quantite_dechets_plastique}}</td>
                    <td style="color:orange;"><b>Papier:</b>{{$quantite_dechets_papier}}</td>
                    <td style="color:green;"><b>Composte:</b>{{$quantite_dechets_composte}}</td>
                    <td style="color:red;"><b>Canette:</b>{{$quantite_dechets_canette}}</td>

                </tr>
                <tr>
                    <th>Mensuelle:</th>
                    <td style="color:blue;"><b>Plastique:</b>{{$quantite_plastique_mensuel}}</td>
                    <td style="color:orange;"><b>Papier:</b>{{$quantite_papier_mensuel}}</td>
                    <td style="color:green;"><b>Composte:</b>{{$quantite_composte_mensuel}}</td>
                    <td style="color:red;"><b>Canette:</b>{{$quantite_canette_mensuel}}</td>
                </tr>
                <tr>
                    <th>Détails blocs etablissement:</th>
                    <td colspan="5">
                        <table style="width: 800px">
                            <tr>
                                <th>Nom Bloc:</th>
                                @for ($i=0; $i<count($details_blocs);$i++)
                                    <td>Bloc: {{$details_blocs[$i]->nom_bloc_etablissement}}</td>
                                @endfor
                             </tr>
                            <tr>
                                <th>Liste des etages:</th>
                                @for ($i=0; $i<count($details_blocs);$i++)
                                    <td>
                                        @foreach ($details_blocs[$i]->etage_etablissements as $etage)
                                            {{ $etage->nom_etage_etablissement }}<br/>
                                        @endforeach
                                    </td>
                                @endfor
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br/>
            <table>
                <tr>
                    <th rowspan={{count($responsable_etablissement )+1}}>Liste responsable:</th>
                    <th></th>
                    <th>E-mail</th>
                    <th>Nom et prénom:</th>
                    <th>Numéro télephone</th>
                    <th>Adresse:</th>
                        @foreach ($responsable_etablissement as $responsable)
                        <tr>
                            <td>
                                <?php $url = 'storage/images/responsable_etablissement/'.$responsable->photo;
                                $path= public_path($url);
                                if(! file_exists($path) || $responsable->photo=== null){
                                    $path= public_path('storage/images/responsable_etablissement/default.jpeg');
                                }
                                ?>
                                <img width="50px" height="50px" src="{{$path }}" alt="responsable etablissement"/>
                            </td>
                            <td  style="color:blue; text-decoration:underline;"> {{ $responsable->email}}</td>
                            <td> {{ $responsable->nom}} {{ $responsable->prenom}}</td>
                            <td> {{ $responsable->numero_telephone}}</td>
                            <td> {{ $responsable->adresse}}</td>
                        </tr>
                        @endforeach
                </tr>

            </table>
        </div>

    </body>
</html>
