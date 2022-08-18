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
        <h2 style="text-align: center;">Détails établissement: {{ $nom_etablissement }}</h2>
        <br/>
        <div>
            <table>
                <tr>
                    <th>Identifiant:</th>
                    <td colspan="5">{{$id}}</td>
                </tr>
                <tr>
                    <th rowspan="5">Localisation établissement:</th>
                    <th>Region:</th>
                    <td colspan="4">{{$region}}</td>
                </tr>
                <tr>
                    <th>Adresse:</th>
                    <td colspan="4">{{$adresse}}</td>
                </tr>
                <tr>
                    <th>Url map:</th>
                    <td colspan="4">{{$url_map}}</td>
                </tr>
                <tr>
                    <th>Longitude:</th>
                    <td colspan="4">{{$longitude}}</td>
                </tr>
                <tr>
                    <th>Latitude:</th>
                    <td colspan="4">{{$latitude}}</td>
                </tr>


                <tr>
                    <th rowspan="3">Détails établissement:</th>
                    <th>Niveau:</th>
                    <td colspan="4">{{$niveau_etablissement}}</td>
                </tr>
                <tr>
                    <th>Type:</th>
                    <td colspan="4">{{$type_etablissement}}</td>
                </tr>
                <tr>
                    <th>Nombre personnes:</th>
                    <td colspan="4">{{$nbr_personnes}}</td>
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
            </table>
            <br/>
            <table>
                <tr>
                    <th rowspan={{count($responsable_etablissement )+1}}>Liste responsable:</th>
                    <th></th>
                    <th>E-mail</th>
                    <th>Nom et prénom:</th>
                    <th>Numéro télephone</th>
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
                        </tr>
                        @endforeach
                </tr>
                <tr>
                    <th rowspan="2">camion:</th>
                    <th>Numéro:</th>
                    <td colspan="3">{{$camion->id}}</td>
                </tr>
                <tr>
                    <th>Matricule:</th>
                    <td colspan="3">{{$camion->matricule}}</td>
                </tr>
                <tr>
                    <th rowspan={{ count($details_blocs)+1 }}>Détails blocs etablissement:</th>
                    <th>Nom Bloc:</th>
                    <th  colspan="3">Liste des etages:</th>
                </tr>
                    @for ($i=0; $i<count($details_blocs);$i++)
                        <tr>
                            <td>Bloc: {{$details_blocs[$i]->nom_bloc_etablissement}}</td>
                            <td  colspan="3">
                                @foreach ($details_blocs[$i]->etage_etablissements as $etage)
                                Etage: {{ $etage->nom_etage_etablissement }}<br/>
                                @endforeach
                            </td>
                        </tr>
                    @endfor
                <tr>
                    <th>Date de création:</th>
                    <td colspan="5">{{$created_at}}</td>
                </tr>
                <tr>
                    <th>Date de dernier modification: </th>
                    <td colspan="5">{{$updated_at}}</td>
                </tr>
            </table>
        </div>

    </body>
</html>
