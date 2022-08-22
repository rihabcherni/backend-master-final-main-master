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
        <h2 style="text-align: center;">Détails depot dechets numéro :{{ $id }} </h2>
        <div>
            <table>
                <tr>
                    <th>Numéro depot:</th>
                    <td colspan="2">{{ $id }}</td>
                </tr>
                <tr>
                    <th>Date depot:</th>
                    <td colspan="2">{{$date_depot}}</td>
                </tr>
                <tr>
                    <th rowspan="4">Quantité deposée:</th>
                    <th style='color:blue;'>Plastique:</th>
                    <td style='color:blue;'>{{$quantite_depose_plastique}} KG</td>
                </tr>
                <tr>
                    <th style='color:orange;'>Papier:</th>
                    <td style='color:orange;'>{{$quantite_depose_papier}} KG</td>
                </tr>
                <tr>
                    <th style='color:green;'>Composte:</th>
                    <td style='color:green;'>{{$quantite_depose_composte}} KG</td>
                </tr>
                <tr>
                    <th style='color:red;'>Canette:</th>
                    <td style='color:red;'>{{$quantite_depose_canette}} KG</td>
                </tr>

                <tr>
                    <th>Matricule camion: </th>
                    <td colspan="2">{{ $camion->matricule }}</td>
                </tr>

                <tr>
                    <th>Region de travail:</th>
                    <td colspan="2">{{$zone_travail->region}}</td>
                </tr>

                <tr>
                    <th>Adresse zone de depot :</th>
                    <td colspan="2">{{$zone_depot->adresse}}</td>
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
                    <td  colspan="2" style='color:red;'>{{$deleted_at}}</td>
                </tr>
            </table>
            <br/>
            <table>
                <tr>
                    @if (count($ouvrier)!==0)
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
                    @endif
                </tr>
            </table>
        </div>

    </body>
</html>
