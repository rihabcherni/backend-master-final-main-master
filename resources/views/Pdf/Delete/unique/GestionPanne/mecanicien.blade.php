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
            .img-container{
                border-radius: 20px;
                border:2px rgb(186, 41, 205) dashed;
                width: 180px;
                height: 180px;
            }
            .page{
                padding:20px;
            }
            table{
                border:1px solid;
                width:480px;
            }
             td , th{
                border:1px solid;
                font-size:14px;
                padding:10px;
                text-align: left;
            }
            .table{
                margin:-190px 0 0 210px;
            }
        </style>
    </head>
    <body class="page"  >
        <img class="img-logo" src="{{ public_path('images/logo.png') }}" alt="logo" width="50px" height="50px"/>
        <p class='date'>{{ date('d-m-Y H:i:s') }}</p>
        <hr/>
        <br/>
        <h2 style="text-align: center;">Détails mecanicien: {{ $nom }}  {{ $prenom }}</h2>
        <br/>
        <div>
            <?php $url = 'storage/trashImages/mecanicien/'.$photo;
                $path= public_path($url);
                if(! file_exists($path) || $photo === null){
                    $path= public_path('storage/trashImages/mecanicien/default.jpeg');
                }
            ?>
            <img class="img-container" src="{{ $path }}" alt="mecanicien"/>
            <table class="table">
                <tr>
                    <th>Identifiant:</th>
                    <td>{{$id}}</td>
                </tr>
                <tr>
                    <th>Nom: </th>
                    <td>{{ $nom }}</td>
                </tr>
                <tr>
                    <th>Prénom: </th>
                    <td>{{ $prenom }}</td>
                </tr>
                <tr>
                    <th>Carte identité national: </th>
                    <td>{{ $CIN }}</td>
                </tr>
                <tr>
                    <th>Adresse:</th>
                    <td>{{ $adresse }}</td>
                </tr>
                <tr>
                    <th>Numéro télephone:</th>
                    <td>{{ $numero_telephone }}</td>
                </tr>
                <tr>
                    <th>E-mail:</th>
                    <td style='color:blue; font-weight:bold;text-decoration:underline;'> {{ $email }}</td>
                </tr>

                <tr>
                    <th>Date de création:</th>
                    <td>{{$created_at}}</td>
                </tr>
                <tr>
                    <th>Date de dernier modification: </th>
                    <td>{{$updated_at}}</td>
                </tr>
                <tr>
                    <th style='background-color:red; color:white;'>Date de suppression</th>
                    <td style='color:red;'>{{$deleted_at}}</td>
                </tr>
            </table>
            <br/>
            @if (count($Liste_camions_repares)!==0)
                <table>
                    <th colspan='8' style='text-align:center; color:green; font-size:18px;'>Liste des camions réparés par ce mécanicien:</th>
                    <tr>
                        <th>N° panne:</th>
                        <th>N° camion:</th>
                        <th>Matricule:</th>
                        <th>Image panne:</th>
                        <th>Description panne:</th>
                        <th>Cout:</th>
                        <th>Date debut reparation:</th>
                        <th>Date fin reparation:</th>
                    </tr>
                    @foreach ($Liste_camions_repares as $panne)
                    <tr>
                        <td>{{ $panne['id'] }}</td>
                        <td>{{ $panne['id_camion'] }}</td>
                        <td>{{ $panne['matricule']}}</td>
                        <td>
                            <?php $url = 'storage/images/panneCamion/'.$panne['image_panne_camion'];
                            $path= public_path($url);
                            if(! file_exists($path) ||  $panne['image_panne_camion'] === null){
                                $path= public_path('storage/images/panneCamion/default.jpeg');
                            }
                            ?>
                            <img  style='border-radius: 20px; width: 120px; height: 120px;' src="{{$path }}" alt="panne camion"/>
                        </td>
                        <td>{{ $panne['description_panne'] }}</td>
                        <td>{{ $panne['cout'] }} DT</td>
                        <td>{{ $panne['date_debut_reparation'] }}</td>
                        <td>{{ $panne['date_fin_reparation'] }}</td>
                    </tr>
                    @endforeach
                </table>
            @endif
        </div>

    </body>
</html>
