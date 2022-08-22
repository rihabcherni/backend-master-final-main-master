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
        <h2 style="text-align: center;">Détails fournisseur: {{ $nom }}  {{ $prenom }}</h2>
        <br/>
        <div>
            <?php $url = 'storage/images/fournisseur/'.$photo;
                $path= public_path($url);
                if(! file_exists($path) || $photo === null){
                    $path= public_path('storage/images/fournisseur/default.jpeg');
                }
            ?>
            <img class="img-container" src="{{ $path }}" alt="fournisseur"/>
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
                    <th>CIN:</th>
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
            </table>

            <br/>

            @if (count($Liste_matieres)!==0)
                <table style="margin:10px auto;">
                    <th colspan='5' style='text-align:center; color:green; font-size:18px;'>Liste des matieres primaires fournie par ce fournisseur:</th>
                    <tr>
                        <th>N° matiere:</th>
                        <th>Nom:</th>
                        <th>Prix unitaire:</th>
                        <th>Quantité:</th>
                        <th>Prix total:</th>
                    </tr>
                    @foreach ($Liste_matieres as $matiere)
                    <tr>
                        <td>{{ $matiere['id'] }}</td>
                        <td>{{ $matiere['nom_materiel']}}</td>
                        <td>{{ $matiere['prix_unitaire']}} DT</td>
                        <td>{{ $matiere['quantite']}}</td>
                        <td>{{ $matiere['prix_total']}} DT</td>
                    </tr>
                    @endforeach
                </table>
            @endif
        </div>

    </body>
</html>
