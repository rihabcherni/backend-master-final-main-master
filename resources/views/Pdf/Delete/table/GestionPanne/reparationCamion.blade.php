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
        <h2 style="text-align: center;">Liste des pannes camions: </h2>        <br/>
        <table>
            <tr>
                <th rowspan="2">Id:</th>
                <th colspan="5">Détails panne camion:</th>
                <th colspan="2">Camion:</th>
                <th colspan="6">Mecanicien:</th>
                <th rowspan="2">Date de création:</th>
                <th rowspan="2">Date de dernier modification: </th>
            </tr>
            <tr>
                <th>Image:</th>
                <th>Description:</th>
                <th>Cout:</th>
                <th>Debut reparation:</th>
                <th>Fin reparation:</th>
                <th>N°:</th>
                <th>Matricule:</th>
                <th>N°:</th>
                <th>Photo:</th>
                <th>Nom et prénom:</th>
                <th>Adresse:</th>
                <th>N° télephone:</th>
                <th>E-mail:</th>
                <th>Crée le:</th>
                <th>Modifié le: </th>
                <th style='background-color:red; color:white;'>Supprimé le:</th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td> {{ $l['id'] }}</td>
                <td>
                    <?php $url = 'storage/trashImages/panneCamion/'.$l['image_panne_camion'];
                    $path= public_path($url);
                    if(! file_exists($path) || $l['image_panne_camion'] === null){
                        $path= public_path('storage/trashImages/panneCamion/default.jpeg');
                    }
                    ?>
                    <img width="100px" height="100px" src="{{$path }}" alt="panne camion "/>
                </td>
                <td> {{ $l['description_panne'] }}</td>
                <td> {{ $l['cout'] }} DT</td>
                <td> {{ $l['date_debut_reparation'] }}</td>
                <td> {{ $l['date_fin_reparation'] }}</td>

                <td>{{ $l['camion']->id }}</td>
                <td>{{ $l['camion']->matricule }}</td>
                <td>{{ $l['mecanicien']->id }}</td>
                <td>
                    <?php $url = 'storage/images/mecanicien/'.$l['mecanicien']->photo;
                    $path= public_path($url);
                    if(! file_exists($path) || $l['mecanicien']->photo === null){
                        $path= public_path('storage/images/mecanicien/default.jpeg');
                    }
                    ?>
                    <img width="50px" height="50px" src="{{$path }}" alt="mecanicien "/>
                </td>
                <td>{{ $l['mecanicien']->nom.' '.$l['mecanicien']->prenom }}</td>
                <td>{{ $l['mecanicien']->adresse }}</td>
                <td>{{ $l['mecanicien']->numero_telephone }}</td>
                <td style='color:blue; font-weight:bold;text-decoration:underline;'>{{ $l['mecanicien']->email }}</td>
                <td>{{ $l['created_at'] }}</td>
                <td>{{ $l['updated_at'] }}</td>
                <td style='color:red; font-weight:bold;'> {{ $l['deleted_at'] }}</td>
            </tr>
            @endforeach
        </table>

    </body>
</html>
