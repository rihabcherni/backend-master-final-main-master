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
            .table{
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
        <h2 style="text-align: center;">Détails panne poubelle:</h2>
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
                        <?php $url = 'storage/trashImages/pannePoubelle/'.$image_panne_poubelle;
                            $path= public_path($url);
                            if(! file_exists($path) || $image_panne_poubelle === null){
                                $path= public_path('storage/trashImages/pannePoubelle/default.jpeg');
                            }
                        ?>
                        <img width="100px" height="100px" src="{{ $path }}" alt="panne poubelle"/>
                    </td>
                </tr>
                <tr>
                    <th>Description panne</th>
                    <td>{{$description_panne}}</td>
                </tr>
                <tr>
                    <th>cout</th>
                    <td>{{$cout}} DT</td>
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
                    <th rowspan="3">Poubelle:</th>
                    <th>ID: </th>
                    <td>{{$poubelle_id}}</td>
                </tr>
                <tr>
                    <th>Nom: </th>
                    <td>{{$nom_poubelle}}</td>
                </tr>
                <tr>
                    <th>Type: </th>
                    <td>{{$type}}</td>
                </tr>


                <tr>
                    <th rowspan="5">Reparateur poubelle:</th>
                    <th>ID: </th>
                    <td>{{$reparateur_poubelle_id}}</td>
                </tr>
                <tr>
                    <th>Nom et prénom: </th>
                    <td>{{$reparateur_nom_prenom}}</td>
                </tr>
                <tr>
                    <th>E-mail: </th>
                    <td style='color:blue; font-weight:bold;text-decoration:underline;'>{{ $reparateur_poubelle->email }}</td>
                </tr>
                <tr>
                    <th>Numéro télephone: </th>
                    <td>{{$reparateur_poubelle->numero_telephone}}</td>
                </tr>
                <tr>
                    <th>Adresse:</th>
                    <td>{{$reparateur_poubelle->adresse}}</td>
                </tr>
            /*****************                         **************************/
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
