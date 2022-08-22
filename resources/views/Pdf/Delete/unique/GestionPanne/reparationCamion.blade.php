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
        <h2 style="text-align: center;">Détails panne camion:</h2>
        <div>
            <table class="table">
                <tr>
                    <th colspan="2">Identifiant:</th>
                    <td>{{$id}}</td>
                </tr>
                <tr>
                    <th rowspan="5" >Détails panne</th>
                    <th>Image panne</th>
                    <td>
                        <?php $url = 'storage/trashImages/panneCamion/'.$image_panne_camion;
                            $path= public_path($url);
                            if(! file_exists($path) || $image_panne_camion === null){
                                $path= public_path('storage/trashImages/panneCamion/default.jpeg');
                            }
                        ?>
                        <img class="img-container" src="{{ $path }}" alt="panne camion"/>
                    </td>
                </tr>
                <tr>
                    <th>Description panne</th>
                    <td>{{$description_panne}}</td>
                </tr>
                <tr>
                    <th>cout</th>
                    <td>{{$cout}}</td>
                </tr>
                <tr>
                    <th>Date debut reparation</th>
                    <td>{{$date_debut_reparation}}</td>
                </tr>
                <tr>
                    <th>Date fin reparation</th>
                    <td>{{$date_fin_reparation}}</td>
                </tr>

                <tr>
                    <th rowspan="2">Camion:</th>
                    <th>ID: </th>
                    <td>{{$camion_id}}</td>
                </tr>
                <tr>
                    <th>Matricule: </th>
                    <td>{{$matricule}}</td>
                </tr>
                <tr>
                    <th rowspan="6">Mecanicien:</th>
                    <th>ID: </th>
                    <td>{{$mecanicien_id}}</td>
                </tr>
                <tr>
                    <th>Nom et prénom: </th>
                    <td>{{$mecanicien_nom_prenom}}</td>
                </tr>
                <tr>
                    <th>Carte identité national: </th>
                    <td>{{$mecanicien_CIN}}</td>
                </tr>
                <tr>
                    <th>E-mail: </th>
                    <td style='color:blue; font-weight:bold;text-decoration:underline;'>{{ $mecanicien->email }}</td>
                </tr>
                <tr>
                    <th>Numéro télephone: </th>
                    <td>{{$mecanicien->numero_telephone}}</td>
                </tr>
                <tr>
                    <th>Adresse:</th>
                    <td>{{$mecanicien->adresse}}</td>
                </tr>
                <tr>
                    <th colspan="2">Date de création:</th>
                    <td>{{$created_at}}</td>
                </tr>

                <tr>
                    <th colspan="2">Date de dernier modification: </th>
                    <td>{{$updated_at}}</td>
                </tr>
                <tr>
                    <th style='background-color:red; color:white;'>Date de suppression</th>
                    <td style='color:red;'>{{$deleted_at}}</td>
                </tr>
            </table>
        </div>

    </body>
</html>
