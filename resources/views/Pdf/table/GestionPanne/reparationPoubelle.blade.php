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
        <br/>
        <h2 style="text-align: center;">Liste des pannes poubelles: </h2>        <br/>
        <table>
            <tr>
                <th rowspan="2">Id:</th>
                <th colspan="5">Détails panne poubelle:</th>
                <th rowspan="2">Poubelle:</th>
                <th colspan="6">Réparateur poubelle:</th>
                <th rowspan="2">Crée le:</th>
                <th rowspan="2">Modifié le: </th>
            </tr>
            <tr>
                <th>Image:</th>
                <th>Description:</th>
                <th>Cout:</th>
                <th>Debut reparation:</th>
                <th>Fin reparation:</th>
                <th>N°:</th>
                <th>Photo:</th>
                <th>Nom et prénom:</th>
                <th>Adresse:</th>
                <th>N° télephone:</th>
                <th>E-mail:</th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td> {{ $l['id'] }}</td>
                <td>
                    <?php $url = 'storage/images/pannePoubelle/'.$l['image_panne_poubelle'];
                    $path= public_path($url);
                    if(! file_exists($path) || $l['image_panne_poubelle'] === null){
                        $path= public_path('storage/images/pannePoubelle/default.jpeg');
                    }
                    ?>
                    <img width="100px" height="100px" src="{{$path }}" alt="pane poubelle "/>
                </td>
                <td> {{ $l['description_panne'] }}</td>
                <td> {{ $l['cout'] }} DT</td>
                <td> {{ $l['date_debut_reparation'] }}</td>
                <td> {{ $l['date_fin_reparation'] }}</td>

                <td>
                    <table style="margin-bottom: 5px">
                        @if( $l['poubelle']->type=== "plastique")
                            <td style="width:60px ;background-color:blue; color:white;font-weight:bold;"><p style="margin:45% 0;">{{ $l['poubelle']->type}}<p></td>
                        @elseif( $l['poubelle']->type=== "papier")
                            <td style="width:60px ;background-color:orange; color:white;font-weight:bold"><p style="margin:45% 0;">{{ $l['poubelle']->type}}<p></td>
                        @elseif( $l['poubelle']->type=== "composte")
                            <td style="width:60px ;background-color:green; color:white;font-weight:bold"><p style="margin:45% 0;">{{ $l['poubelle']->type}}<p></td>
                        @elseif( $l['poubelle']->type=== "canette")
                            <td style="width:60px ;background-color:red; color:white;font-weight:bold"><p style="margin:45% 0;">{{ $l['poubelle']->type}}<p></td>
                        @endif
                        <td>{{ $l['poubelle']->nom}}</td>
                </table>
                </td>

                <td>{{ $l['reparateur_poubelle']->id }}</td>
                <td>
                    <?php $url = 'storage/images/reparateur_poubelle/'.$l['reparateur_poubelle']->photo;
                    $path= public_path($url);
                    if(! file_exists($path) || $l['reparateur_poubelle']->photo === null){
                        $path= public_path('storage/images/reparateur_poubelle/default.jpeg');
                    }
                    ?>
                    <img width="50px" height="50px" src="{{$path }}" alt="reparateur_poubelle "/>
                </td>
                <td>{{ $l['reparateur_poubelle']->nom.' '.$l['reparateur_poubelle']->prenom }}</td>
                <td>{{ $l['reparateur_poubelle']->adresse }}</td>
                <td>{{ $l['reparateur_poubelle']->numero_telephone }}</td>
                <td style='color:blue; font-weight:bold;text-decoration:underline;'>{{ $l['reparateur_poubelle']->email }}</td>
                <td>{{ $l['created_at'] }}</td>
                <td>{{ $l['updated_at'] }}</td>
            </tr>
            @endforeach
        </table>

    </body>
</html>
